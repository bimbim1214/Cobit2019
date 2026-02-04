<?php
// Script to generate Df4MapSeeder from JSON data
$jsonFile = __DIR__ . '/storage/app/df4map_data.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

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

$seederContent = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse App\\Models\\Df4Map;\n\nclass Df4MapSeeder extends Seeder\n{\n    public function run(): void\n    {\n        \$data = [\n";

foreach ($jsonData as $index => $row) {
    $code = $objectives[$index];
    $seederContent .= "            [\n";
    $seederContent .= "                'objective_code' => '$code',\n";

    for ($i = 0; $i < 20; $i++) {
        $itNum = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $value = $row[$i] ?? 0;
        $seederContent .= "                'it$itNum' => $value,\n";
    }

    $seederContent .= "            ],\n";
}

$seederContent .= "        ];\n\n";
$seederContent .= "        foreach (\$data as \$item) {\n";
$seederContent .= "            Df4Map::create(\$item);\n";
$seederContent .= "        }\n";
$seederContent .= "    }\n}\n";

file_put_contents(__DIR__ . '/database/seeders/Df4MapSeeder.php', $seederContent);
echo "Df4MapSeeder.php updated successfully!\n";
