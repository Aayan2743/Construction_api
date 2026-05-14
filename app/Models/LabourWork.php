<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourWork extends Model
{
    public $guarded = [];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }

    public function editHistories()
{
    return $this->hasMany(LabourWorkEditHistory::class);
}
}
