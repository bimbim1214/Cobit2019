<?php
use App\Models\DesignFactor;
use App\Models\DesignFactorItem;

// Get all DF8 design factors
$factors = DesignFactor::where('factor_type', 'DF8')->get();

foreach ($factors as $factor) {
    // Delete items first
    DesignFactorItem::where('design_factor_id', $factor->id)->delete();
    // Delete factor
    $factor->delete();
}

echo "DF8 data deleted successfully!\n";
