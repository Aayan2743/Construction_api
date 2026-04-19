<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentEntry extends Model
{
      protected $fillable = [
        'equipment_id',
        'vendor_id',
        'start_time',
        'end_time',
        'total_hours',
        'work_done',
        'date',
        'added_by'
    ];

    public function equipment()
    {
        return $this->belongsTo(Item::class, 'equipment_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
