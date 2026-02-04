<?php
// Direct SQL execution via Laravel
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
        echo "Statement: " . substr($statement, 0, 100) . "...\n";
    }
}

echo "Executed $count SQL statements successfully!\n";
echo "DF4 map data populated.\n";
