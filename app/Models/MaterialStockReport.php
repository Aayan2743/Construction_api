<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialStockReport extends Model
{
    protected $fillable = [
        'project_id',
        'vendor_id',
        'item_id',
        'report_date',
        'opening_balance',
        'received_qty',
        'consumed_qty',
        'closing_balance',
        'added_by',
    ];

    protected $casts = [
        'report_date' => 'date:Y-m-d',
        'opening_balance' => 'decimal:2',
        'received_qty' => 'decimal:2',
        'consumed_qty' => 'decimal:2',
        'closing_balance' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}

