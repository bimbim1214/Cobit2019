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
    public function index($type = 'DF1')
    {
        $user = Auth::user();

        // Specific handling for DF5
        if ($type === 'DF5') {
            $df5 = \App\Models\DesignFactor5::where('user_id', $user->id)->first();
            $df5MapData = \App\Models\Df5Map::orderBy('objective_code')->get();

            $scores = [];
            $baselineScores = [];
            $relativeImportance = [];

            if ($df5) {
                $scores = $df5->calculateScores();
                $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
                $relativeImportance = $df5->calculateRelativeImportance();
            } else {
                $tempDf5 = new \App\Models\DesignFactor5();
                $tempDf5->importance_high = 50.00;
                $tempDf5->importance_normal = 50.00;
                $scores = $tempDf5->calculateScores();
                $baselineScores = \App\Models\DesignFactor5::calculateBaselineScores();
                $relativeImportance = $tempDf5->calculateRelativeImportance();
            }

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

            $factorInfo = DesignFactor::getFactorInfo('DF5');
            $progress = DesignFactor::getProgress($user->id);

            // Pass empty/default values for other expected variables in index.blade.php
            $designFactor = new DesignFactor(['factor_type' => 'DF5']);
            $avgImp = 0;
            $weight = 0;
            $metadata = [];
            $df4Mapping = [];
            $df6Mapping = [];
            $df7Mapping = [];
            $df8Mapping = [];
            $df9Mapping = [];
            $df10Mapping = [];

            return view('design-factors.index', compact('df5', 'results', 'factorInfo', 'progress', 'type', 'designFactor', 'avgImp', 'weight', 'metadata', 'df4Mapping', 'df6Mapping', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping'));
        }

        // Specific handling for DF6
        if ($type === 'DF6') {
            $df6 = \App\Models\DesignFactor6::where('user_id', $user->id)->first();
            $df6MapData = \App\Models\Df6Map::orderBy('objective_code')->get();

            $scores = [];
            $baselineScores = [];
            $relativeImportance = [];

            if ($df6) {
                $scores = $df6->calculateScores();
                $baselineScores = \App\Models\DesignFactor6::calculateBaselineScores();
                $relativeImportance = $df6->calculateRelativeImportance();
            } else {
                $tempDf6 = new \App\Models\DesignFactor6();
                $tempDf6->importance_high = 33.33;
                $tempDf6->importance_normal = 33.33;
                $tempDf6->importance_low = 33.34;
                $scores = $tempDf6->calculateScores();
                $baselineScores = \App\Models\DesignFactor6::calculateBaselineScores();
                $relativeImportance = $tempDf6->calculateRelativeImportance();
            }

            $results = [];
            foreach ($df6MapData as $map) {
                $code = $map->objective_code;
                $results[] = [
                    'code' => $code,
                    'name' => $map->objective_name,
                    'score' => $scores[$code] ?? 0,
                    'baseline_score' => $baselineScores[$code] ?? 0,
                    'relative_importance' => $relativeImportance[$code] ?? 0,
                ];
            }

            $factorInfo = DesignFactor::getFactorInfo('DF6');
            $progress = DesignFactor::getProgress($user->id);

            // Pass empty/default values for other expected variables in index.blade.php
            $designFactor = new DesignFactor(['factor_type' => 'DF6']);
            $avgImp = 0;
            $weight = 0;
            $metadata = [];
            $df4Mapping = [];
            $df5 = null;
            $df7Mapping = [];
            $df8Mapping = [];
            $df9Mapping = [];
            $df10Mapping = [];

            return view('design-factors.index', compact('df6', 'results', 'factorInfo', 'progress', 'type', 'designFactor', 'avgImp', 'weight', 'metadata', 'df4Mapping', 'df5', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping'));
        }

        // Specific handling for DF8
        if ($type === 'DF8') {
            $df8 = \App\Models\DesignFactor8::where('user_id', $user->id)->first();
            $df8MapData = \App\Models\Df8Map::orderBy('objective_code')->get();

            $scores = [];
            $baselineScores = [];
            $relativeImportance = [];

            if ($df8) {
                $scores = $df8->calculateScores();
                $baselineScores = \App\Models\DesignFactor8::calculateBaselineScores();
                $relativeImportance = $df8->calculateRelativeImportance();
            } else {
                $tempDf8 = new \App\Models\DesignFactor8();
                $tempDf8->importance_outsourcing = 33.00;
                $tempDf8->importance_cloud = 33.00;
                $tempDf8->importance_insourced = 34.00;
                $scores = $tempDf8->calculateScores();
                $baselineScores = \App\Models\DesignFactor8::calculateBaselineScores();
                $relativeImportance = $tempDf8->calculateRelativeImportance();
            }

            $results = [];
            foreach ($df8MapData as $map) {
                $code = $map->objective_code;
                $results[] = [
                    'code' => $code,
                    'name' => $map->objective_name,
                    'score' => $scores[$code] ?? 0,
                    'baseline_score' => $baselineScores[$code] ?? 0,
                    'relative_importance' => $relativeImportance[$code] ?? 0,
                ];
            }

            $factorInfo = DesignFactor::getFactorInfo('DF8');
            $progress = DesignFactor::getProgress($user->id);

            // Pass empty/default values for other expected variables in index.blade.php
            $designFactor = new DesignFactor(['factor_type' => 'DF8']);
            $avgImp = 0;
            $weight = 0;
            $metadata = [];
            $df4Mapping = [];
            $df5 = null;
            $df7Mapping = [];
            $df8Mapping = \App\Models\DesignFactor::getDF8Mapping();
            $df9Mapping = \App\Models\DesignFactor::getDF9Mapping();
            $df10Mapping = \App\Models\DesignFactor::getDF10Mapping();

            return view('design-factors.index', compact('df8', 'results', 'factorInfo', 'progress', 'type', 'designFactor', 'avgImp', 'weight', 'metadata', 'df4Mapping', 'df5', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping'));
        }

        // Specific handling for DF9
        if ($type === 'DF9') {
            // Get DF9 mapping data
            $df9MapData = \App\Models\Df9Map::orderBy('objective_code')->get();

            // Get existing or create new DF9 (MOVED UP)
            $designFactor = DesignFactor::where('user_id', $user->id)
                ->where('factor_type', 'DF9')
                ->first();

            if (!$designFactor) {
                $designFactor = new DesignFactor(['factor_type' => 'DF9']);
                $designFactor->inputs = DesignFactor::getDefaultInputs('DF9');
            }
            $designFactor->factor_type = 'DF9';

            // Get inputs for calculation
            $inputs = $designFactor->inputs ?? DesignFactor::getDefaultInputs('DF9');
            $importanceAgile = floatval($inputs['agile']['importance'] ?? 15.00);
            $importanceDevops = floatval($inputs['devops']['importance'] ?? 10.00);
            $importanceTraditional = floatval($inputs['traditional']['importance'] ?? 75.00);

            // Fixed weights for Baseline Score calculation
            $baselineAgile = 15.00;
            $baselineDevops = 10.00;
            $baselineTraditional = 75.00;

            // Calculate scores using MMULT formula
            $scores = [];
            $baselineScores = [];
            $relativeImportance = [];

            foreach ($df9MapData as $map) {
                $code = $map->objective_code;

                // MMULT calculation: Score = (Agile * Agile%) + (DevOps * DevOps%) + (Traditional * Traditional%)
                $score = ($map->agile * $importanceAgile / 100) +
                    ($map->devops * $importanceDevops / 100) +
                    ($map->traditional * $importanceTraditional / 100);

                // Baseline Score Calculation: (Agile% * 15) + (DevOps% * 10) + (Traditional% * 75)
                $baselineScore = ($map->agile * $baselineAgile / 100) +
                    ($map->devops * $baselineDevops / 100) +
                    ($map->traditional * $baselineTraditional / 100);

                $scores[$code] = $score;
                $baselineScores[$code] = $baselineScore;

                // Calculate relative importance
                $calculated = ($baselineScore > 0) ? (100 * $score) / $baselineScore : 0;
                $relativeImportance[$code] = (round($calculated / 5) * 5) - 100;
            }

            $results = [];
            foreach ($df9MapData as $map) {
                $code = $map->objective_code;
                $results[] = [
                    'code' => $code,
                    'name' => $map->objective_name,
                    'score' => $scores[$code] ?? 0,
                    'baseline_score' => $baselineScores[$code] ?? 0,
                    'relative_importance' => $relativeImportance[$code] ?? 0,
                ];
            }

            $factorInfo = DesignFactor::getFactorInfo('DF9');
            $progress = DesignFactor::getProgress($user->id);

            // Inputs already loaded above

            $avgImp = 0; // Not used for MMULT display but required variable
            $weight = 0; // Not used for MMULT display
            $metadata = DesignFactor::getMetadata('DF9');
            $df4Mapping = [];
            $df5 = null;
            $df6 = null;
            $df7Mapping = [];
            $df8Mapping = [];
            $df9Mapping = \App\Models\DesignFactor::getDF9Mapping();
            $df10Mapping = [];

            return view('design-factors.index', compact('results', 'factorInfo', 'progress', 'type', 'designFactor', 'avgImp', 'weight', 'metadata', 'df4Mapping', 'df5', 'df6', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping'));
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
                    'DF6' => 'Threat Landscape',
                    'DF7' => 'Importance of Role of IT',
                    'DF8' => 'Sourcing Model',
                    'DF9' => 'IT Implementation',
                    'DF10' => 'Tech Adoption',
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
        $df4Mapping = ($type === 'DF4') ? DesignFactor::getDF4Mapping() : [];
        $df6Mapping = ($type === 'DF6') ? DesignFactor::getDF6Mapping() : [];
        $df7Mapping = ($type === 'DF7') ? DesignFactor::getDF7Mapping() : [];
        $df8Mapping = ($type === 'DF8') ? DesignFactor::getDF8Mapping() : [];
        $df9Mapping = ($type === 'DF9') ? DesignFactor::getDF9Mapping() : [];
        $df10Mapping = ($type === 'DF10') ? DesignFactor::getDF10Mapping() : [];

        $factorInfo = DesignFactor::getFactorInfo($type);
        $progress = DesignFactor::getProgress($user->id);

        return view('design-factors.index', compact('designFactor', 'avgImp', 'weight', 'metadata', 'factorInfo', 'type', 'df4Mapping', 'df6Mapping', 'df7Mapping', 'df8Mapping', 'df9Mapping', 'df10Mapping', 'progress'));
    }

    /**
     * Store/Update design factor data.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('factor_type', 'DF1');

        // Handle DF5 specifically
        if ($type === 'DF5') {
            $validated = $request->validate([
                'importance_high' => 'required|numeric|min:0|max:100',
                'importance_normal' => 'required|numeric|min:0|max:100',
            ]);

            $sum = $validated['importance_high'] + $validated['importance_normal'];
            if (abs($sum - 100.00) > 0.01) {
                return redirect()->route('design-factors.index', 'DF5')
                    ->with('error', 'Total importance harus tepat 100%! (Saat ini: ' . number_format($sum, 2) . '%)');
            }

            \App\Models\DesignFactor5::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'importance_high' => $validated['importance_high'],
                    'importance_normal' => $validated['importance_normal'],
                ]
            );

            return redirect()->route('design-factors.index', 'DF5')
                ->with('success', 'Data DF5 berhasil disimpan!');
        }

        // Handle DF6 specifically
        if ($type === 'DF6') {
            $validated = $request->validate([
                'importance_high' => 'required|numeric|min:0|max:100',
                'importance_normal' => 'required|numeric|min:0|max:100',
                'importance_low' => 'required|numeric|min:0|max:100',
            ]);

            $sum = $validated['importance_high'] + $validated['importance_normal'] + $validated['importance_low'];
            if (abs($sum - 100.00) > 0.01) {
                return redirect()->route('design-factors.index', 'DF6')
                    ->with('error', 'Total importance harus tepat 100%! (Saat ini: ' . number_format($sum, 2) . '%)');
            }

            \App\Models\DesignFactor6::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'importance_high' => $validated['importance_high'],
                    'importance_normal' => $validated['importance_normal'],
                    'importance_low' => $validated['importance_low'],
                ]
            );

            return redirect()->route('design-factors.index', 'DF6')
                ->with('success', 'Data DF6 berhasil disimpan!');
        }

        // Handle DF8 specifically
        if ($type === 'DF8') {
            $validated = $request->validate([
                'importance_outsourcing' => 'required|numeric|min:0|max:100',
                'importance_cloud' => 'required|numeric|min:0|max:100',
                'importance_insourced' => 'required|numeric|min:0|max:100',
            ]);

            $sum = $validated['importance_outsourcing'] + $validated['importance_cloud'] + $validated['importance_insourced'];
            if (abs($sum - 100.00) > 0.01) {
                return redirect()->route('design-factors.index', 'DF8')
                    ->with('error', 'Total importance harus tepat 100%! (Saat ini: ' . number_format($sum, 2) . '%)');
            }

            \App\Models\DesignFactor8::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'importance_outsourcing' => $validated['importance_outsourcing'],
                    'importance_cloud' => $validated['importance_cloud'],
                    'importance_insourced' => $validated['importance_insourced'],
                ]
            );

            return redirect()->route('design-factors.index', 'DF8')
                ->with('success', 'Data DF8 berhasil disimpan!');
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
                'is_completed' => true,
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

        // Check if accessible (DF1-DF4 must be completed)
        if (!DesignFactor::canAccess($user->id, 'Summary')) {
            return redirect()->route('design-factors.index', 'DF4')
                ->with('error', 'Anda harus menyelesaikan DF1-DF4 terlebih dahulu.');
        }

        // Fetch DFs (DF1-DF4 for Step 2 Initial Scope)
        $dfs = [];
        $dfTypes = ['DF1', 'DF2', 'DF3', 'DF4'];
        foreach ($dfTypes as $t) {
            $df = DesignFactor::where('user_id', $user->id)->where('factor_type', $t)->first();
            if ($df) {
                $df->load('items');
                $dfs[$t] = $df->items->keyBy('code');
            }
        }

        // Progress info
        $progress = DesignFactor::getProgress($user->id);

        // Prepare Summary Data
        $summaryData = [];
        $defaultItems = DesignFactor::getDefaultCobitItems('DF1');

        foreach ($defaultItems as $defaultItem) {
            $code = $defaultItem['code'];

            // Get objective name
            $name = $this->getObjectiveName($code);

            $vals = [];
            $initialScope = 0;

            // Sum up ONLY DF1-DF4 for Step 2
            foreach (['DF1', 'DF2', 'DF3', 'DF4'] as $t) {
                $val = 0;
                if (isset($dfs[$t][$code])) {
                    $val = $dfs[$t][$code]->relative_importance;
                }
                $vals[strtolower($t)] = $val;
                $initialScope += $val;
            }

            $summaryData[] = array_merge([
                'code' => $code,
                'name' => $name,
                'initial_scope' => $initialScope,
            ], $vals);
        }

        return view('design-factors.summary', compact('summaryData', 'progress'));
    }

    /**
     * Helper to get objective names
     */
    private function getObjectiveName($code)
    {
        $names = [
            'EDM01' => 'Ensuring Governance Framework Setting and Maintenance',
            'EDM02' => 'Ensuring Benefits Delivery',
            'EDM03' => 'Ensuring Risk Optimization',
            'EDM04' => 'Ensuring Resource Optimization',
            'EDM05' => 'Ensuring Stakeholder Engagement',
            'APO01' => 'Managed I&T Management Framework',
            'APO02' => 'Managed Strategy',
            'APO03' => 'Managed Enterprise Architecture',
            'APO04' => 'Managed Innovation',
            'APO05' => 'Managed Portfolio',
            'APO06' => 'Managed Budget and Costs',
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
            'BAI03' => 'Managed Solutions Identification and Build',
            'BAI04' => 'Managed Availability and Capacity',
            'BAI05' => 'Managed Organizational Change',
            'BAI06' => 'Managed IT Changes',
            'BAI07' => 'Managed IT Change Acceptance and Transitioning',
            'BAI08' => 'Managed Knowledge',
            'BAI09' => 'Managed Assets',
            'BAI10' => 'Managed Configuration',
            'BAI11' => 'Managed Projects',
            'DSS01' => 'Managed Operations',
            'DSS02' => 'Managed Service Requests and Incidents',
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
     * Lock all Design Factors after viewing summary.
     */
    public function lockSummary()
    {
        $user = Auth::user();
        $dfTypes = ['DF1', 'DF2', 'DF3', 'DF4'];

        foreach ($dfTypes as $type) {
            DesignFactor::where('user_id', $user->id)
                ->where('factor_type', $type)
                ->update(['is_locked' => true]);
        }

        return redirect()->route('design-factors.summary')
            ->with('success', "Seluruh Design Factor telah dikunci secara permanen.");
    }

    /**
     * Reset all Design Factor data for the current user.
     */
    public function resetAll()
    {
        $user = Auth::user();

        \DB::transaction(function () use ($user) {
            // Delete all normal DesignFactors (DF1-DF10, excluding DF5 which has its own model)
            $dfs = DesignFactor::where('user_id', $user->id)->get();
            foreach ($dfs as $df) {
                // Delete related items first
                $df->items()->delete();
                // Delete the factor itself
                $df->delete();
            }

            // Delete specific DF5 data
            \App\Models\DesignFactor5::where('user_id', $user->id)->delete();

            // Delete specific DF6 data
            \App\Models\DesignFactor6::where('user_id', $user->id)->delete();

            // Delete specific DF8 data
            \App\Models\DesignFactor8::where('user_id', $user->id)->delete();
        });

        return redirect()->route('design-factors.index', 'DF1')
            ->with('success', 'Seluruh data Design Factor telah berhasil direset.');
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
     * Calculate DF5 via AJAX
     */
    public function calculateDf5(Request $request)
    {
        $importanceHigh = floatval($request->input('importance_high', 50));
        $importanceNormal = floatval($request->input('importance_normal', 50));

        // Create temporary DF5 instance for calculation
        $tempDf5 = new \App\Models\DesignFactor5();
        $tempDf5->importance_high = $importanceHigh;
        $tempDf5->importance_normal = $importanceNormal;

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

    /**
     * Calculate DF6 via AJAX
     */
    public function calculateDf6(Request $request)
    {
        $importanceHigh = floatval($request->input('importance_high', 33.33));
        $importanceNormal = floatval($request->input('importance_normal', 33.33));
        $importanceLow = floatval($request->input('importance_low', 33.34));

        // Create temporary DF6 instance for calculation
        $tempDf6 = new \App\Models\DesignFactor6();
        $tempDf6->importance_high = $importanceHigh;
        $tempDf6->importance_normal = $importanceNormal;
        $tempDf6->importance_low = $importanceLow;

        // Calculate scores
        $scores = $tempDf6->calculateScores();
        $baselineScores = \App\Models\DesignFactor6::calculateBaselineScores();
        $relativeImportance = $tempDf6->calculateRelativeImportance();

        // Get all objectives
        $df6MapData = \App\Models\Df6Map::orderBy('objective_code')->get();

        $results = [];
        foreach ($df6MapData as $map) {
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
            'total' => $importanceHigh + $importanceNormal + $importanceLow,
            'results' => $results,
        ]);
    }

    /**
     * Calculate DF8 via AJAX
     */
    public function calculateDf8(Request $request)
    {
        $importanceOutsourcing = floatval($request->input('importance_outsourcing', 33));
        $importanceCloud = floatval($request->input('importance_cloud', 33));
        $importanceInsourced = floatval($request->input('importance_insourced', 34));

        // Create temporary DF8 instance for calculation
        $tempDf8 = new \App\Models\DesignFactor8();
        $tempDf8->importance_outsourcing = $importanceOutsourcing;
        $tempDf8->importance_cloud = $importanceCloud;
        $tempDf8->importance_insourced = $importanceInsourced;

        // Calculate scores
        $scores = $tempDf8->calculateScores();
        $baselineScores = \App\Models\DesignFactor8::calculateBaselineScores();
        $relativeImportance = $tempDf8->calculateRelativeImportance();

        // Get all objectives
        $df8MapData = \App\Models\Df8Map::orderBy('objective_code')->get();

        $results = [];
        foreach ($df8MapData as $map) {
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
            'total' => $importanceOutsourcing + $importanceCloud + $importanceInsourced,
            'results' => $results,
        ]);
    }

    /**
     * Calculate DF9 via AJAX
     */
    public function calculateDf9(Request $request)
    {
        $importanceAgile = floatval($request->input('importance_agile', 33.33));
        $importanceDevops = floatval($request->input('importance_devops', 33.33));
        $importanceTraditional = floatval($request->input('importance_traditional', 33.34));

        // Create temporary instance for calculation
        $tempDf = new DesignFactor(['factor_type' => 'DF9']);
        $tempDf->inputs = [
            'agile' => ['importance' => $importanceAgile, 'baseline' => 15],
            'devops' => ['importance' => $importanceDevops, 'baseline' => 10],
            'traditional' => ['importance' => $importanceTraditional, 'baseline' => 75],
        ];

        $results = [];
        $df9Mapping = DesignFactor::getDF9Mapping();
        $defaultItems = DesignFactor::getDefaultCobitItems('DF9');
        $itemDict = collect($defaultItems)->keyBy('code');

        foreach ($df9Mapping as $code => $map) {
            $score = ($map['agile'] * $importanceAgile / 100) +
                ($map['devops'] * $importanceDevops / 100) +
                ($map['traditional'] * $importanceTraditional / 100);

            // Baseline Calculation: (Agile% * 15) + (DevOps% * 10) + (Traditional% * 75)
            // Note: DB columns are 'agile', 'devops', 'traditional' (percentage values from mapping)
            $baselineAgile = 15;
            $baselineDevops = 10;
            $baselineTraditional = 75;

            $baselineScore = ($map['agile'] * $baselineAgile / 100) +
                ($map['devops'] * $baselineDevops / 100) +
                ($map['traditional'] * $baselineTraditional / 100);

            $results[] = [
                'code' => $code,
                'name' => $this->getObjectiveName($code),
                'score' => round($score, 2),
                'baseline_score' => round($baselineScore, 2),
                'relative_importance' => $tempDf->calculateRelativeImportance($score, $baselineScore),
            ];
        }

        return response()->json([
            'success' => true,
            'total' => $importanceAgile + $importanceDevops + $importanceTraditional,
            'results' => $results,
        ]);
    }

    /**
     * Calculate DF10 via AJAX
     */
    public function calculateDf10(Request $request)
    {
        $importanceFirstMover = floatval($request->input('importance_first_mover', 75));
        $importanceFollower = floatval($request->input('importance_follower', 15));
        $importanceSlowAdopter = floatval($request->input('importance_slow_adopter', 10));

        // Create temporary instance for calculation
        $tempDf = new DesignFactor(['factor_type' => 'DF10']);
        $tempDf->inputs = [
            'first_mover' => ['importance' => $importanceFirstMover, 'baseline' => 15],
            'follower' => ['importance' => $importanceFollower, 'baseline' => 70],
            'slow_adopter' => ['importance' => $importanceSlowAdopter, 'baseline' => 15],
        ];

        $results = [];
        $df10Mapping = DesignFactor::getDF10Mapping();
        $defaultItems = DesignFactor::getDefaultCobitItems('DF10');
        $itemDict = collect($defaultItems)->keyBy('code');

        foreach ($df10Mapping as $code => $map) {
            $score = ($map['first_mover'] * $importanceFirstMover / 100) +
                ($map['follower'] * $importanceFollower / 100) +
                ($map['slow_adopter'] * $importanceSlowAdopter / 100);

            $baselineScore = $itemDict[$code]['baseline_score'] ?? 1.00;

            $results[] = [
                'code' => $code,
                'name' => $this->getObjectiveName($code),
                'score' => round($score, 2),
                'baseline_score' => round($baselineScore, 2),
                'relative_importance' => $tempDf->calculateRelativeImportance($score, $baselineScore),
            ];
        }

        return response()->json([
            'success' => true,
            'total' => $importanceFirstMover + $importanceFollower + $importanceSlowAdopter,
            'results' => $results,
        ]);
    }
}
