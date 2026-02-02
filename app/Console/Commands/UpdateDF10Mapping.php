<?php

namespace App\Console\Commands;

use App\Models\DesignFactor;
use App\Models\DesignFactorItem;
use Illuminate\Console\Command;

class UpdateDF10Mapping extends Command
{
    protected $signature = 'df10:update-mapping';
    protected $description = 'Update DF10 mapping values, baselines, and recalculate scores for all users';

    public function handle()
    {
        $this->info('Updating DF10 mapping values, baselines and recalculating scores...');

        // New baseline values provided by the user
        $baselines = [
            'EDM01' => 2.50,
            'EDM02' => 2.58,
            'EDM03' => 1.08,
            'EDM04' => 2.00,
            'EDM05' => 1.08,
            'APO01' => 1.58,
            'APO02' => 2.93,
            'APO03' => 1.15,
            'APO04' => 2.85,
            'APO05' => 2.50,
            'APO06' => 1.35,
            'APO07' => 1.23,
            'APO08' => 1.65,
            'APO09' => 1.43,
            'APO10' => 1.58,
            'APO11' => 1.43,
            'APO12' => 1.50,
            'APO13' => 1.00,
            'APO14' => 1.93,
            'BAI01' => 2.93,
            'BAI02' => 2.43,
            'BAI03' => 2.50,
            'BAI04' => 1.43,
            'BAI05' => 2.00,
            'BAI06' => 1.93,
            'BAI07' => 2.43,
            'BAI08' => 1.08,
            'BAI09' => 1.00,
            'BAI10' => 1.08,
            'BAI11' => 2.43,
            'DSS01' => 1.00,
            'DSS02' => 1.00,
            'DSS03' => 1.08,
            'DSS04' => 1.08,
            'DSS05' => 1.08,
            'DSS06' => 1.00,
            'MEA01' => 2.00,
            'MEA02' => 1.00,
            'MEA03' => 1.00,
            'MEA04' => 1.00,
        ];

        // Get new mapping values
        $mapping = DesignFactor::getDF10Mapping();

        $df10Factors = DesignFactor::where('factor_type', 'DF10')->get();

        if ($df10Factors->isEmpty()) {
            $this->warn('No DF10 records found.');
            return 0;
        }

        $updatedCount = 0;
        foreach ($df10Factors as $factor) {
            $this->info("Processing DF10 for user ID: {$factor->user_id}");

            // Get current importance percentages
            $inputs = $factor->inputs ?? [];
            $fmPercent = ($inputs['first_mover']['importance'] ?? 75) / 100;
            $fPercent = ($inputs['follower']['importance'] ?? 15) / 100;
            $saPercent = ($inputs['slow_adopter']['importance'] ?? 10) / 100;

            foreach ($mapping as $code => $values) {
                $item = DesignFactorItem::where('design_factor_id', $factor->id)
                    ->where('code', $code)
                    ->first();

                if ($item) {
                    // Update baseline score
                    $newBaseline = $baselines[$code] ?? 1.00;
                    $oldBaseline = $item->baseline_score;
                    $item->baseline_score = $newBaseline;

                    // Recalculate score using MMULT formula
                    // Score = (FM * FM%) + (F * F%) + (SA * SA%)
                    $newScore = ($values['first_mover'] * $fmPercent) +
                        ($values['follower'] * $fPercent) +
                        ($values['slow_adopter'] * $saPercent);

                    $oldScore = $item->score;
                    $item->score = round($newScore, 2);

                    // Recalculate relative importance
                    $item->relative_importance = $factor->calculateRelativeImportance(
                        $item->score,
                        $item->baseline_score
                    );

                    $item->save();
                    $updatedCount++;

                    $this->line("  Updated {$code}: Score {$oldScore} → {$item->score}, Baseline {$oldBaseline} → {$item->baseline_score}");
                }
            }
        }

        $this->info("Successfully updated {$updatedCount} items with new baseline values and scores!");
        return 0;
    }
}
