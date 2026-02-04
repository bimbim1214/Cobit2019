$excelPath = "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\file\Project-COBIT-2019-Design-Toolkit.xlsx"
$outputPath = "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\database\seeders\Df4MapSeeder.php"

$excel = New-Object -ComObject Excel.Application
$excel.Visible = $false
$excel.DisplayAlerts = $false

$objectives = @('EDM01', 'EDM02', 'EDM03', 'EDM04', 'EDM05',
    'APO01', 'APO02', 'APO03', 'APO04', 'APO05',
    'APO06', 'APO07', 'APO08', 'APO09', 'APO10',
    'APO11', 'APO12', 'APO13', 'APO14',
    'BAI01', 'BAI02', 'BAI03', 'BAI04', 'BAI05',
    'BAI06', 'BAI07', 'BAI08', 'BAI09', 'BAI10', 'BAI11',
    'DSS01', 'DSS02', 'DSS03', 'DSS04', 'DSS05', 'DSS06',
    'MEA01', 'MEA02', 'MEA03', 'MEA04')

try {
    $workbook = $excel.Workbooks.Open($excelPath)
    $sheet = $workbook.Sheets | Where-Object { $_.Name -like "*DF4map*" }
    
    if ($sheet) {
        $range = $sheet.Range("B2:U41")
        $data = $range.Value2
        
        # Generate PHP code
        $phpCode = @"
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Df4Map;

class Df4MapSeeder extends Seeder
{
    public function run(): void
    {
        `$data = [
"@
        
        for ($i = 1; $i -le 40; $i++) {
            $code = $objectives[$i - 1]
            $phpCode += "            [`n"
            $phpCode += "                'objective_code' => '$code',`n"
            
            for ($j = 1; $j -le 20; $j++) {
                $itNum = "{0:D2}" -f $j
                $value = $data[$i, $j]
                
                if ($null -eq $value -or $value -eq "" -or $value -eq "N/A") {
                    $value = 0
                }
                
                $phpCode += "                'it$itNum' => $value,`n"
            }
            
            $phpCode += "            ],`n"
        }
        
        $phpCode += @"
        ];

        foreach (`$data as `$item) {
            Df4Map::create(`$item);
        }
    }
}
"@
        
        # Save to file
        [System.IO.File]::WriteAllText($outputPath, $phpCode, [System.Text.Encoding]::UTF8)
        Write-Host "Df4MapSeeder.php generated successfully with real data!"
    }
} finally {
    $workbook.Close($false)
    $excel.Quit()
    [System.Runtime.Interopservices.Marshal]::ReleaseComObject($excel) | Out-Null
}
