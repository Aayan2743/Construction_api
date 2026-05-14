<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReportEditHistory extends Model
{
    public $guarded = [];

     public function stockReport()
    {
        return $this->belongsTo(StockReport::class);
    }
}
