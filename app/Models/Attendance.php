<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
   protected $fillable = [
        'labour_id',
        'date',
        'is_present',
        'added_by'
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}
