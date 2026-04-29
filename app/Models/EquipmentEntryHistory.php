<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentEntryHistory extends Model
{
    protected $fillable = [
        'equipment_entry_id',
        'user_id',
        'remarks',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function entry()
    {
        return $this->belongsTo(EquipmentEntry::class, 'equipment_entry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

