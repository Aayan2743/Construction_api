<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourHistory extends Model
{
    protected $fillable = [
        'labour_id',
        'user_id',
        'type',
        'remarks',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

