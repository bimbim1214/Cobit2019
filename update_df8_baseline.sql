USE cobit2019;

-- Update baseline_score for existing DF8 items
UPDATE design_factor_items dfi
JOIN design_factors df ON dfi.design_factor_id = df.id
SET dfi.baseline_score = CASE 
    WHEN dfi.code = 'EDM03' THEN 1.33
    WHEN dfi.code = 'APO09' THEN 2.98
    WHEN dfi.code = 'APO10' THEN 2.98
    WHEN dfi.code = 'APO12' THEN 1.66
    WHEN dfi.code = 'MEA01' THEN 2.32
    ELSE dfi.baseline_score
END
WHERE df.factor_type = 'DF8'
  AND dfi.code IN ('EDM03', 'APO09', 'APO10', 'APO12', 'MEA01');

SELECT 'DF8 baseline values updated successfully!' as message;
