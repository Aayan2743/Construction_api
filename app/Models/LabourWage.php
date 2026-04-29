<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourWage extends Model
{
    protected $fillable = [
        'labour_id',
        'daily_wage',
        'effective_from',
        'effective_to',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}

