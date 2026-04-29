<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
      protected $fillable = [
        'full_name',
        'age',
        'gender',
        'vendor_id',
        'phone',
        'daily_wage',
        'added_by',
        'profile_pic'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function vendor()
{
    return $this->belongsTo(Vendor::class);
}

    public function wages()
    {
        return $this->hasMany(LabourWage::class);
    }

    public function histories()
    {
        return $this->hasMany(LabourHistory::class);
    }

    public function currentWage()
    {
        return $this->hasOne(LabourWage::class)
            ->whereNull('effective_to')
            ->latest('effective_from');
    }



 public function getProfilePicAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
