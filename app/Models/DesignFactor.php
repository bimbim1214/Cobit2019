<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignFactor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'factor_type',
        'factor_name',
        'inputs', // JSON
        'extra_data', // JSON
    ];

    protected $casts = [
        'inputs' => 'array',
        'extra_data' => 'array',
    ];

    /**
     * Get the user that owns the design factor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the design factor.
     */
    public function items()
    {
        return $this->hasMany(DesignFactorItem::class);
    }

    /**
     * Get metadata for input items based on factor type
     */
    public static function getMetadata(string $type): array
    {
        if ($type === 'DF1') {
            return [
                'growth' => ['name' => 'Growth/Acquisition'],
                'innovation' => ['name' => 'Innovation/Differentiation'],
                'cost' => ['name' => 'Cost Leadership'],
                'stability' => ['name' => 'Client Service/Stability'],
            ];
        }

        if ($type === 'DF2') {
            return [
                'EG01' => ['name' => 'EG01—Portfolio of competitive products and services'],
                'EG02' => ['name' => 'EG02—Managed business risk'],
                'EG03' => ['name' => 'EG03—Compliance with external laws and regulations'],
                'EG04' => ['name' => 'EG04—Quality of financial information'],
                'EG05' => ['name' => 'EG05—Customer-oriented service culture'],
                'EG06' => ['name' => 'EG06—Business-service continuity and availability'],
                'EG07' => ['name' => 'EG07—Quality of management information'],
                'EG08' => ['name' => 'EG08—Optimization of internal business process functionality'],
                'EG09' => ['name' => 'EG09—Optimization of business process costs'],
                'EG10' => ['name' => 'EG10—Staff skills, motivation and productivity'],
                'EG11' => ['name' => 'EG11—Compliance with internal policies'],
                'EG12' => ['name' => 'EG12—Managed digital transformation programs'],
                'EG13' => ['name' => 'EG13—Product and business innovation'],
            ];
        }

        if ($type === 'DF3') {
            return [
                'RS01' => ['name' => 'IT investment decision making, portfolio definition & maintenance'],
                'RS02' => ['name' => 'Program & projects life cycle management'],
                'RS03' => ['name' => 'IT cost & oversight'],
                'RS04' => ['name' => 'IT expertise, skills & behavior'],
                'RS05' => ['name' => 'Enterprise/IT architecture'],
                'RS06' => ['name' => 'IT operational infrastructure incidents'],
                'RS07' => ['name' => 'Unauthorized actions'],
                'RS08' => ['name' => 'Software adoption/usage problems'],
                'RS09' => ['name' => 'Hardware incidents'],
                'RS10' => ['name' => 'Software failures'],
                'RS11' => ['name' => 'Logical attacks (hacking, malware, etc.)'],
                'RS12' => ['name' => 'Third-party/supplier incidents'],
                'RS13' => ['name' => 'Noncompliance'],
                'RS14' => ['name' => 'Geopolitical Issues'],
                'RS15' => ['name' => 'Industrial action'],
                'RS16' => ['name' => 'Acts of nature'],
                'RS17' => ['name' => 'Technology-based innovation'],
                'RS18' => ['name' => 'Environmental'],
                'RS19' => ['name' => 'Data & information management'],
            ];
        }

        if ($type === 'DF4') {
            return [
                'IT01' => ['name' => 'Frustration between different IT entities across the organization because of a perception of low contribution to business value'],
                'IT02' => ['name' => 'Frustration between business departments (i.e., the IT customer) and the IT department because of failed initiatives or a perception of low contribution to business value'],
                'IT03' => ['name' => 'Significant IT-related incidents, such as data loss, security breaches, project failure and application errors, linked to IT'],
                'IT04' => ['name' => 'Service delivery problems by the IT outsourcer(s)'],
                'IT05' => ['name' => 'Failures to meet IT-related regulatory or contractual requirements'],
                'IT06' => ['name' => 'Regular audit findings or other assessment reports about poor IT performance or reported IT quality or service problems'],
                'IT07' => ['name' => 'Substantial hidden and rogue IT spending, that is, IT spending by user departments outside the control of the normal IT investment decision mechanisms and approved budgets'],
                'IT08' => ['name' => 'Duplications or overlaps between various initiatives, or other forms of wasted resources'],
                'IT09' => ['name' => 'Insufficient IT resources, staff with inadequate skills or staff burnout/dissatisfaction'],
                'IT10' => ['name' => 'IT-enabled changes or projects frequently failing to meet business needs and delivered late or over budget'],
                'IT11' => ['name' => 'Reluctance by board members, executives or senior management to engage with IT, or a lack of committed business sponsorship for IT'],
                'IT12' => ['name' => 'Complex IT operating model and/or unclear decision mechanisms for IT-related decisions'],
                'IT13' => ['name' => 'Excessively high cost of IT'],
                'IT14' => ['name' => 'Obstructed or failed implementation of new initiatives or innovations caused by the current IT architecture and systems'],
                'IT15' => ['name' => 'Gap between business and technical knowledge, which leads to business users and information and/or technology specialists speaking different languages'],
                'IT16' => ['name' => 'Regular issues with data quality and integration of data across various sources'],
                'IT17' => ['name' => 'High level of end-user computing, creating (among other problems) a lack of oversight and quality control over the applications that are being developed and put in operation'],
                'IT18' => ['name' => 'Business departments implementing their own information solutions with little or no involvement of the enterprise IT department (related to end-user computing, which often stems from dissatisfaction with IT solutions and services)'],
                'IT19' => ['name' => 'Ignorance of and/or noncompliance with privacy regulations'],
                'IT20' => ['name' => 'Inability to exploit new technologies or innovate using I&T'],
            ];
        }

        return [];
    }

    /**
     * Get default inputs for a new design factor
     */
    public static function getDefaultInputs(string $type): array
    {
        $metadata = self::getMetadata($type);
        $inputs = [];
        foreach ($metadata as $key => $data) {
            if ($type === 'DF3') {
                $inputs[$key] = [
                    'impact' => 3,
                    'likelihood' => 3,
                    'baseline' => 9 // 3 * 3
                ];
            } elseif ($type === 'DF4') {
                $inputs[$key] = [
                    'importance' => 1,
                    'baseline' => 2
                ];
            } else {
                $inputs[$key] = [
                    'importance' => ($type === 'DF4' ? 1 : 3),
                    'baseline' => 3
                ];
            }
        }
        return $inputs;
    }

    /**
     * Average of importance values
     */
    public function getAverageImportance(): float
    {
        $inputs = $this->inputs ?? [];
        if (empty($inputs))
            return 3.0;

        if ($this->factor_type === 'DF3') {
            $ratings = [];
            foreach ($inputs as $input) {
                $impact = $input['impact'] ?? 3;
                $likelihood = $input['likelihood'] ?? 3;
                $ratings[] = $impact * $likelihood;
            }
            return count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 9.0;
        }

        $values = array_column($inputs, 'importance');
        return count($values) > 0 ? array_sum($values) / count($values) : 3.0;
    }

    /**
     * Average of baseline values
     */
    public function getAverageBaseline(): float
    {
        $inputs = $this->inputs ?? [];
        if (empty($inputs))
            return 3.0;

        $values = array_column($inputs, 'baseline');
        return count($values) > 0 ? array_sum($values) / count($values) : 3.0;
    }

    /**
     * Get weighted factor (Weight)
     */
    public function getWeightedFactor(): float
    {
        $avgImp = $this->getAverageImportance();
        $avgBase = $this->getAverageBaseline();

        if ($avgImp == 0 || $avgBase == 0)
            return 1.0;

        // DF1 and DF4: Baseline / Importance
        if ($this->factor_type === 'DF1' || $this->factor_type === 'DF4') {
            return $avgBase / $avgImp;
        }

        // DF2, DF3: Importance / Baseline
        if ($this->factor_type === 'DF2' || $this->factor_type === 'DF3') {
            return $avgImp / $avgBase;
        }

        return 1.0;
    }

    /**
     * Calculate relative importance for a COBIT item
     */
    public function calculateRelativeImportance(float $score, float $baselineScore): float
    {
        if ($baselineScore == 0)
            return 0;

        $factor = $this->getWeightedFactor();
        $calculated = ($factor * 100 * $score) / $baselineScore;

        // MROUND to nearest 5
        $rounded = round($calculated / 5) * 5;

        return $rounded - 100;
    }

    /**
     * Default COBIT items and scores based on factor type
     */
    public static function getDefaultCobitItems(string $type): array
    {
        if ($type === 'DF1') {
            return [
                ['code' => 'EDM01', 'score' => 12.5, 'baseline_score' => 15],
                ['code' => 'EDM02', 'score' => 18.5, 'baseline_score' => 24],
                ['code' => 'EDM03', 'score' => 15.5, 'baseline_score' => 22.5],
                ['code' => 'EDM04', 'score' => 17, 'baseline_score' => 11],
                ['code' => 'EDM05', 'score' => 12, 'baseline_score' => 11],
                ['code' => 'APO01', 'score' => 31.5, 'baseline_score' => 28.5],
                ['code' => 'APO02', 'score' => 24, 'baseline_score' => 21],
                ['code' => 'APO03', 'score' => 24, 'baseline_score' => 15],
                ['code' => 'APO04', 'score' => 12, 'baseline_score' => 15],
                ['code' => 'APO05', 'score' => 15.5, 'baseline_score' => 24],
                ['code' => 'APO06', 'score' => 18.5, 'baseline_score' => 24],
                ['code' => 'APO07', 'score' => 12.5, 'baseline_score' => 22.5],
                ['code' => 'APO08', 'score' => 12.5, 'baseline_score' => 12],
                ['code' => 'APO09', 'score' => 15.5, 'baseline_score' => 22.5],
                ['code' => 'APO10', 'score' => 16, 'baseline_score' => 12],
                ['code' => 'APO11', 'score' => 20.5, 'baseline_score' => 21],
                ['code' => 'APO12', 'score' => 18, 'baseline_score' => 15],
                ['code' => 'APO13', 'score' => 15.5, 'baseline_score' => 12],
                ['code' => 'BAI01', 'score' => 26.5, 'baseline_score' => 27],
                ['code' => 'BAI02', 'score' => 6, 'baseline_score' => 25.5],
                ['code' => 'BAI03', 'score' => 13.5, 'baseline_score' => 18],
                ['code' => 'BAI04', 'score' => 15, 'baseline_score' => 12],
                ['code' => 'BAI05', 'score' => 18.5, 'baseline_score' => 27],
                ['code' => 'BAI06', 'score' => 17, 'baseline_score' => 12],
                ['code' => 'BAI07', 'score' => 12, 'baseline_score' => 27],
                ['code' => 'BAI08', 'score' => 9.5, 'baseline_score' => 27],
                ['code' => 'BAI09', 'score' => 23.5, 'baseline_score' => 12],
                ['code' => 'BAI10', 'score' => 15, 'baseline_score' => 12],
                ['code' => 'DSS01', 'score' => 10, 'baseline_score' => 12],
                ['code' => 'DSS02', 'score' => 11, 'baseline_score' => 12],
                ['code' => 'DSS03', 'score' => 12, 'baseline_score' => 12],
                ['code' => 'DSS04', 'score' => 16.5, 'baseline_score' => 12],
                ['code' => 'DSS05', 'score' => 6, 'baseline_score' => 12],
                ['code' => 'DSS06', 'score' => 12, 'baseline_score' => 12],
                ['code' => 'MEA01', 'score' => 11, 'baseline_score' => 12],
                ['code' => 'MEA02', 'score' => 11, 'baseline_score' => 12],
                ['code' => 'MEA03', 'score' => 11, 'baseline_score' => 12],
                ['code' => 'MEA04', 'score' => 11, 'baseline_score' => 12],
            ];
        }

        if ($type === 'DF2') {
            return [
                ['code' => 'EDM01', 'score' => 99, 'baseline_score' => 99],
                ['code' => 'EDM02', 'score' => 141, 'baseline_score' => 114],
                ['code' => 'EDM03', 'score' => 48, 'baseline_score' => 63],
                ['code' => 'EDM04', 'score' => 156, 'baseline_score' => 129],
                ['code' => 'EDM05', 'score' => 32, 'baseline_score' => 63],
                ['code' => 'APO01', 'score' => 174, 'baseline_score' => 180],
                ['code' => 'APO02', 'score' => 165, 'baseline_score' => 132],
                ['code' => 'APO03', 'score' => 163, 'baseline_score' => 135],
                ['code' => 'APO04', 'score' => 156, 'baseline_score' => 120],
                ['code' => 'APO05', 'score' => 168, 'baseline_score' => 141],
                ['code' => 'APO06', 'score' => 101, 'baseline_score' => 117],
                ['code' => 'APO07', 'score' => 136, 'baseline_score' => 108],
                ['code' => 'APO08', 'score' => 237, 'baseline_score' => 189],
                ['code' => 'APO09', 'score' => 76, 'baseline_score' => 63],
                ['code' => 'APO10', 'score' => 94, 'baseline_score' => 78],
                ['code' => 'APO11', 'score' => 121, 'baseline_score' => 132],
                ['code' => 'APO12', 'score' => 30, 'baseline_score' => 36],
                ['code' => 'APO13', 'score' => 31, 'baseline_score' => 39],
                ['code' => 'APO14', 'score' => 45, 'baseline_score' => 78],
                ['code' => 'BAI01', 'score' => 155, 'baseline_score' => 129],
                ['code' => 'BAI02', 'score' => 210, 'baseline_score' => 174],
                ['code' => 'BAI03', 'score' => 200, 'baseline_score' => 165],
                ['code' => 'BAI04', 'score' => 79, 'baseline_score' => 69],
                ['code' => 'BAI05', 'score' => 220, 'baseline_score' => 183],
                ['code' => 'BAI06', 'score' => 108, 'baseline_score' => 90],
                ['code' => 'BAI07', 'score' => 82, 'baseline_score' => 69],
                ['code' => 'BAI08', 'score' => 172, 'baseline_score' => 135],
                ['code' => 'BAI09', 'score' => 23, 'baseline_score' => 51],
                ['code' => 'BAI10', 'score' => 21, 'baseline_score' => 18],
                ['code' => 'BAI11', 'score' => 165, 'baseline_score' => 138],
                ['code' => 'DSS01', 'score' => 76, 'baseline_score' => 63],
                ['code' => 'DSS02', 'score' => 57, 'baseline_score' => 54],
                ['code' => 'DSS03', 'score' => 57, 'baseline_score' => 54],
                ['code' => 'DSS04', 'score' => 57, 'baseline_score' => 54],
                ['code' => 'DSS05', 'score' => 69, 'baseline_score' => 81],
                ['code' => 'DSS06', 'score' => 114, 'baseline_score' => 105],
                ['code' => 'MEA01', 'score' => 123, 'baseline_score' => 135],
                ['code' => 'MEA02', 'score' => 108, 'baseline_score' => 135],
                ['code' => 'MEA03', 'score' => 26, 'baseline_score' => 39],
                ['code' => 'MEA04', 'score' => 79, 'baseline_score' => 111],
            ];
        }

        if ($type === 'DF3') {
            return [
                ['code' => 'EDM01', 'score' => 181, 'baseline_score' => 189],
                ['code' => 'EDM02', 'score' => 152, 'baseline_score' => 135],
                ['code' => 'EDM03', 'score' => 180, 'baseline_score' => 162],
                ['code' => 'EDM04', 'score' => 167, 'baseline_score' => 198],
                ['code' => 'EDM05', 'score' => 156, 'baseline_score' => 189],
                ['code' => 'APO01', 'score' => 366, 'baseline_score' => 324],
                ['code' => 'APO02', 'score' => 134, 'baseline_score' => 144],
                ['code' => 'APO03', 'score' => 192, 'baseline_score' => 171],
                ['code' => 'APO04', 'score' => 64, 'baseline_score' => 45],
                ['code' => 'APO05', 'score' => 118, 'baseline_score' => 144],
                ['code' => 'APO06', 'score' => 118, 'baseline_score' => 153],
                ['code' => 'APO07', 'score' => 250, 'baseline_score' => 216],
                ['code' => 'APO08', 'score' => 213, 'baseline_score' => 153],
                ['code' => 'APO09', 'score' => 129, 'baseline_score' => 117],
                ['code' => 'APO10', 'score' => 196, 'baseline_score' => 216],
                ['code' => 'APO11', 'score' => 128, 'baseline_score' => 99],
                ['code' => 'APO12', 'score' => 132, 'baseline_score' => 90],
                ['code' => 'APO13', 'score' => 155, 'baseline_score' => 99],
                ['code' => 'APO14', 'score' => 263, 'baseline_score' => 198],
                ['code' => 'BAI01', 'score' => 92, 'baseline_score' => 81],
                ['code' => 'BAI02', 'score' => 134, 'baseline_score' => 117],
                ['code' => 'BAI03', 'score' => 155, 'baseline_score' => 117],
                ['code' => 'BAI04', 'score' => 12, 'baseline_score' => 9],
                ['code' => 'BAI05', 'score' => 104, 'baseline_score' => 72],
                ['code' => 'BAI06', 'score' => 192, 'baseline_score' => 135],
                ['code' => 'BAI07', 'score' => 148, 'baseline_score' => 117],
                ['code' => 'BAI08', 'score' => 151, 'baseline_score' => 135],
                ['code' => 'BAI09', 'score' => 42, 'baseline_score' => 36],
                ['code' => 'BAI10', 'score' => 138, 'baseline_score' => 99],
                ['code' => 'BAI11', 'score' => 48, 'baseline_score' => 36],
                ['code' => 'DSS01', 'score' => 128, 'baseline_score' => 135],
                ['code' => 'DSS02', 'score' => 184, 'baseline_score' => 144],
                ['code' => 'DSS03', 'score' => 125, 'baseline_score' => 108],
                ['code' => 'DSS04', 'score' => 241, 'baseline_score' => 216],
                ['code' => 'DSS05', 'score' => 256, 'baseline_score' => 216],
                ['code' => 'DSS06', 'score' => 196, 'baseline_score' => 144],
                ['code' => 'MEA01', 'score' => 234, 'baseline_score' => 216],
                ['code' => 'MEA02', 'score' => 256, 'baseline_score' => 243],
                ['code' => 'MEA03', 'score' => 186, 'baseline_score' => 153],
                ['code' => 'MEA04', 'score' => 264, 'baseline_score' => 225],
            ];
        }

        if ($type === 'DF4') {
            return [
                ['code' => 'EDM01', 'score' => 170, 'baseline_score' => 140],
                ['code' => 'EDM02', 'score' => 210, 'baseline_score' => 170],
                ['code' => 'EDM03', 'score' => 240, 'baseline_score' => 200],
                ['code' => 'EDM04', 'score' => 160, 'baseline_score' => 130],
                ['code' => 'EDM05', 'score' => 140, 'baseline_score' => 110],
                ['code' => 'APO01', 'score' => 190, 'baseline_score' => 160],
                ['code' => 'APO02', 'score' => 200, 'baseline_score' => 170],
                ['code' => 'APO03', 'score' => 180, 'baseline_score' => 150],
                ['code' => 'APO04', 'score' => 160, 'baseline_score' => 130],
                ['code' => 'APO05', 'score' => 170, 'baseline_score' => 140],
                ['code' => 'APO06', 'score' => 180, 'baseline_score' => 150],
                ['code' => 'APO07', 'score' => 220, 'baseline_score' => 180],
                ['code' => 'APO08', 'score' => 200, 'baseline_score' => 160],
                ['code' => 'APO09', 'score' => 190, 'baseline_score' => 150],
                ['code' => 'APO10', 'score' => 210, 'baseline_score' => 170],
                ['code' => 'APO11', 'score' => 230, 'baseline_score' => 190],
                ['code' => 'APO12', 'score' => 250, 'baseline_score' => 210],
                ['code' => 'APO13', 'score' => 240, 'baseline_score' => 200],
                ['code' => 'APO14', 'score' => 160, 'baseline_score' => 130],
                ['code' => 'BAI01', 'score' => 230, 'baseline_score' => 190],
                ['code' => 'BAI02', 'score' => 210, 'baseline_score' => 180],
                ['code' => 'BAI03', 'score' => 220, 'baseline_score' => 180],
                ['code' => 'BAI04', 'score' => 190, 'baseline_score' => 160],
                ['code' => 'BAI05', 'score' => 200, 'baseline_score' => 170],
                ['code' => 'BAI06', 'score' => 180, 'baseline_score' => 150],
                ['code' => 'BAI07', 'score' => 190, 'baseline_score' => 160],
                ['code' => 'BAI08', 'score' => 210, 'baseline_score' => 170],
                ['code' => 'BAI09', 'score' => 180, 'baseline_score' => 150],
                ['code' => 'BAI10', 'score' => 170, 'baseline_score' => 140],
                ['code' => 'BAI11', 'score' => 190, 'baseline_score' => 160],
                ['code' => 'DSS01', 'score' => 230, 'baseline_score' => 190],
                ['code' => 'DSS02', 'score' => 240, 'baseline_score' => 200],
                ['code' => 'DSS03', 'score' => 250, 'baseline_score' => 210],
                ['code' => 'DSS04', 'score' => 260, 'baseline_score' => 220],
                ['code' => 'DSS05', 'score' => 270, 'baseline_score' => 230],
                ['code' => 'DSS06', 'score' => 240, 'baseline_score' => 190],
                ['code' => 'MEA01', 'score' => 210, 'baseline_score' => 180],
                ['code' => 'MEA02', 'score' => 220, 'baseline_score' => 180],
                ['code' => 'MEA03', 'score' => 230, 'baseline_score' => 190],
                ['code' => 'MEA04', 'score' => 200, 'baseline_score' => 170],
            ];
        }

        return [];
    }
}
