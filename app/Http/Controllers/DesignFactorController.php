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

        // Check if user can access this DF type
        if (!DesignFactor::canAccess($user->id, $type)) {
            return redirect()->route('design-factors.index', 'DF1')
                ->with('error', 'Anda harus menyelesaikan Design Factor sebelumnya terlebih dahulu.');
        }

        // Handle DF5 as a special case
        if ($type === 'DF5') {
            $df5 = \App\Models\DesignFactor5::where('user_id', $user->id)->first();
            $df5MapData = \App\Models\Df5Map::orderBy('objective_code')->get();

            // Always calculate results (use default values if DF5 doesn't exist)
            $results = [];
            if ($df5) {
                $scores = $df5->calculateScores();
                $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
                $relativeImportance = $df5->calculateRelativeImportance();
            } else {
                $tempDf5 = new \App\Models\DesignFactor5();
                $tempDf5->importance_high = "50.00";
                $tempDf5->importance_normal = "50.00";
                $scores = $tempDf5->calculateScores();
                $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
                $relativeImportance = $tempDf5->calculateRelativeImportance();
                $df5 = $tempDf5; // Use temp for view defaults
            }

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

            $results = collect($results); // Make it a collection for easier use in view
            $progress = DesignFactor::getProgress($user->id);

            return view('design-factors.index', compact('df5', 'df5MapData', 'results', 'type', 'progress'));
        }

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

        // Get progress data for visual indicators
        $progress = DesignFactor::getProgress($user->id);

        return view('design-factors.index', compact('designFactor', 'avgImp', 'weight', 'metadata', 'type', 'progress'));
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

            // Validation for sum = 100%
            $sum = $validated['importance_high'] + $validated['importance_normal'];
            if (abs($sum - 100.00) > 0.01) {
                return redirect()->route('design-factors.index', ['type' => 'DF5'])
                    ->with('error', 'Total importance harus sama dengan 100%! (Saat ini: ' . $sum . '%)');
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

        // Refresh the model to get updated inputs
        $designFactor->refresh();

        // Mark as completed if all fields are filled
        if ($designFactor->isFullyFilled()) {
            $designFactor->is_completed = true;
            $designFactor->save();
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

        // Calculate relative importance for each DF
        foreach ($df1->items as $item) {
            $item->relative_importance = $df1->calculateRelativeImportance($item->score, $item->baseline_score);
        }
        foreach ($df2->items as $item) {
            $item->relative_importance = $df2->calculateRelativeImportance($item->score, $item->baseline_score);
        }
        foreach ($df3->items as $item) {
            $item->relative_importance = $df3->calculateRelativeImportance($item->score, $item->baseline_score);
        }
        foreach ($df4->items as $item) {
            $item->relative_importance = $df4->calculateRelativeImportance($item->score, $item->baseline_score);
        }

        // Get DF5 Results
        $df5 = \App\Models\DesignFactor5::where('user_id', $user->id)->first();
        $df5Results = [];
        if ($df5) {
            $df5Results = $df5->calculateRelativeImportance();
        } else {
            // Default 50/50
            $tempDf5 = new \App\Models\DesignFactor5(['importance_high' => 50, 'importance_normal' => 50]);
            $df5Results = $tempDf5->calculateRelativeImportance();
        }

        // Create aggregated data structure
        $summaryData = [];

        // Get all unique objective codes (should be 40)
        $allCodes = $df1->items->pluck('code')->unique()->values();

        foreach ($allCodes as $code) {
            $df1Item = $df1->items->firstWhere('code', $code);
            $df2Item = $df2->items->firstWhere('code', $code);
            $df3Item = $df3->items->firstWhere('code', $code);
            $df4Item = $df4->items->firstWhere('code', $code);

            $df1Value = $df1Item ? $df1Item->relative_importance : 0;
            $df2Value = $df2Item ? $df2Item->relative_importance : 0;
            $df3Value = $df3Item ? $df3Item->relative_importance : 0;
            $df4Value = $df4Item ? $df4Item->relative_importance : 0;
            $df5Value = $df5Results[$code] ?? 0;

            // Calculate Initial Scope: Governance using the provided formula
            // Weights are all 1, max values are 140 and 70
            $weights = [1, 1, 1, 1, 1];
            $values = [$df1Value, $df2Value, $df3Value, $df4Value, $df5Value];

            $sumProduct = 0;
            for ($i = 0; $i < 5; $i++) {
                $sumProduct += $weights[$i] * $values[$i];
            }

            $maxValue = max(140, 70); // = 140
            $calculated = 100 * $sumProduct / $maxValue;
            $truncated = floor($calculated);

            if ($truncated >= 0) {
                $initialScope = round($truncated / 5) * 5;
            } else {
                $initialScope = round($truncated / -5) * -5;
            }

            $summaryData[] = [
                'code' => $code,
                'name' => $this->getObjectiveName($code),
                'df1' => $df1Value,
                'df2' => $df2Value,
                'df3' => $df3Value,
                'df4' => $df4Value,
                'df5' => $df5Value,
                'initial_scope' => $initialScope,
            ];
        }

        // Get progress data for visual indicators
        $progress = DesignFactor::getProgress($user->id);

        return view('design-factors.summary', compact('summaryData', 'progress'));
    }

    /**
     * Lock all Design Factors permanently after Summary is saved
     * Only locks DF1-DF4 (not DF5)
     */
    public function lockSummary(Request $request)
    {
        $user = Auth::user();

        // Check if DF1-DF4 are completed (not including DF5)
        $allCompleted = true;
        foreach (['DF1', 'DF2', 'DF3', 'DF4'] as $type) {
            $df = DesignFactor::where('user_id', $user->id)
                ->where('factor_type', $type)
                ->first();

            if (!$df || !$df->is_completed) {
                $allCompleted = false;
                break;
            }
        }

        if (!$allCompleted) {
            return redirect()->route('design-factors.summary')
                ->with('error', 'Semua Design Factor (DF1-DF4) harus diselesaikan terlebih dahulu.');
        }

        // Lock only DF1-DF4 (not DF5)
        DesignFactor::where('user_id', $user->id)
            ->whereIn('factor_type', ['DF1', 'DF2', 'DF3', 'DF4'])
            ->update(['is_locked' => true]);

        return redirect()->route('design-factors.summary')
            ->with('success', 'Summary berhasil disimpan! Design Factors DF1-DF4 sekarang terkunci. DF5 masih dapat diakses dan diubah.');
    }

    /**
     * Helper method to create default Design Factor
     */
    private function createDefaultDesignFactor($userId, $type)
    {
        $designFactor = DesignFactor::create([
            'user_id' => $userId,
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

        // Create default COBIT items
        foreach (DesignFactor::getDefaultCobitItems($type) as $item) {
            $designFactor->items()->create($item);
        }

        return $designFactor;
    }

    /**
     * Reset all Design Factors for the current user
     */
    public function resetAll(Request $request)
    {
        $user = Auth::user();

        // Delete all Design Factors and their items for this user
        $designFactors = DesignFactor::where('user_id', $user->id)->get();

        foreach ($designFactors as $df) {
            // Delete all items first
            $df->items()->delete();
            // Delete the design factor
            $df->delete();
        }

        return redirect()->route('design-factors.index', 'DF1')
            ->with('success', 'Semua Design Factor telah direset ke nilai default!');
    }

    /**
     * Get objective name from code
     */
    private function getObjectiveName($code)
    {
        $names = [
            'EDM01' => 'Ensured Governance Framework Setting & Maintenance',
            'EDM02' => 'Ensured Benefits Delivery',
            'EDM03' => 'Ensured Risk Optimization',
            'EDM04' => 'Ensured Resource Optimization',
            'EDM05' => 'Ensured Stakeholder Engagement',
            'APO01' => 'Managed I&T Management Framework',
            'APO02' => 'Managed Strategy',
            'APO03' => 'Managed Enterprise Architecture',
            'APO04' => 'Managed Innovation',
            'APO05' => 'Managed Portfolio',
            'APO06' => 'Managed Budget & Costs',
            'APO07' => 'Managed Human Resources',
            'APO08' => 'Managed Relationships',
            'APO09' => 'Managed Service Agreements',
            'APO10' => 'Managed Vendors',
            'APO11' => 'Managed Quality',
            'APO12' => 'Managed Risk',
            'APO13' => 'Managed Security',
            'APO14' => 'Managed Data',
            'BAI01' => 'Managed Programs',
            'BAI02' => 'Managed Requirements Definition',
            'BAI03' => 'Managed Solutions Identification & Build',
            'BAI04' => 'Managed Availability & Capacity',
            'BAI05' => 'Managed Organizational Change',
            'BAI06' => 'Managed IT Changes',
            'BAI07' => 'Managed IT Change Acceptance and Transitioning',
            'BAI08' => 'Managed Knowledge',
            'BAI09' => 'Managed Assets',
            'BAI10' => 'Managed Configuration',
            'BAI11' => 'Managed Projects',
            'DSS01' => 'Managed Operations',
            'DSS02' => 'Managed Service Requests & Incidents',
            'DSS03' => 'Managed Problems',
            'DSS04' => 'Managed Continuity',
            'DSS05' => 'Managed Security Services',
            'DSS06' => 'Managed Business Process Controls',
            'MEA01' => 'Managed Performance and Conformance Monitoring',
            'MEA02' => 'Managed System of Internal Control',
            'MEA03' => 'Managed Compliance with External Requirements',
            'MEA04' => 'Managed Assurance',
        ];

        return $names[$code] ?? $code;
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
                ->with('error', 'Total importance harus sama dengan 100%! (Saat ini: ' . $sum . '%)');
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
