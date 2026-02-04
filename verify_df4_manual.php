<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Df4Map;

// Dari screenshot Anda, saya hitung input manual:
// Baris 1-20 dari gambar: hijau=1, kuning=2, merah=3
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

// Get EDM01 mapping from database
$edm01Map = Df4Map::where('objective_code', 'EDM01')->first();

echo "=== VERIFIKASI MANUAL DF4 untuk EDM01 ===\n\n";

// Step 1: Hitung Average Importance (J23)
$totalImp = array_sum($userInputs);
$avgImp = $totalImp / 20;
echo "1. Total Importance: $totalImp\n";
echo "2. Average Importance (J23): $avgImp\n";

// Step 2: Hitung Weight (J25) = 2 / J23
$weight = 2 / $avgImp;
echo "3. Weight (J25) = 2 / $avgImp = $weight\n\n";

// Step 3: Hitung Score (MMULT)
$score = 0;
for ($i = 0; $i < 20; $i++) {
    $itKey = 'it' . str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    $mapValue = $edm01Map->$itKey;
    $inputValue = $userInputs[$i];
    $score += $mapValue * $inputValue;
    echo "IT" . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ": map=$mapValue × input=$inputValue = " . ($mapValue * $inputValue) . "\n";
}
echo "\n4. Total Score (B31): $score\n";

// Step 4: Baseline (hardcoded)
$baseline = 70;
echo "5. Baseline (C31): $baseline\n\n";

// Step 5: Calculate Relative Importance
// Formula: MROUND((Weight * 100 * Score / Baseline), 5) - 100
$calc = ($weight * 100 * $score) / $baseline;
echo "6. Calculation: ($weight × 100 × $score) / $baseline = $calc\n";

$rounded = round($calc / 5) * 5;
echo "7. MROUND($calc, 5) = $rounded\n";

$relativeImportance = $rounded - 100;
echo "8. Relative Importance: $rounded - 100 = $relativeImportance\n\n";

echo "=== HASIL AKHIR ===\n";
echo "EDM01 Relative Importance: $relativeImportance\n";
echo "Expected: -10\n";
echo "Match: " . ($relativeImportance == -10 ? "YES ✅" : "NO ❌") . "\n";
