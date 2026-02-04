<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DesignFactor;

// Test with all inputs = 3 (Red)
$inputs = [];
for ($i = 1; $i <= 20; $i++) {
    $key = 'it' . str_pad($i, 2, '0', STR_PAD_LEFT);
    $inputs[$key] = ['importance' => 3];
}

$results = DesignFactor::calculateDf4Results($inputs);

echo "DF4 Calculation Test (All inputs = 3 / Red):\n";
echo "EDM01 Relative Importance: " . $results['EDM01'] . "\n";
echo "EDM02 Relative Importance: " . $results['EDM02'] . "\n";
echo "EDM03 Relative Importance: " . $results['EDM03'] . "\n";
echo "\nExpected EDM01: around -10 (depending on mapping)\n";
