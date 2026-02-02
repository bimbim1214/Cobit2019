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
                    'DF6' => 'Threat Landscape',
                    'DF7' => 'Importance of Role of IT',
                    'DF8' => 'Importance of Sourcing Model',
                    'DF9' => 'Importance of IT Implementation',
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
        $df6Mapping = ($type === 'DF6') ? DesignFactor::getDF6Mapping() : [];
        $df7Mapping = ($type === 'DF7') ? DesignFactor::getDF7Mapping() : [];
        $df8Mapping = ($type === 'DF8') ? DesignFactor::getDF8Mapping() : [];
        $df9Mapping = ($type === 'DF9') ? DesignFactor::getDF9Mapping() : [];
        $df10Mapping = ($type === 'DF10') ? DesignFactor::getDF10Mapping() : [];

        return view('design-factors.index', compact('designFactor', 'avgImp', 'weight', 'metadata', 'type', 'df6Mapping', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping'));
    }

    /**
     * Store/Update design factor data.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('factor_type', 'DF1');

        // Special case for DF5 saving
        if ($type === 'DF5') {
            $validated = $request->validate([
                'importance_high' => 'required|numeric|min:0|max:100',
                'importance_normal' => 'required|numeric|min:0|max:100',
            ]);

            $sum = $validated['importance_high'] + $validated['importance_normal'];
            if (abs($sum - 100.00) > 0.01) {
                return redirect()->route('design-factors.index', ['type' => 'DF5'])
                    ->with('error', 'Total importance harus tepat 100%! (Saat ini: ' . number_format($sum, 2) . '%)');
            }

            \App\Models\DesignFactor5::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'importance_high' => $validated['importance_high'],
                    'importance_normal' => $validated['importance_normal'],
                ]
            );

            return redirect()->route('design-factors.index', ['type' => 'DF5'])
                ->with('success', "Design Factor DF5 berhasil disimpan.");
        }

        // Check if this DF is locked
        $existingDF = DesignFactor::where('user_id', $user->id)
            ->where('factor_type', $type)
            ->first();

        if ($existingDF && $existingDF->is_locked) {
            return redirect()->route('design-factors.index', ['type' => $type])
                ->with('error', "Design Factor $type sudah terkunci dan tidak dapat diubah.");
        }
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
                    'DF6' => 'Threat Landscape',
                    'DF7' => 'Importance of Role of IT',
                    'DF8' => 'Importance of Sourcing Model',
                    'DF9' => 'Importance of IT Implementation',
                    'DF10' => 'Technology Adoption Strategy',
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

    /**
     * Display summary of all Design Factors
     */
    public function summary()
    {
        $user = Auth::user();

        // Fetch all 4 Design Factors for the current user
        $df1 = DesignFactor::where('user_id', $user->id)->where('factor_type', 'DF1')->first();
        $df2 = DesignFactor::where('user_id', $user->id)->where('factor_type', 'DF2')->first();
        $df3 = DesignFactor::where('user_id', $user->id)->where('factor_type', 'DF3')->first();
        $df4 = DesignFactor::where('user_id', $user->id)->where('factor_type', 'DF4')->first();

        // Create default if not exists
        if (!$df1) {
            $df1 = $this->createDefaultDesignFactor($user->id, 'DF1');
        }
        if (!$df2) {
            $df2 = $this->createDefaultDesignFactor($user->id, 'DF2');
        }
        if (!$df3) {
            $df3 = $this->createDefaultDesignFactor($user->id, 'DF3');
        }
        if (!$df4) {
            $df4 = $this->createDefaultDesignFactor($user->id, 'DF4');
        }

        // Load items for each DF
        $df1->load('items');
        $df2->load('items');
        $df3->load('items');
        $df4->load('items');

        // Check if all are completed or locked
        $dFactors = [$df1, $df2, $df3, $df4];
        $allCompleted = true;
        foreach ($dFactors as $df) {
            if (!$df->is_completed) {
                $allCompleted = false;
                break;
            }
        }

        // Fetch DF5 data
        $df5 = \App\Models\DesignFactor5::where('user_id', $user->id)->first();
        $df5Completed = (bool) $df5;

        // Is summary already locked?
        $summaryLocked = (isset($df1) && $df1->is_locked);

        // Aggregate Relative Importance from all 5 Design Factors
        $aggregatedResults = [];

        // Combine DF1-DF4 items
        foreach ($dFactors as $df) {
            foreach ($df->items as $item) {
                if (!isset($aggregatedResults[$item->code])) {
                    $aggregatedResults[$item->code] = 0;
                }
                $aggregatedResults[$item->code] += $item->relative_importance;
            }
        }

        // Add DF5 relative importance if completed
        if ($df5Completed) {
            $df5Results = $df5->calculateRelativeImportance();
            foreach ($df5Results as $code => $importance) {
                if (!isset($aggregatedResults[$code])) {
                    $aggregatedResults[$code] = 0;
                }
                $aggregatedResults[$code] += $importance;
            }
        }

        // Initial Scope Management (Positive aggregated scores)
        $initialScope = array_filter($aggregatedResults, function ($val) {
            return $val > 0;
        });

        arsort($initialScope);

        return view('design-factors.summary', compact(
            'df1',
            'df2',
            'df3',
            'df4',
            'df5',
            'df5Completed',
            'allCompleted',
            'summaryLocked',
            'aggregatedResults',
            'initialScope'
        ));
    }

    /**
     * Lock all Design Factors after viewing summary.
     */
    public function lockSummary()
    {
        $user = Auth::user();
        $dfTypes = ['DF1', 'DF2', 'DF3', 'DF4', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];

        foreach ($dfTypes as $type) {
            DesignFactor::where('user_id', $user->id)
                ->where('factor_type', $type)
                ->update(['is_locked' => true]);
        }

        // Lock DF5
        \App\Models\DesignFactor5::where('user_id', $user->id)
            ->update(['is_locked' => true]);

        return redirect()->route('design-factors.summary')
            ->with('success', "Seluruh Design Factor telah dikunci secara permanen.");
    }

    /**
     * Helper to create default DF
     */
    private function createDefaultDesignFactor($user_id, $type)
    {
        $df = DesignFactor::create([
            'user_id' => $user_id,
            'factor_type' => $type,
            'factor_name' => match ($type) {
                'DF1' => 'Enterprise Strategy',
                'DF2' => 'Enterprise Goals',
                'DF3' => 'Risk Profile',
                'DF4' => 'IT-Related Issues',
                'DF6' => 'Threat Landscape',
                'DF7' => 'Importance of Role of IT',
                'DF8' => 'Importance of Sourcing Model',
                'DF9' => 'Importance of IT Implementation',
                'DF10' => 'Technology Adoption Strategy',
                default => 'Unknown Factor',
            },
            'inputs' => DesignFactor::getDefaultInputs($type),
            'is_completed' => false,
            'is_locked' => false,
        ]);

        $defaultItems = DesignFactor::getDefaultCobitItems($type);
        foreach ($defaultItems as $item) {
            $df->items()->create($item);
        }

        return $df;
    }

    /**
     * Display DF5 page
     */
    public function showDf5()
    {
        $user = Auth::user();

        // Get or create DF5 for current user
        $df5 = \App\Models\DesignFactor5::where('user_id', $user->id)->first();

        // Get all DF5 map data
        $df5MapData = \App\Models\Df5Map::orderBy('objective_code')->get();

        // Always calculate results (use default values if DF5 doesn't exist)
        $scores = [];
        $baselineScores = [];
        $relativeImportance = [];

        if ($df5) {
            // Use actual user data
            $scores = $df5->calculateScores();
            $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
            $relativeImportance = $df5->calculateRelativeImportance();
        } else {
            // Use default values (50/50 split)
            $tempDf5 = new \App\Models\DesignFactor5();
            $tempDf5->importance_high = "50.00";
            $tempDf5->importance_normal = "50.00";

            $scores = $tempDf5->calculateScores();
            $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
            $relativeImportance = $tempDf5->calculateRelativeImportance();
        }

        // Build results array for all 40 objectives
        $results = [];
        foreach ($df5MapData as $map) {
            $code = $map->objective_code;
            $results[] = [
                'code' => $code,
                'name' => $map->objective_name,
                'score' => $scores[$code] ?? 0,
                'baseline_score' => $baselineScores[$code] ?? 0,
                'relative_importance' => $relativeImportance[$code] ?? 0,
            ];
        }

        return view('design-factors.df5', compact('df5', 'df5MapData', 'results'));
    }

    /**
     * Save DF5 data
     */
    public function saveDf5(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'importance_high' => 'required|numeric|min:0|max:100',
            'importance_normal' => 'required|numeric|min:0|max:100',
        ]);

        // Check if sum equals 100
        $sum = $validated['importance_high'] + $validated['importance_normal'];
        if (abs($sum - 100.00) > 0.01) {
            return redirect()->route('design-factors.df5')
                ->with('error', 'Total importance harus tepat 100%! (Saat ini: ' . number_format($sum, 2) . '%)');
        }

        // Update or create DF5
        \App\Models\DesignFactor5::updateOrCreate(
            ['user_id' => $user->id],
            [
                'importance_high' => (string) $validated['importance_high'],
                'importance_normal' => (string) $validated['importance_normal'],
            ]
        );

        return redirect()->route('design-factors.df5')
            ->with('success', 'Data DF5 berhasil disimpan!');
    }

    /**
     * Calculate DF5 via AJAX
     */
    public function calculateDf5(Request $request)
    {
        $importanceHigh = floatval($request->input('importance_high', 50));
        $importanceNormal = floatval($request->input('importance_normal', 50));

        // Create temporary DF5 instance for calculation
        $tempDf5 = new \App\Models\DesignFactor5();
        $tempDf5->importance_high = (string) $importanceHigh;
        $tempDf5->importance_normal = (string) $importanceNormal;

        // Calculate scores
        $scores = $tempDf5->calculateScores();
        $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
        $relativeImportance = $tempDf5->calculateRelativeImportance();

        // Get all objectives
        $df5MapData = \App\Models\Df5Map::orderBy('objective_code')->get();

        $results = [];
        foreach ($df5MapData as $map) {
            $code = $map->objective_code;
            $results[] = [
                'code' => $code,
                'name' => $map->objective_name,
                'score' => round($scores[$code] ?? 0, 2),
                'baseline_score' => round($baselineScores[$code] ?? 0, 2),
                'relative_importance' => $relativeImportance[$code] ?? 0,
            ];
        }

        return response()->json([
            'success' => true,
            'total' => $importanceHigh + $importanceNormal,
            'results' => $results,
        ]);
    }
}
