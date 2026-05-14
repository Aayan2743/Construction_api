<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReportDeleteHistory extends Model
{
    //
      protected $fillable = [

        'stock_report_id',

        'remarks',

        'deleted_by'
    ];
}
