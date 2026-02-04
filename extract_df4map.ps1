$excelPath = "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\file\Project-COBIT-2019-Design-Toolkit.xlsx"
$excel = New-Object -ComObject Excel.Application
$excel.Visible = $false
$excel.DisplayAlerts = $false

try {
    $workbook = $excel.Workbooks.Open($excelPath)
    
    # Find DF4map sheet
    $sheet = $workbook.Sheets | Where-Object { $_.Name -like "*DF4map*" }
    
    if ($sheet) {
        Write-Host "Found sheet: $($sheet.Name)"
        
        # Read data from B2:U41 (40 rows x 20 columns)
        $range = $sheet.Range("B2:U41")
        $data = $range.Value2
        
        # Convert to JSON for easier parsing
        $jsonData = @()
        for ($i = 1; $i -le 40; $i++) {
            $row = @()
            for ($j = 1; $j -le 20; $j++) {
                $value = $data[$i, $j]
                if ($null -eq $value -or $value -eq "" -or $value -eq "N/A") {
                    $row += 0
                } else {
                    $row += [double]$value
                }
            }
            $jsonData += ,@($row)
        }
        
        # Output as JSON
        $jsonData | ConvertTo-Json -Depth 3 | Out-File "e:\TA\website-auditTI-20251209T102137Z-3-001\website-auditTI-20251209T102137Z-3-001\website-auditTI\storage\app\df4map_data.json"
        Write-Host "Data exported to storage/app/df4map_data.json"
    } else {
        Write-Host "DF4map sheet not found"
    }
} finally {
    $workbook.Close($false)
    $excel.Quit()
    [System.Runtime.Interopservices.Marshal]::ReleaseComObject($excel) | Out-Null
}
