<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourWorkDeleteHistory extends Model
{
       protected $fillable = [

        'labour_work_id',
        'remarks',
        'deleted_by'
    ];
}
