<?php

namespace App\Http\Controllers;

use App\Models\DesignFactor;
use App\Models\DesignFactorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignFactorController extends Controller
{
    /**
     * Display the design factor calculator page.
     */
    /**
     * Display the design factor calculator page.
     */
    public function index($type = 'DF1')
    {
        $user = Auth::user();

        // Get or create specific factor type for current user
        $designFactor = DesignFactor::where('user_id', $user->id)
            ->where('factor_type', $type)
            ->first();

        if (!$designFactor) {
            // Create new design factor with default inputs
            $designFactor = DesignFactor::create([
                'user_id' => $user->id,
                'factor_type' => $type,
                'factor_name' => match ($type) {
                    'DF1' => 'Enterprise Strategy',
                    'DF2' => 'Enterprise Goals',
                    'DF3' => 'Risk Profile',
                    'DF4' => 'IT-Related Issues',
                    default => 'Unknown Factor',
                },
                'inputs' => DesignFactor::getDefaultInputs($type),
            ]);

            // Create default COBIT items and mapping scores for this factor
            foreach (DesignFactor::getDefaultCobitItems($type) as $item) {
                $designFactor->items()->create($item);
            }
        }

        // Load items
        $designFactor->load('items');

        // Initial calculation update for view
        foreach ($designFactor->items as $item) {
            $item->relative_importance = $designFactor->calculateRelativeImportance(
                $item->score,
                $item->baseline_score
            );
        }

        $avgImp = $designFactor->getAverageImportance();
        $weight = $designFactor->getWeightedFactor();
        $metadata = DesignFactor::getMetadata($type);

        return view('design-factors.index', compact('designFactor', 'avgImp', 'weight', 'metadata', 'type'));
    }

    /**
     * Store/Update design factor data.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('factor_type', 'DF1');

        $validated = $request->validate([
            'factor_type' => 'required|string',
            'inputs' => 'required|array',
            'items' => 'sometimes|array',
        ]);

        // Update or create design factor
        $designFactor = DesignFactor::updateOrCreate(
            [
                'user_id' => $user->id,
                'factor_type' => $type,
            ],
            [
                'inputs' => $validated['inputs'],
                'factor_name' => match ($type) {
                    'DF1' => 'Enterprise Strategy',
                    'DF2' => 'Enterprise Goals',
                    'DF3' => 'Risk Profile',
                    'DF4' => 'IT-Related Issues',
                    default => 'Unknown Factor',
                },
            ]
        );

        // Update items if provided (though usually read-only for DF2)
        if (isset($validated['items'])) {
            $designFactor->items()->delete();
            foreach ($validated['items'] as $itemData) {
                $designFactor->items()->create([
                    'code' => $itemData['code'],
                    'score' => $itemData['score'],
                    'baseline_score' => $itemData['baseline_score'],
                    'relative_importance' => $designFactor->calculateRelativeImportance(
                        $itemData['score'],
                        $itemData['baseline_score']
                    ),
                ]);
            }
        }

        return redirect()->route('design-factors.index', ['type' => $type])
            ->with('success', "Data Design Factor $type berhasil disimpan!");
    }

    /**
     * Calculate values via AJAX.
     */
    public function calculate(Request $request)
    {
        $type = $request->input('factor_type', 'DF1');
        $inputs = $request->input('inputs', []);
        $itemsData = $request->input('items', []);

        // Create a temporary instance for calculation or use request data
        $tempDf = new DesignFactor();
        $tempDf->factor_type = $type;
        $tempDf->inputs = $inputs;

        $avgImp = $tempDf->getAverageImportance();
        $avgBase = $tempDf->getAverageBaseline();
        $weight = $tempDf->getWeightedFactor();

        $items = [];
        foreach ($itemsData as $item) {
            $score = floatval($item['score'] ?? 0);
            $baselineScore = floatval($item['baseline_score'] ?? 0);

            $items[] = [
                'code' => $item['code'],
                'score' => $score,
                'baseline_score' => $baselineScore,
                'relative_importance' => $tempDf->calculateRelativeImportance($score, $baselineScore),
            ];
        }

        return response()->json([
            'avgImp' => round($avgImp, 2),
            'weight' => round($weight, 6),
            'items' => $items,
        ]);
    }

    /**
     * Delete an objective item (not used in DF1/DF2 but kept for compatibility)
     */
    public function deleteItem(DesignFactorItem $item)
    {
        if ($item->designFactor->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $item->delete();
        return response()->json(['success' => true]);
    }
}
