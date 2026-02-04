<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Df4Map;

// DARI SCREENSHOT: SEMUA INPUT = 1 (HIJAU)
$userInputs = array_fill(0, 20, 1);

// Get EDM01 mapping from database
$edm01Map = Df4Map::where('objective_code', 'EDM01')->first();

echo "=== VERIFIKASI DF4 EDM01 (SEMUA INPUT = 1) ===\n\n";

// Step 1: Average Importance
$totalImp = array_sum($userInputs);
$avgImp = $totalImp / 20;
echo "1. Total Importance: $totalImp\n";
echo "2. Average Importance (J23): $avgImp\n";

// Step 2: Weight = 2 / avgImp
$weight = 2 / $avgImp;
echo "3. Weight (J25) = 2 / $avgImp = $weight\n\n";

// Step 3: Score (MMULT)
echo "4. Calculating Score (MMULT):\n";
$score = 0;
for ($i = 0; $i < 20; $i++) {
    $itKey = 'it' . str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    $mapValue = $edm01Map->$itKey;
    $inputValue = $userInputs[$i];
    $product = $mapValue * $inputValue;
    $score += $product;
    echo "   IT" . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ": $mapValue × $inputValue = $product\n";
}
echo "\n   Total Score (B31): $score\n\n";

// Step 4: Baseline
$baseline = 70;
echo "5. Baseline (C31): $baseline\n\n";

// Step 5: Relative Importance
// Formula: MROUND((Weight * 100 * Score / Baseline), 5) - 100
$rawCalc = ($weight * 100 * $score) / $baseline;
echo "6. Raw Calculation:\n";
echo "   ($weight × 100 × $score) / $baseline = $rawCalc\n\n";

$rounded = round($rawCalc / 5) * 5;
echo "7. MROUND($rawCalc, 5) = $rounded\n\n";

$relativeImportance = $rounded - 100;
echo "8. Relative Importance: $rounded - 100 = $relativeImportance\n\n";

echo "=== HASIL ===\n";
echo "EDM01 Relative Importance: $relativeImportance\n";
echo "User expects: -10\n";
echo "System shows: -20\n\n";

if ($relativeImportance == -10) {
    echo "✅ MATCH! Formula is CORRECT\n";
} elseif ($relativeImportance == -20) {
    echo "❌ System is correct, but user expectation might be wrong\n";
    echo "   Please verify your Excel calculation\n";
} else {
    echo "❌ Neither matches - there's a bug\n";
}
