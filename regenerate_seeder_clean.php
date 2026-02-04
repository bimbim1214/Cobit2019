<?php
// Clean regeneration using UTF-8 JSON
$jsonFile = __DIR__ . '/storage/app/df4map_utf8.json';
$content = file_get_contents($jsonFile);
$jsonData = json_decode($content, true);

if (!$jsonData || !is_array($jsonData)) {
    die("Error: Could not parse JSON. Error: " . json_last_error_msg() . "\n");
}

$objectives = [
    'EDM01',
    'EDM02',
    'EDM03',
    'EDM04',
    'EDM05',
    'APO01',
    'APO02',
    'APO03',
    'APO04',
    'APO05',
    'APO06',
    'APO07',
    'APO08',
    'APO09',
    'APO10',
    'APO11',
    'APO12',
    'APO13',
    'APO14',
    'BAI01',
    'BAI02',
    'BAI03',
    'BAI04',
    'BAI05',
    'BAI06',
    'BAI07',
    'BAI08',
    'BAI09',
    'BAI10',
    'BAI11',
    'DSS01',
    'DSS02',
    'DSS03',
    'DSS04',
    'DSS05',
    'DSS06',
    'MEA01',
    'MEA02',
    'MEA03',
    'MEA04'
];

$php = "<?php\n\n";
$php .= "namespace Database\\Seeders;\n\n";
$php .= "use Illuminate\\Database\\Seeder;\n";
$php .= "use App\\Models\\Df4Map;\n\n";
$php .= "class Df4MapSeeder extends Seeder\n";
$php .= "{\n";
$php .= "    public function run(): void\n";
$php .= "    {\n";
$php .= "        \$data = [\n";

foreach ($jsonData as $index => $row) {
    if ($index >= 40)
        break;

    $code = $objectives[$index];
    $php .= "            [\n";
    $php .= "                'objective_code' => '{$code}',\n";

    for ($i = 0; $i < 20; $i++) {
        $itNum = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $value = isset($row[$i]) ? $row[$i] : 0;
        if ($value === null || $value === '' || $value === 'N/A') {
            $value = 0;
        }
        $php .= "                'it{$itNum}' => {$value},\n";
    }

    $php .= "            ],\n";
}

$php .= "        ];\n\n";
$php .= "        foreach (\$data as \$item) {\n";
$php .= "            Df4Map::create(\$item);\n";
$php .= "        }\n";
$php .= "    }\n";
$php .= "}\n";

file_put_contents(__DIR__ . '/database/seeders/Df4MapSeeder.php', $php);
echo "Success! Df4MapSeeder.php regenerated with " . count($jsonData) . " objectives\n";
