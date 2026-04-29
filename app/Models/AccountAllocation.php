<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAllocation extends Model
{
    protected $table = 'account_allocations';

    protected $fillable = [
        'user_id',
        'role',
        'project_id',
        'amount',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
