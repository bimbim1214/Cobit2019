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
        'is_completed',
        'is_locked',
    ];

    protected $casts = [
        'inputs' => 'array',
        'extra_data' => 'array',
        'is_completed' => 'boolean',
        'is_locked' => 'boolean',
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
     * Get title and description for factor type
     */
    public static function getFactorInfo(string $type): array
    {
        return match ($type) {
            'DF1' => ['title' => 'Strategic Objectives', 'description' => 'Identify the importance of various strategic objectives.'],
            'DF2' => ['title' => 'Enterprise Goals', 'description' => 'Evaluate the importance of enterprise goals.'],
            'DF3' => ['title' => 'Risk Scenario Categories', 'description' => 'Assess the risk profile of the organization.'],
            'DF4' => ['title' => 'IT-Related Issues', 'description' => 'Identify current IT-related issues.'],
            'DF5' => ['title' => 'Governance/Management Objectives', 'description' => 'Analyze governance and management objectives.'],
            'DF6' => ['title' => 'Threat Landscape', 'description' => 'Assess the current threat landscape.'],
            'DF7' => ['title' => 'Importance of Role of IT', 'description' => 'Define the role and importance of IT.'],
            'DF8' => ['title' => 'Sourcing Model', 'description' => 'Evaluate the importance of verschiedene sourcing models.'],
            'DF9' => ['title' => 'IT Implementation', 'description' => 'Assess the importance of IT implementation methods.'],
            'DF10' => ['title' => 'Tech Adoption', 'description' => 'Determine the technology adoption strategy.'],
            default => ['title' => 'Unknown Factor', 'description' => 'Please select a valid design factor.'],
        };
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

        if ($type === 'DF6') {
            return [
                'high' => ['name' => 'High'],
                'normal' => ['name' => 'Normal'],
                'low' => ['name' => 'Low'],
            ];
        }

        if ($type === 'DF7') {
            return [
                'support' => ['name' => 'Support'],
                'factory' => ['name' => 'Factory'],
                'turnaround' => ['name' => 'Turnaround'],
                'strategic' => ['name' => 'Strategic'],
            ];
        }

        if ($type === 'DF8') {
            return [
                'outsourcing' => ['name' => 'Outsourcing'],
                'cloud' => ['name' => 'Cloud'],
                'insourced' => ['name' => 'Insourced'],
            ];
        }

        if ($type === 'DF9') {
            return [
                'agile' => ['name' => 'Agile'],
                'devops' => ['name' => 'DevOps'],
                'traditional' => ['name' => 'Traditional'],
            ];
        }

        if ($type === 'DF10') {
            return [
                'first_mover' => ['name' => 'First Mover'],
                'follower' => ['name' => 'Follower'],
                'slow_adopter' => ['name' => 'Slow Adopter'],
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
                    'baseline' => 1
                ];
            } elseif ($type === 'DF6') {
                // DF6 uses percentage inputs that must sum to 100%
                if ($key === 'high') {
                    $inputs[$key] = ['importance' => 25, 'baseline' => 0];
                } elseif ($key === 'normal') {
                    $inputs[$key] = ['importance' => 75, 'baseline' => 100];
                } elseif ($key === 'low') {
                    $inputs[$key] = ['importance' => 0, 'baseline' => 0];
                }
            } elseif ($type === 'DF8') {
                // DF8 uses percentage inputs that must sum to 100%
                if ($key === 'outsourcing') {
                    $inputs[$key] = ['importance' => 10, 'baseline' => 33];
                } elseif ($key === 'cloud') {
                    $inputs[$key] = ['importance' => 50, 'baseline' => 33];
                } elseif ($key === 'insourced') {
                    $inputs[$key] = ['importance' => 40, 'baseline' => 34];
                }
            } elseif ($type === 'DF9') {
                // DF9 uses percentage inputs that must sum to 100%
                if ($key === 'agile') {
                    $inputs[$key] = ['importance' => 50, 'baseline' => 15];
                } elseif ($key === 'devops') {
                    $inputs[$key] = ['importance' => 10, 'baseline' => 10];
                } elseif ($key === 'traditional') {
                    $inputs[$key] = ['importance' => 40, 'baseline' => 75];
                }
            } elseif ($type === 'DF10') {
                // DF10 uses percentage inputs that must sum to 100%
                if ($key === 'first_mover') {
                    $inputs[$key] = ['importance' => 75, 'baseline' => 15];
                } elseif ($key === 'follower') {
                    $inputs[$key] = ['importance' => 15, 'baseline' => 70];
                } elseif ($key === 'slow_adopter') {
                    $inputs[$key] = ['importance' => 10, 'baseline' => 15];
                }
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

        if ($this->factor_type === 'DF6') {
            // DF6: Weighted average based on percentage
            // Formula: (High% * 5) + (Normal% * 3) + (Low% * 1) / 100
            $high = $inputs['high']['importance'] ?? 0;
            $normal = $inputs['normal']['importance'] ?? 0;
            $low = $inputs['low']['importance'] ?? 0;
            return ($high * 5 + $normal * 3 + $low * 1) / 100;
        }

        if ($this->factor_type === 'DF8') {
            // DF8: Weighted average based on percentage
            // Formula: (Outsourcing% * 5) + (Cloud% * 3) + (Insourced% * 1) / 100
            $outsourcing = $inputs['outsourcing']['importance'] ?? 0;
            $cloud = $inputs['cloud']['importance'] ?? 0;
            $insourced = $inputs['insourced']['importance'] ?? 0;
            return ($outsourcing * 5 + $cloud * 3 + $insourced * 1) / 100;
        }

        if ($this->factor_type === 'DF9') {
            // DF9: Weighted average based on percentage
            // Formula: (Agile% * 5) + (DevOps% * 3) + (Traditional% * 1) / 100
            $agile = $inputs['agile']['importance'] ?? 0;
            $devops = $inputs['devops']['importance'] ?? 0;
            $traditional = $inputs['traditional']['importance'] ?? 0;
            return ($agile * 5 + $devops * 3 + $traditional * 1) / 100;
        }

        if ($this->factor_type === 'DF10') {
            // DF10: Weighted average based on percentage
            // Formula: (FirstMover% * 5) + (Follower% * 3) + (SlowAdopter% * 1) / 100
            $firstMover = $inputs['first_mover']['importance'] ?? 0;
            $follower = $inputs['follower']['importance'] ?? 0;
            $slowAdopter = $inputs['slow_adopter']['importance'] ?? 0;
            return ($firstMover * 5 + $follower * 3 + $slowAdopter * 1) / 100;
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

        // For DF2, baseline is always 3 (fixed in input section)
        // F20 = AVERAGE(E6:E18) where all E values are 3
        if ($this->factor_type === 'DF2') {
            return 3.0;
        }

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

        // DF1, DF2, DF3, DF4, and DF7: Importance / Baseline
        // Standard COBIT 2019 scaling: Higher importance = Higher mapping score
        if (in_array($this->factor_type, ['DF1', 'DF2', 'DF3', 'DF4', 'DF7'])) {
            return $avgImp / $avgBase;
        }

        // DF6: Uses weighted calculation based on High/Normal/Low percentages
        if ($this->factor_type === 'DF6') {
            // For DF6, the weighted factor is based on importance distribution
            $inputs = $this->inputs ?? [];
            $highBase = $inputs['high']['baseline'] ?? 0;
            $normalBase = $inputs['normal']['baseline'] ?? 100;
            $lowBase = $inputs['low']['baseline'] ?? 0;
            $avgBaseline = ($highBase + $normalBase + $lowBase) / 3;
            if ($avgBaseline == 0)
                return 1.0;
            return $avgImp / ($avgBaseline / 100 * 3);
        }

        // DF8: Uses weighted calculation based on Outsourcing/Cloud/Insourced percentages
        if ($this->factor_type === 'DF8') {
            $inputs = $this->inputs ?? [];
            $outsourcingBase = $inputs['outsourcing']['baseline'] ?? 33;
            $cloudBase = $inputs['cloud']['baseline'] ?? 33;
            $insourcedBase = $inputs['insourced']['baseline'] ?? 34;
            $avgBaseline = ($outsourcingBase + $cloudBase + $insourcedBase) / 3;
            if ($avgBaseline == 0)
                return 1.0;
            return $avgImp / ($avgBaseline / 100 * 3);
        }

        // DF9: Uses weighted calculation based on Agile/DevOps/Traditional percentages
        if ($this->factor_type === 'DF9') {
            $inputs = $this->inputs ?? [];
            $agileBase = $inputs['agile']['baseline'] ?? 15;
            $devopsBase = $inputs['devops']['baseline'] ?? 10;
            $traditionalBase = $inputs['traditional']['baseline'] ?? 75;
            $avgBaseline = ($agileBase + $devopsBase + $traditionalBase) / 3;
            if ($avgBaseline == 0)
                return 1.0;
            return $avgImp / ($avgBaseline / 100 * 3);
        }

        // DF10: Uses weighted calculation based on FirstMover/Follower/SlowAdopter percentages
        if ($this->factor_type === 'DF10') {
            $inputs = $this->inputs ?? [];
            $firstMoverBase = $inputs['first_mover']['baseline'] ?? 15;
            $followerBase = $inputs['follower']['baseline'] ?? 70;
            $slowAdopterBase = $inputs['slow_adopter']['baseline'] ?? 15;
            $avgBaseline = ($firstMoverBase + $followerBase + $slowAdopterBase) / 3;
            if ($avgBaseline == 0)
                return 1.0;
            return $avgImp / ($avgBaseline / 100 * 3);
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

        // DF6, DF8, DF9, and DF10 use simpler formula: MROUND(100*Score/Baseline, 5) - 100
        if ($this->factor_type === 'DF6' || $this->factor_type === 'DF8' || $this->factor_type === 'DF9' || $this->factor_type === 'DF10') {
            $calculated = (100 * $score) / $baselineScore;
            $rounded = round($calculated / 5) * 5;
            return $rounded - 100;
        }

        // Other DFs use weighted factor
        $factor = $this->getWeightedFactor();
        $calculated = ($factor * 100 * $score) / $baselineScore;

        // MROUND to nearest 5
        $rounded = round($calculated / 5) * 5;

        return $rounded - 100;
    }

    /**
     * Get DF6 mapping values (High/Normal/Low) for dynamic score calculation
     */
    public static function getDF6Mapping(): array
    {
        return [
            'EDM01' => ['high' => 3.0, 'normal' => 2.0, 'low' => 1.0],
            'EDM02' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'EDM03' => ['high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
            'EDM04' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'EDM05' => ['high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
            'APO01' => ['high' => 2.0, 'normal' => 1.5, 'low' => 1.0],
            'APO02' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO03' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO04' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO05' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO06' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO07' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO08' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO09' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO10' => ['high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
            'APO11' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'APO12' => ['high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
            'APO13' => ['high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
            'APO14' => ['high' => 2.0, 'normal' => 1.5, 'low' => 1.0],
            'BAI01' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI02' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI03' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI04' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI05' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI06' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI07' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI08' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI09' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI10' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'BAI11' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'DSS01' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'DSS02' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'DSS03' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'DSS04' => ['high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
            'DSS05' => ['high' => 2.0, 'normal' => 1.0, 'low' => 1.0],
            'DSS06' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'MEA01' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'MEA02' => ['high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
            'MEA03' => ['high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
            'MEA04' => ['high' => 3.5, 'normal' => 2.0, 'low' => 1.0],
        ];
    }

    /**
     * Get DF4 mapping values
     */
    public static function getDF4Mapping(): array
    {
        return [];
    }

    /**
     * Get DF7 mapping values (Support/Factory/Turnaround/Strategic) for dynamic score calculation
     * Score = (Support * Support_importance) + (Factory * Factory_importance) + (Turnaround * Turnaround_importance) + (Strategic * Strategic_importance)
     */
    public static function getDF7Mapping(): array
    {
        return [
            'EDM01' => ['support' => 1.0, 'factory' => 2.0, 'turnaround' => 1.5, 'strategic' => 4.0],
            'EDM02' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.5, 'strategic' => 3.0],
            'EDM03' => ['support' => 1.0, 'factory' => 3.0, 'turnaround' => 1.0, 'strategic' => 3.0],
            'EDM04' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'EDM05' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'APO01' => ['support' => 1.0, 'factory' => 1.5, 'turnaround' => 1.5, 'strategic' => 2.5],
            'APO02' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 3.0, 'strategic' => 3.0],
            'APO03' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.0, 'strategic' => 2.0],
            'APO04' => ['support' => 0.5, 'factory' => 1.0, 'turnaround' => 3.5, 'strategic' => 4.0],
            'APO05' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.5, 'strategic' => 3.0],
            'APO06' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'APO07' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 1.5],
            'APO08' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.0, 'strategic' => 2.5],
            'APO09' => ['support' => 1.0, 'factory' => 2.0, 'turnaround' => 1.5, 'strategic' => 2.0],
            'APO10' => ['support' => 1.0, 'factory' => 2.5, 'turnaround' => 1.5, 'strategic' => 2.0],
            'APO11' => ['support' => 1.0, 'factory' => 1.5, 'turnaround' => 1.5, 'strategic' => 2.0],
            'APO12' => ['support' => 1.0, 'factory' => 2.5, 'turnaround' => 1.0, 'strategic' => 3.0],
            'APO13' => ['support' => 1.0, 'factory' => 2.0, 'turnaround' => 1.5, 'strategic' => 3.0],
            'APO14' => ['support' => 1.0, 'factory' => 1.5, 'turnaround' => 1.5, 'strategic' => 2.5],
            'BAI01' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.0, 'strategic' => 2.5],
            'BAI02' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 3.0, 'strategic' => 3.0],
            'BAI03' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 3.0, 'strategic' => 3.0],
            'BAI04' => ['support' => 1.0, 'factory' => 2.5, 'turnaround' => 1.5, 'strategic' => 2.0],
            'BAI05' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'BAI06' => ['support' => 1.0, 'factory' => 2.5, 'turnaround' => 1.0, 'strategic' => 2.0],
            'BAI07' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.0, 'strategic' => 2.0],
            'BAI08' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'BAI09' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'BAI10' => ['support' => 1.0, 'factory' => 1.5, 'turnaround' => 1.0, 'strategic' => 2.0],
            'BAI11' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 2.0, 'strategic' => 2.0],
            'DSS01' => ['support' => 1.0, 'factory' => 3.5, 'turnaround' => 1.0, 'strategic' => 3.0],
            'DSS02' => ['support' => 1.0, 'factory' => 3.0, 'turnaround' => 1.5, 'strategic' => 3.0],
            'DSS03' => ['support' => 1.0, 'factory' => 3.0, 'turnaround' => 1.5, 'strategic' => 3.5],
            'DSS04' => ['support' => 1.0, 'factory' => 3.0, 'turnaround' => 1.5, 'strategic' => 3.5],
            'DSS05' => ['support' => 1.5, 'factory' => 2.5, 'turnaround' => 1.5, 'strategic' => 3.5],
            'DSS06' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.5],
            'MEA01' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'MEA02' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
            'MEA03' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 1.5],
            'MEA04' => ['support' => 1.0, 'factory' => 1.0, 'turnaround' => 1.0, 'strategic' => 2.0],
        ];
    }

    /**
     * Get DF8 mapping values (Outsourcing/Cloud/Insourced) for dynamic score calculation
     * Score = (Outsourcing * Outsourcing_importance) + (Cloud * Cloud_importance) + (Insourced * Insourced_importance)
     */
    public static function getDF8Mapping(): array
    {
        return [
            'EDM01' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'EDM02' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'EDM03' => ['outsourcing' => 1.0, 'cloud' => 2.0, 'insourced' => 1.0],
            'EDM04' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'EDM05' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO01' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO02' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO03' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO04' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO05' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO06' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO07' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO08' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO09' => ['outsourcing' => 4.0, 'cloud' => 4.0, 'insourced' => 1.0],
            'APO10' => ['outsourcing' => 4.0, 'cloud' => 4.0, 'insourced' => 1.0],
            'APO11' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO12' => ['outsourcing' => 2.0, 'cloud' => 2.0, 'insourced' => 1.0],
            'APO13' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'APO14' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI01' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI02' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI03' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI04' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI05' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI06' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI07' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI08' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI09' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI10' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'BAI11' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS01' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS02' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS03' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS04' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS05' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'DSS06' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'MEA01' => ['outsourcing' => 3.0, 'cloud' => 3.0, 'insourced' => 1.0],
            'MEA02' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'MEA03' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            'MEA04' => ['outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
        ];
    }

    /**
     * Get DF9 mapping values (Agile/DevOps/Traditional) for dynamic score calculation
     * Score = (Agile * Agile%) + (DevOps * DevOps%) + (Traditional * Traditional%)
     */
    public static function getDF9Mapping(): array
    {
        $df9Maps = \App\Models\Df9Map::all();
        $mapping = [];

        foreach ($df9Maps as $map) {
            $mapping[$map->objective_code] = [
                'agile' => (float) $map->agile,
                'devops' => (float) $map->devops,
                'traditional' => (float) $map->traditional,
            ];
        }

        return $mapping;
    }

    /**
     * Get DF10 mapping values (FirstMover/Follower/SlowAdopter) for dynamic score calculation
     * Score = (FirstMover * FirstMover%) + (Follower * Follower%) + (SlowAdopter * SlowAdopter%)
     */
    public static function getDF10Mapping(): array
    {
        $df10Maps = \App\Models\Df10Map::all();
        $mapping = [];

        foreach ($df10Maps as $map) {
            $mapping[$map->objective_code] = [
                'first_mover' => (float) $map->first_mover,
                'follower' => (float) $map->follower,
                'slow_adopter' => (float) $map->slow_adopter,
            ];
        }

        return $mapping;
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
                ['code' => 'EDM01', 'score' => 59.5, 'baseline_score' => 35],
                ['code' => 'EDM02', 'score' => 61, 'baseline_score' => 35],
                ['code' => 'EDM03', 'score' => 39, 'baseline_score' => 23.5],
                ['code' => 'EDM04', 'score' => 65.5, 'baseline_score' => 33.5],
                ['code' => 'EDM05', 'score' => 33, 'baseline_score' => 20.5],
                ['code' => 'APO01', 'score' => 50, 'baseline_score' => 28],
                ['code' => 'APO02', 'score' => 48, 'baseline_score' => 25],
                ['code' => 'APO03', 'score' => 64.5, 'baseline_score' => 33],
                ['code' => 'APO04', 'score' => 35.5, 'baseline_score' => 16],
                ['code' => 'APO05', 'score' => 61, 'baseline_score' => 34],
                ['code' => 'APO06', 'score' => 52, 'baseline_score' => 31],
                ['code' => 'APO07', 'score' => 49, 'baseline_score' => 23.5],
                ['code' => 'APO08', 'score' => 67.5, 'baseline_score' => 35],
                ['code' => 'APO09', 'score' => 36.5, 'baseline_score' => 21.5],
                ['code' => 'APO10', 'score' => 33, 'baseline_score' => 19.5],
                ['code' => 'APO11', 'score' => 34, 'baseline_score' => 21.5],
                ['code' => 'APO12', 'score' => 44.5, 'baseline_score' => 26],
                ['code' => 'APO13', 'score' => 26.5, 'baseline_score' => 16.5],
                ['code' => 'APO14', 'score' => 48.5, 'baseline_score' => 30],
                ['code' => 'BAI01', 'score' => 37.5, 'baseline_score' => 17.5],
                ['code' => 'BAI02', 'score' => 47, 'baseline_score' => 25.5],
                ['code' => 'BAI03', 'score' => 35, 'baseline_score' => 20.5],
                ['code' => 'BAI04', 'score' => 18.5, 'baseline_score' => 11.5],
                ['code' => 'BAI05', 'score' => 27.5, 'baseline_score' => 14],
                ['code' => 'BAI06', 'score' => 38, 'baseline_score' => 21],
                ['code' => 'BAI07', 'score' => 34, 'baseline_score' => 19],
                ['code' => 'BAI08', 'score' => 34.5, 'baseline_score' => 15.5],
                ['code' => 'BAI09', 'score' => 22, 'baseline_score' => 11.5],
                ['code' => 'BAI10', 'score' => 23, 'baseline_score' => 12.5],
                ['code' => 'BAI11', 'score' => 46.5, 'baseline_score' => 22.5],
                ['code' => 'DSS01', 'score' => 21, 'baseline_score' => 13.5],
                ['code' => 'DSS02', 'score' => 24.5, 'baseline_score' => 16.5],
                ['code' => 'DSS03', 'score' => 28, 'baseline_score' => 16],
                ['code' => 'DSS04', 'score' => 16.5, 'baseline_score' => 10.5],
                ['code' => 'DSS05', 'score' => 22.5, 'baseline_score' => 14.5],
                ['code' => 'DSS06', 'score' => 20, 'baseline_score' => 14.5],
                ['code' => 'MEA01', 'score' => 52.5, 'baseline_score' => 30.5],
                ['code' => 'MEA02', 'score' => 38, 'baseline_score' => 24],
                ['code' => 'MEA03', 'score' => 18.5, 'baseline_score' => 14.5],
                ['code' => 'MEA04', 'score' => 47, 'baseline_score' => 29],
            ];
        }

        if ($type === 'DF6') {
            // DF6 uses dynamic score calculation: Score = (High * High%) + (Normal * Normal%) + (Low * Low%)
            // Mapping values from DF6map: [code, baseline, high, normal, low]
            return [
                ['code' => 'EDM01', 'score' => 2.25, 'baseline_score' => 2.00, 'high' => 3.0, 'normal' => 2.0, 'low' => 1.0],
                ['code' => 'EDM02', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'EDM03', 'score' => 2.50, 'baseline_score' => 2.00, 'high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
                ['code' => 'EDM04', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'EDM05', 'score' => 1.13, 'baseline_score' => 1.00, 'high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO01', 'score' => 1.63, 'baseline_score' => 1.50, 'high' => 2.0, 'normal' => 1.5, 'low' => 1.0],
                ['code' => 'APO02', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO03', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO04', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO05', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO06', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO07', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO08', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO09', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO10', 'score' => 1.13, 'baseline_score' => 1.00, 'high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO11', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO12', 'score' => 2.50, 'baseline_score' => 2.00, 'high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
                ['code' => 'APO13', 'score' => 1.13, 'baseline_score' => 1.00, 'high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'APO14', 'score' => 1.63, 'baseline_score' => 1.50, 'high' => 2.0, 'normal' => 1.5, 'low' => 1.0],
                ['code' => 'BAI01', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI02', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI03', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI04', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI05', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI06', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI07', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI08', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI09', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI10', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'BAI11', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS01', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS02', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS03', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS04', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.5, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS05', 'score' => 1.13, 'baseline_score' => 1.00, 'high' => 2.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'DSS06', 'score' => 1.25, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'MEA01', 'score' => 1.25, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'MEA02', 'score' => 1.00, 'baseline_score' => 1.00, 'high' => 1.0, 'normal' => 1.0, 'low' => 1.0],
                ['code' => 'MEA03', 'score' => 2.50, 'baseline_score' => 2.00, 'high' => 4.0, 'normal' => 2.0, 'low' => 1.0],
                ['code' => 'MEA04', 'score' => 2.38, 'baseline_score' => 2.00, 'high' => 3.5, 'normal' => 2.0, 'low' => 1.0],
            ];
        }

        if ($type === 'DF7') {
            return [
                ['code' => 'EDM01', 'score' => 12.5, 'baseline_score' => 25.5],
                ['code' => 'EDM02', 'score' => 18.5, 'baseline_score' => 22.5],
                ['code' => 'EDM03', 'score' => 15.5, 'baseline_score' => 24.0],
                ['code' => 'EDM04', 'score' => 17, 'baseline_score' => 15.0],
                ['code' => 'EDM05', 'score' => 12, 'baseline_score' => 15.0],
                ['code' => 'APO01', 'score' => 31.5, 'baseline_score' => 19.5],
                ['code' => 'APO02', 'score' => 24, 'baseline_score' => 24.0],
                ['code' => 'APO03', 'score' => 24, 'baseline_score' => 18.0],
                ['code' => 'APO04', 'score' => 12, 'baseline_score' => 27.0],
                ['code' => 'APO05', 'score' => 15.5, 'baseline_score' => 22.5],
                ['code' => 'APO06', 'score' => 18.5, 'baseline_score' => 15.0],
                ['code' => 'APO07', 'score' => 12.5, 'baseline_score' => 13.5],
                ['code' => 'APO08', 'score' => 12.5, 'baseline_score' => 19.5],
                ['code' => 'APO09', 'score' => 15.5, 'baseline_score' => 19.5],
                ['code' => 'APO10', 'score' => 16, 'baseline_score' => 21.0],
                ['code' => 'APO11', 'score' => 20.5, 'baseline_score' => 18.0],
                ['code' => 'APO12', 'score' => 18, 'baseline_score' => 22.5],
                ['code' => 'APO13', 'score' => 15.5, 'baseline_score' => 22.5],
                ['code' => 'APO14', 'score' => 12, 'baseline_score' => 19.5],
                ['code' => 'BAI01', 'score' => 26.5, 'baseline_score' => 19.5],
                ['code' => 'BAI02', 'score' => 6, 'baseline_score' => 24.0],
                ['code' => 'BAI03', 'score' => 13.5, 'baseline_score' => 24.0],
                ['code' => 'BAI04', 'score' => 15, 'baseline_score' => 21.0],
                ['code' => 'BAI05', 'score' => 18.5, 'baseline_score' => 15.0],
                ['code' => 'BAI06', 'score' => 17, 'baseline_score' => 19.5],
                ['code' => 'BAI07', 'score' => 12, 'baseline_score' => 18.0],
                ['code' => 'BAI08', 'score' => 9.5, 'baseline_score' => 15.0],
                ['code' => 'BAI09', 'score' => 23.5, 'baseline_score' => 15.0],
                ['code' => 'BAI10', 'score' => 15, 'baseline_score' => 16.5],
                ['code' => 'BAI11', 'score' => 12, 'baseline_score' => 18.0],
                ['code' => 'DSS01', 'score' => 10, 'baseline_score' => 25.5],
                ['code' => 'DSS02', 'score' => 11, 'baseline_score' => 25.5],
                ['code' => 'DSS03', 'score' => 12, 'baseline_score' => 27.0],
                ['code' => 'DSS04', 'score' => 16.5, 'baseline_score' => 27.0],
                ['code' => 'DSS05', 'score' => 6, 'baseline_score' => 27.0],
                ['code' => 'DSS06', 'score' => 12, 'baseline_score' => 16.5],
                ['code' => 'MEA01', 'score' => 11, 'baseline_score' => 15.0],
                ['code' => 'MEA02', 'score' => 11, 'baseline_score' => 15.0],
                ['code' => 'MEA03', 'score' => 11, 'baseline_score' => 13.5],
                ['code' => 'MEA04', 'score' => 11, 'baseline_score' => 15.0],
            ];
        }

        if ($type === 'DF8') {
            // DF8 uses dynamic score calculation: Score = (Outsourcing * Outsourcing%) + (Cloud * Cloud%) + (Insourced * Insourced%)
            return [
                ['code' => 'EDM01', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'EDM02', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'EDM03', 'score' => 1.00, 'baseline_score' => 1.33, 'outsourcing' => 1.0, 'cloud' => 2.0, 'insourced' => 1.0],
                ['code' => 'EDM04', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'EDM05', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO01', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO02', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO03', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO04', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO05', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO06', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO07', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO08', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO09', 'score' => 1.00, 'baseline_score' => 2.98, 'outsourcing' => 4.0, 'cloud' => 4.0, 'insourced' => 1.0],
                ['code' => 'APO10', 'score' => 1.35, 'baseline_score' => 2.98, 'outsourcing' => 4.0, 'cloud' => 4.0, 'insourced' => 1.0],
                ['code' => 'APO11', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO12', 'score' => 1.00, 'baseline_score' => 1.66, 'outsourcing' => 2.0, 'cloud' => 2.0, 'insourced' => 1.0],
                ['code' => 'APO13', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'APO14', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI01', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI02', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI03', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI04', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI05', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI06', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI07', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI08', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI09', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI10', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'BAI11', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS01', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS02', 'score' => 1.05, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS03', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS04', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS05', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'DSS06', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'MEA01', 'score' => 1.00, 'baseline_score' => 2.32, 'outsourcing' => 3.0, 'cloud' => 3.0, 'insourced' => 1.0],
                ['code' => 'MEA02', 'score' => 1.05, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'MEA03', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
                ['code' => 'MEA04', 'score' => 1.00, 'baseline_score' => 1.00, 'outsourcing' => 1.0, 'cloud' => 1.0, 'insourced' => 1.0],
            ];
        }

        if ($type === 'DF9') {
            // DF9 uses dynamic score calculation: Score = (Agile * Agile%) + (DevOps * DevOps%) + (Traditional * Traditional%)
            return [
                ['code' => 'EDM01', 'score' => 1.55, 'baseline_score' => 1.00, 'agile' => 2.0, 'devops' => 3.0, 'traditional' => 1.0],
                ['code' => 'EDM02', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'EDM03', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'EDM04', 'score' => 1.00, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
                ['code' => 'EDM05', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'APO01', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO02', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO03', 'score' => 1.23, 'baseline_score' => 1.10, 'agile' => 1.5, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'APO04', 'score' => 1.48, 'baseline_score' => 1.00, 'agile' => 2.0, 'devops' => 2.5, 'traditional' => 1.0],
                ['code' => 'APO05', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO06', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'APO07', 'score' => 1.08, 'baseline_score' => 1.05, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'APO08', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO09', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO10', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO11', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO12', 'score' => 1.48, 'baseline_score' => 1.05, 'agile' => 2.0, 'devops' => 2.5, 'traditional' => 1.0],
                ['code' => 'APO13', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'APO14', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI01', 'score' => 1.48, 'baseline_score' => 1.20, 'agile' => 2.0, 'devops' => 2.5, 'traditional' => 1.0],
                ['code' => 'BAI02', 'score' => 1.68, 'baseline_score' => 1.48, 'agile' => 2.5, 'devops' => 3.0, 'traditional' => 1.0],
                ['code' => 'BAI03', 'score' => 1.68, 'baseline_score' => 1.65, 'agile' => 2.5, 'devops' => 3.0, 'traditional' => 1.0],
                ['code' => 'BAI04', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI05', 'score' => 1.08, 'baseline_score' => 1.28, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'BAI06', 'score' => 1.28, 'baseline_score' => 1.48, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI07', 'score' => 1.28, 'baseline_score' => 1.38, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI08', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'BAI09', 'score' => 1.28, 'baseline_score' => 1.00, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI10', 'score' => 1.28, 'baseline_score' => 1.18, 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
                ['code' => 'BAI11', 'score' => 1.08, 'baseline_score' => 1.23, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS01', 'score' => 1.08, 'baseline_score' => 1.15, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS02', 'score' => 1.08, 'baseline_score' => 1.05, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS03', 'score' => 1.08, 'baseline_score' => 1.05, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS04', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS05', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'DSS06', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'MEA01', 'score' => 1.08, 'baseline_score' => 1.13, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'MEA02', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'MEA03', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
                ['code' => 'MEA04', 'score' => 1.08, 'baseline_score' => 1.00, 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ];
        }

        if ($type === 'DF10') {
            // DF10 uses dynamic score calculation: Score = (FirstMover * FirstMover%) + (Follower * Follower%) + (SlowAdopter * SlowAdopter%)
            // Default importance: FirstMover 75%, Follower 15%, SlowAdopter 10%
            // Score = (FM * 0.75) + (F * 0.15) + (SA * 0.10)
            return [
                ['code' => 'EDM01', 'score' => 3.15, 'baseline_score' => 2.50, 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.5],
                ['code' => 'EDM02', 'score' => 3.53, 'baseline_score' => 2.58, 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.5],
                ['code' => 'EDM03', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'EDM04', 'score' => 2.33, 'baseline_score' => 2.00, 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.5],
                ['code' => 'EDM05', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'APO01', 'score' => 2.20, 'baseline_score' => 1.58, 'first_mover' => 2.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO02', 'score' => 3.60, 'baseline_score' => 2.93, 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.5],
                ['code' => 'APO03', 'score' => 1.75, 'baseline_score' => 1.15, 'first_mover' => 2.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'APO04', 'score' => 3.55, 'baseline_score' => 2.85, 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.0],
                ['code' => 'APO05', 'score' => 3.48, 'baseline_score' => 2.50, 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.0],
                ['code' => 'APO06', 'score' => 1.08, 'baseline_score' => 1.35, 'first_mover' => 1.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO07', 'score' => 2.13, 'baseline_score' => 1.23, 'first_mover' => 2.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'APO08', 'score' => 2.58, 'baseline_score' => 1.65, 'first_mover' => 3.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO09', 'score' => 1.45, 'baseline_score' => 1.43, 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO10', 'score' => 2.20, 'baseline_score' => 1.58, 'first_mover' => 2.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO11', 'score' => 1.45, 'baseline_score' => 1.43, 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO12', 'score' => 1.83, 'baseline_score' => 1.50, 'first_mover' => 2.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'APO13', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'APO14', 'score' => 2.28, 'baseline_score' => 1.93, 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI01', 'score' => 3.60, 'baseline_score' => 2.93, 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.5],
                ['code' => 'BAI02', 'score' => 3.10, 'baseline_score' => 2.43, 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
                ['code' => 'BAI03', 'score' => 3.48, 'baseline_score' => 2.50, 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.0],
                ['code' => 'BAI04', 'score' => 1.45, 'baseline_score' => 1.43, 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
                ['code' => 'BAI05', 'score' => 2.65, 'baseline_score' => 2.00, 'first_mover' => 3.0, 'follower' => 2.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI06', 'score' => 2.28, 'baseline_score' => 1.93, 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI07', 'score' => 3.10, 'baseline_score' => 2.43, 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
                ['code' => 'BAI08', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI09', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI10', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'BAI11', 'score' => 3.10, 'baseline_score' => 2.43, 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
                ['code' => 'DSS01', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'DSS02', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'DSS03', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'DSS04', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'DSS05', 'score' => 1.38, 'baseline_score' => 1.08, 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'DSS06', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'MEA01', 'score' => 2.65, 'baseline_score' => 2.00, 'first_mover' => 3.0, 'follower' => 2.0, 'slow_adopter' => 1.0],
                ['code' => 'MEA02', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'MEA03', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
                ['code' => 'MEA04', 'score' => 1.00, 'baseline_score' => 1.00, 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ];
        }

        return [];
    }

    /**
     * Check if all inputs are filled (no empty values)
     */
    public function isFullyFilled(): bool
    {
        $inputs = $this->inputs ?? [];
        if (empty($inputs)) {
            return false;
        }

        foreach ($inputs as $input) {
            if ($this->factor_type === 'DF3') {
                // For DF3, check impact and likelihood
                if (!isset($input['impact']) || !isset($input['likelihood'])) {
                    return false;
                }
            } else {
                // For DF1, DF2, DF4, check importance
                if (!isset($input['importance'])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check if user can access a specific DF type
     */
    public static function canAccess(int $userId, string $type): bool
    {
        // DF1 is always accessible
        if ($type === 'DF1') {
            return true;
        }

        // Get the previous DF type - NEW ORDER: DF1, DF2, DF3, DF4, Summary, DF5
        $dfOrder = ['DF1', 'DF2', 'DF3', 'DF4', 'Summary', 'DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];
        $currentIndex = array_search($type, $dfOrder);

        if ($currentIndex === false || $currentIndex === 0) {
            return true;
        }

        $previousType = $dfOrder[$currentIndex - 1];

        // Summary requires only DF1-DF4 to be completed (not DF5)
        if ($type === 'Summary') {
            $allCompleted = true;
            foreach (['DF1', 'DF2', 'DF3', 'DF4'] as $dfType) {
                $df = self::where('user_id', $userId)
                    ->where('factor_type', $dfType)
                    ->first();

                if (!$df || !$df->is_completed) {
                    $allCompleted = false;
                    break;
                }
            }
            return $allCompleted;
        }

        // DF5 requires Summary to be accessible (which means DF1-DF4 completed)
        if ($type === 'DF5') {
            // Check if Summary is accessible (DF1-DF4 completed)
            return self::canAccess($userId, 'Summary');
        }

        if ($previousType === 'DF5') {
            $previousDF = \App\Models\DesignFactor5::where('user_id', $userId)->first();
            return $previousDF !== null;
        }

        // Check if previous DF is completed
        $previousDF = self::where('user_id', $userId)
            ->where('factor_type', $previousType)
            ->first();

        return $previousDF && $previousDF->is_completed;
    }

    /**
     * Get progress information for a user
     */
    public static function getProgress(int $userId): array
    {
        $progress = [];
        $types = ['DF1', 'DF2', 'DF3', 'DF4', 'DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];

        foreach ($types as $type) {
            if ($type === 'DF5') {
                $df = \App\Models\DesignFactor5::where('user_id', $userId)->first();
                $progress[$type] = [
                    'exists' => $df !== null,
                    'completed' => $df !== null,
                    'locked' => false, // DF5 is never locked by Summary
                    'accessible' => self::canAccess($userId, $type),
                ];
                continue;
            }

            $df = self::where('user_id', $userId)
                ->where('factor_type', $type)
                ->first();

            $progress[$type] = [
                'exists' => $df !== null,
                'completed' => $df ? $df->is_completed : false,
                'locked' => $df ? $df->is_locked : false,
                'accessible' => self::canAccess($userId, $type),
            ];
        }

        // Check if summary is accessible
        // Summary is locked when DF1-DF4 are all locked (not including DF5)
        $progress['Summary'] = [
            'accessible' => self::canAccess($userId, 'Summary'),
            'locked' => $progress['DF1']['locked'] && $progress['DF2']['locked'] &&
                $progress['DF3']['locked'] && $progress['DF4']['locked'],
        ];

        return $progress;
    }

    /**
     * Lock all design factors for a user
     */
    public static function lockAll(int $userId): void
    {
        self::where('user_id', $userId)
            ->update(['is_locked' => true]);
    }
}

