<?php

namespace App\Console\Commands;

use App\Models\DesignFactor;
use App\Models\DesignFactorItem;
use Illuminate\Console\Command;

class UpdateDF9Mapping extends Command
{
    protected $signature = 'df9:update-mapping';
    protected $description = 'Update DF9 mapping values and recalculate scores for all users';

    public function handle()
    {
        $this->info('Updating DF9 mapping values and recalculating scores...');

        // Get new mapping values
        $mapping = DesignFactor::getDF9Mapping();

        $df9Factors = DesignFactor::where('factor_type', 'DF9')->get();

        if ($df9Factors->isEmpty()) {
            $this->warn('No DF9 records found.');
            return 0;
        }

        $updatedCount = 0;
        foreach ($df9Factors as $factor) {
            $this->info("Processing DF9 for user ID: {$factor->user_id}");

            // Get current importance percentages
            $inputs = $factor->inputs ?? [];
            $agilePercent = ($inputs['agile']['importance'] ?? 50) / 100;
            $devopsPercent = ($inputs['devops']['importance'] ?? 10) / 100;
            $traditionalPercent = ($inputs['traditional']['importance'] ?? 40) / 100;

            foreach ($mapping as $code => $values) {
                $item = DesignFactorItem::where('design_factor_id', $factor->id)
                    ->where('code', $code)
                    ->first();

                if ($item) {
                    // Recalculate score using MMULT formula
                    // Score = (Agile * Agile%) + (DevOps * DevOps%) + (Traditional * Traditional%)
                    $newScore = ($values['agile'] * $agilePercent) +
                        ($values['devops'] * $devopsPercent) +
                        ($values['traditional'] * $traditionalPercent);

                    $oldScore = $item->score;
                    $item->score = round($newScore, 2);

                    // Recalculate relative importance
                    $item->relative_importance = $factor->calculateRelativeImportance(
                        $item->score,
                        $item->baseline_score
                    );

                    $item->save();
                    $updatedCount++;

                    $this->line("  Updated {$code}: Score {$oldScore} → {$item->score}, Mapping [Agile:{$values['agile']}, DevOps:{$values['devops']}, Traditional:{$values['traditional']}]");
                }
            }
        }

        $this->info("Successfully updated {$updatedCount} items with new mapping values and scores!");
        return 0;
    }
}
