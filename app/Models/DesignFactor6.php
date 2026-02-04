<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignFactor6 extends Model
{
    use HasFactory;

    protected $table = 'design_factor6';

    protected $fillable = [
        'user_id',
        'importance_high',
        'importance_normal',
        'importance_low',
    ];

    protected $casts = [
        'importance_high' => 'decimal:2',
        'importance_normal' => 'decimal:2',
        'importance_low' => 'decimal:2',
    ];

    /**
     * Get the user that owns this DF6
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate scores using matrix multiplication
     * Score = MMULT(DF6map, Importance)
     */
    public function calculateScores(): array
    {
        $df6MapData = Df6Map::orderBy('objective_code')->get();
        $scores = [];

        foreach ($df6MapData as $map) {
            $score = ($map->high_value * $this->importance_high) +
                ($map->normal_value * $this->importance_normal) +
                ($map->low_value * $this->importance_low);

            $scores[$map->objective_code] = $score;
        }

        return $scores;
    }

    /**
     * Calculate baseline scores using fixed baseline values
     * Baseline: High=0%, Normal=100%, Low=0%
     */
    public static function calculateBaselineScores(): array
    {
        $df6MapData = Df6Map::orderBy('objective_code')->get();
        $baselineScores = [];

        $baselineHigh = 0.00;
        $baselineNormal = 100.00;
        $baselineLow = 0.00;

        foreach ($df6MapData as $map) {
            $baselineScore = ($map->high_value * $baselineHigh) +
                ($map->normal_value * $baselineNormal) +
                ($map->low_value * $baselineLow);

            $baselineScores[$map->objective_code] = $baselineScore;
        }

        return $baselineScores;
    }

    /**
     * Calculate relative importance for each objective
     * Formula: IFERROR(MROUND((100*Score/BaselineScore);5)-100;0)
     */
    public function calculateRelativeImportance(): array
    {
        $scores = $this->calculateScores();
        $baselineScores = self::calculateBaselineScores();
        $relativeImportance = [];

        foreach ($scores as $code => $score) {
            $baselineScore = $baselineScores[$code] ?? 1;

            if ($baselineScore == 0) {
                $relativeImportance[$code] = 0;
                continue;
            }

            // Calculate: 100 * Score / BaselineScore
            $calculated = (100 * $score) / $baselineScore;

            // MROUND to nearest 5
            $rounded = round($calculated / 5) * 5;

            // Subtract 100
            $relativeImportance[$code] = $rounded - 100;
        }

        return $relativeImportance;
    }

    /**
     * Validate that importance values sum to 100
     */
    public function validateImportanceSum(): bool
    {
        $sum = $this->importance_high + $this->importance_normal + $this->importance_low;
        return abs($sum - 100.00) < 0.01; // Allow small floating point differences
    }
}
