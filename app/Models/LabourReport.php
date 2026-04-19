<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourReport extends Model
{
     protected $fillable = [
        'vendor_id',
        'mason',
        'male_skilled',
        'female_unskilled',
        'others',
        'work_done',
        'date',
        'added_by'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
