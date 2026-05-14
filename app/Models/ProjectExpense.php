<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
     protected $fillable = [

        'project_id',

        'expense_type',

        'party_id',

        'amount',

        'remarks',

        'date',

        'added_by'
    ];

    public function party()
    {
        return $this->belongsTo(
            Vendor::class,
            'party_id'
        );
    }

    public function project()
{
    return $this->belongsTo(
        Project::class,
        'project_id'
    );
}
}
