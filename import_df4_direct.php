<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$sqlFile = __DIR__ . '/storage/app/df4map_insert.sql';
$sql = file_get_contents($sqlFile);

// Split by semicolon and execute each statement
$statements = explode(';', $sql);

$count = 0;
foreach ($statements as $statement) {
    $statement = trim($statement);
    if (empty($statement))
        continue;

    try {
        DB::statement($statement);
        $count++;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Success! Executed $count SQL statements.\n";
echo "DF4 map data populated from Excel.\n";
