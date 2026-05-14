<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourWorkEditHistory extends Model
{
      protected $fillable = [

        'labour_work_id',
        'reason',
        'old_work_done',
        'old_measurement',
        'old_date',
        'edited_by'
    ];

    public function work()
    {
        return $this->belongsTo(LabourWork::class, 'labour_work_id');
    }
}
