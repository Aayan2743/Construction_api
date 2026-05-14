<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReport extends Model
{
     protected $fillable = [

        'date',
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
}
