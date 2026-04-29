<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialEntry extends Model
{
    protected $fillable = [
        'item_id',
        'qty',
        'project_id',
        'supplier',
        'vendor_id',
        'added_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function histories()
    {
        return $this->hasMany(MaterialEntryHistory::class);
    }
}

