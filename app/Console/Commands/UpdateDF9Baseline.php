<?php

namespace App\Console\Commands;

use App\Models\DesignFactor;
use App\Models\DesignFactorItem;
use Illuminate\Console\Command;

class UpdateDF9Baseline extends Command
{
    protected $signature = 'df9:update-baseline';
    protected $description = 'Update DF9 baseline scores for all users';

    public function handle()
    {
        $this->info('Updating DF9 baseline scores...');

        // New baseline values
        $newBaselines = [
            'EDM01' => 1.00,
            'EDM02' => 1.00,
            'EDM03' => 1.00,
            'EDM04' => 1.00,
            'EDM05' => 1.00,
            'APO01' => 1.00,
            'APO02' => 1.00,
            'APO03' => 1.10,
            'APO04' => 1.00,
            'APO05' => 1.00,
            'APO06' => 1.00,
            'APO07' => 1.05,
            'APO08' => 1.00,
            'APO09' => 1.00,
            'APO10' => 1.00,
            'APO11' => 1.00,
            'APO12' => 1.05,
            'APO13' => 1.00,
            'APO14' => 1.00,
            'BAI01' => 1.20,
            'BAI02' => 1.48,
            'BAI03' => 1.65,
            'BAI04' => 1.00,
            'BAI05' => 1.28,
            'BAI06' => 1.48,
            'BAI07' => 1.38,
            'BAI08' => 1.00,
            'BAI09' => 1.00,
            'BAI10' => 1.18,
            'BAI11' => 1.23,
            'DSS01' => 1.15,
            'DSS02' => 1.05,
            'DSS03' => 1.05,
            'DSS04' => 1.00,
            'DSS05' => 1.00,
            'DSS06' => 1.00,
            'MEA01' => 1.13,
            'MEA02' => 1.00,
            'MEA03' => 1.00,
            'MEA04' => 1.00,
        ];

        $df9Factors = DesignFactor::where('factor_type', 'DF9')->get();

        if ($df9Factors->isEmpty()) {
            $this->warn('No DF9 records found.');
            return 0;
        }

        $updatedCount = 0;
        foreach ($df9Factors as $factor) {
            $this->info("Processing DF9 for user ID: {$factor->user_id}");

            foreach ($newBaselines as $code => $baselineScore) {
                $item = DesignFactorItem::where('design_factor_id', $factor->id)
                    ->where('code', $code)
                    ->first();

                if ($item) {
                    $oldBaseline = $item->baseline_score;
                    $item->baseline_score = $baselineScore;
                    $item->save();
                    $updatedCount++;
                    $this->line("  Updated {$code}: {$oldBaseline} → {$baselineScore}");
                }
            }
        }

        $this->info("Successfully updated {$updatedCount} baseline scores!");
        return 0;
    }
}
