<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Df4Map;

// INPUT YANG BENAR DARI SCREENSHOT (titik hitam = dipilih)
$userInputs = [
    1,
    2,
    2,
    2,
    1,
    2,
    2,
    2,
    1,
    2,  // IT01-IT10
    2,
    2,
    2,
    2,
    1,
    2,
    2,
    2,
    2,
    2   // IT11-IT20
];

// Get EDM01 mapping
$edm01Map = Df4Map::where('objective_code', 'EDM01')->first();

echo "=== PERHITUNGAN MANUAL DF4 EDM01 ===\n\n";
echo "Input (dari screenshot):\n";
for ($i = 0; $i < 20; $i++) {
    echo "IT" . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . " = " . $userInputs[$i] . "\n";
}

// Step 1: J23 = Average Importance
$totalImp = array_sum($userInputs);
$avgImp = $totalImp / 20;
echo "\n1. Total Importance: $totalImp\n";
echo "2. J23 (Average): $totalImp / 20 = $avgImp\n";

// Step 2: J25 = Weight = 2 / J23
$weight = 2 / $avgImp;
echo "3. J25 (Weight): 2 / $avgImp = $weight\n\n";

// Step 3: B31 = Score (MMULT)
echo "4. Score Calculation (MMULT):\n";
$score = 0;
for ($i = 0; $i < 20; $i++) {
    $itKey = 'it' . str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    $mapValue = $edm01Map->$itKey;
    $inputValue = $userInputs[$i];
    $product = $mapValue * $inputValue;
    $score += $product;
    echo "   IT" . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ": $mapValue × $inputValue = $product\n";
}
echo "\n   B31 (Total Score): $score\n\n";

// Step 4: C31 = Baseline
$baseline = 70;
echo "5. C31 (Baseline): $baseline\n\n";

// Step 5: Relative Importance
// MROUND((J25 * 100 * B31 / C31), 5) - 100
$rawCalc = ($weight * 100 * $score) / $baseline;
echo "6. Raw Calculation:\n";
echo "   (J25 × 100 × B31) / C31\n";
echo "   ($weight × 100 × $score) / $baseline = $rawCalc\n\n";

$rounded = round($rawCalc / 5) * 5;
echo "7. MROUND($rawCalc, 5) = $rounded\n\n";

$relativeImportance = $rounded - 100;
echo "8. Relative Importance:\n";
echo "   $rounded - 100 = $relativeImportance\n\n";

echo "=== HASIL ===\n";
echo "EDM01 Relative Importance: $relativeImportance\n";
echo "Expected (dari user): -10\n";
echo "System shows: -20\n\n";

if ($relativeImportance == -10) {
    echo "✅ PERFECT! Calculation is CORRECT!\n";
} else {
    echo "❌ Mismatch detected\n";
    echo "Difference: " . ($relativeImportance - (-10)) . "\n";
}
