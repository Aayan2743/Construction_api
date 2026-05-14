<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialConsumption extends Model
{
    protected $fillable = [
        'project_id',
        'vendor_id',
        'item_id',
        'consumption_date',
        'work',
        'qty',
        'added_by',
    ];

    protected $casts = [
        'consumption_date' => 'date:Y-m-d',
        'qty' => 'decimal:2',
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

