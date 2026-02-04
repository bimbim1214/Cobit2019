<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Df4Map;

// INPUT EXACT DARI USER
// hijau=1, kuning=2, merah=3
$userInputs = [
    1, // IT01: hijau
    1, // IT02: hijau
    2, // IT03: kuning
    2, // IT04: kuning
    1, // IT05: hijau
    1, // IT06: hijau
    2, // IT07: kuning
    3, // IT08: merah
    3, // IT09: merah
    2, // IT10: kuning
    2, // IT11: kuning
    2, // IT12: kuning
    1, // IT13: hijau
    3, // IT14: merah
    3, // IT15: merah
    1, // IT16: hijau
    1, // IT17: hijau
    2, // IT18: kuning
    1, // IT19: hijau
    3, // IT20: merah
];

// Get EDM01 mapping
$edm01Map = Df4Map::where('objective_code', 'EDM01')->first();

echo "=== PERHITUNGAN FINAL DF4 EDM01 ===\n\n";

// Step 1: J23 = Average Importance
$totalImp = array_sum($userInputs);
$avgImp = $totalImp / 20;
echo "1. Total Importance: $totalImp\n";
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

    $color = $inputValue == 1 ? 'hijau' : ($inputValue == 2 ? 'kuning' : 'merah');
    echo "   IT" . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . " ($color): $mapValue × $inputValue = $product\n";
}
echo "\n   B31 (Total Score): $score\n\n";

// Step 4: C31 = Baseline
$baseline = 70;
echo "5. C31 (Baseline): $baseline\n\n";

// Step 5: Relative Importance
// Formula: MROUND((J25 * 100 * B31 / C31), 5) - 100
$rawCalc = ($weight * 100 * $score) / $baseline;
echo "6. Raw Calculation:\n";
echo "   (J25 × 100 × B31) / C31\n";
echo "   ($weight × 100 × $score) / $baseline\n";
echo "   = $rawCalc\n\n";

$rounded = round($rawCalc / 5) * 5;
echo "7. MROUND($rawCalc, 5) = $rounded\n\n";

$relativeImportance = $rounded - 100;
echo "8. Relative Importance:\n";
echo "   $rounded - 100 = $relativeImportance\n\n";

echo "=== HASIL ===\n";
echo "Calculated: $relativeImportance\n";
echo "Expected: -10\n\n";

if ($relativeImportance == -10) {
    echo "✅ PERFECT MATCH!\n";
    echo "Formula is 100% CORRECT!\n";
} else {
    echo "❌ MISMATCH\n";
    echo "Difference: " . ($relativeImportance - (-10)) . "\n\n";
    echo "Kemungkinan masalah:\n";
    echo "1. Data mapping di database tidak sesuai Excel\n";
    echo "2. Ada perbedaan rumus pembulatan\n";
    echo "3. Baseline value berbeda\n";
}
