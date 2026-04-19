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



 public function getProfilePicAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
