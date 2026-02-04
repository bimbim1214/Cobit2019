$excelPath = "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\file\Project-COBIT-2019-Design-Toolkit.xlsx"

# Database connection (adjust if needed)
$server = "localhost"
$database = "auditti"
$username = "root"
$password = ""

$objectives = @('EDM01', 'EDM02', 'EDM03', 'EDM04', 'EDM05',
    'APO01', 'APO02', 'APO03', 'APO04', 'APO05',
    'APO06', 'APO07', 'APO08', 'APO09', 'APO10',
    'APO11', 'APO12', 'APO13', 'APO14',
    'BAI01', 'BAI02', 'BAI03', 'BAI04', 'BAI05',
    'BAI06', 'BAI07', 'BAI08', 'BAI09', 'BAI10', 'BAI11',
    'DSS01', 'DSS02', 'DSS03', 'DSS04', 'DSS05', 'DSS06',
    'MEA01', 'MEA02', 'MEA03', 'MEA04')

$excel = New-Object -ComObject Excel.Application
$excel.Visible = $false
$excel.DisplayAlerts = $false

try {
    $workbook = $excel.Workbooks.Open($excelPath)
    $sheet = $workbook.Sheets | Where-Object { $_.Name -like "*DF4map*" }
    
    if ($sheet) {
        $range = $sheet.Range("B2:U41")
        $data = $range.Value2
        
        # Create SQL file
        $sqlFile = "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\storage\app\df4map_insert.sql"
        $sql = "TRUNCATE TABLE df4_map;`n`n"
        
        for ($i = 1; $i -le 40; $i++) {
            $code = $objectives[$i - 1]
            $values = @()
            $values += "'$code'"
            
            for ($j = 1; $j -le 20; $j++) {
                $value = $data[$i, $j]
                if ($null -eq $value -or $value -eq "" -or $value -eq "N/A") {
                    $value = 0
                }
                $values += $value
            }
            
            $sql += "INSERT INTO df4_map (objective_code, it01, it02, it03, it04, it05, it06, it07, it08, it09, it10, it11, it12, it13, it14, it15, it16, it17, it18, it19, it20) VALUES (" + ($values -join ", ") + ");`n"
        }
        
        [System.IO.File]::WriteAllText($sqlFile, $sql, [System.Text.Encoding]::UTF8)
        Write-Host "SQL file generated: $sqlFile"
        Write-Host "Run: php artisan db:seed --class=Df4MapSeeder"
        Write-Host "Or import SQL directly"
    }
}
finally {
    $workbook.Close($false)
    $excel.Quit()
    [System.Runtime.Interopservices.Marshal]::ReleaseComObject($excel) | Out-Null
}
