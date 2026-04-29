<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialEntryHistory extends Model
{
    protected $fillable = [
        'material_entry_id',
        'user_id',
        'remarks',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function entry()
    {
        return $this->belongsTo(MaterialEntry::class, 'material_entry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

