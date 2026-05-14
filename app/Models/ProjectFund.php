<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFund extends Model
{
    protected $fillable = [
        'project_id',
        'total_received',
        'added_by',
    ];

    protected $casts = [
        'total_received' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}

