<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReport extends Model
{
     protected $fillable = [

        'date',
         'project_id',
        'item_id',
        'vendor_id',
        'opening_balance',
        'received',
        'used',
        'balance',
        'added_by'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function editHistories()
{
    return $this->hasMany(
        StockReportEditHistory::class,
        'stock_report_id'
    );
}

public function deleteHistories()
{
    return $this->hasMany(
        StockReportDeleteHistory::class,
        'stock_report_id'
    );
}

public function manager()
{
    return $this->belongsTo(
        User::class,
        'added_by'
    );
}
}
