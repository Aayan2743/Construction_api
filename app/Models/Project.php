<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
        'location',
        'start_date',
        'status',
        'budget',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
