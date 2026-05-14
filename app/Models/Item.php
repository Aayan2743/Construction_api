<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     protected $fillable = ['name', 'type'];


     public function item()
{
    return $this->belongsTo(
        Item::class,
        'item_id'
    );
}
}
