<?php

namespace App\Http\Controllers;

use App\Models\StockReport;
use App\Models\StockReportDeleteHistory;
use App\Models\StockReportEditHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class stockreportcontroller extends Controller
{
    public function addStockReport(Request $request)
{
    $validator = Validator::make($request->all(), [

        'date'             => 'required|date',

        'item_id'          => 'required|exists:items,id',

        'vendor_id'        => 'nullable|exists:vendors,id',

        'opening_balance'  => 'required|numeric',

        'received'         => 'required|numeric',

        'used'             => 'required|numeric',

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    // ✅ Auto Balance Calculation
    $balance = (
        $request->opening_balance +
        $request->received
    ) - $request->used;

    $stock = StockReport::create([

        'date' => $request->date,

        'item_id' => $request->item_id,

        'vendor_id' => $request->vendor_id,

        'opening_balance' => $request->opening_balance,

        'received' => $request->received,

        'used' => $request->used,

        'balance' => $balance,

        'added_by' => $request->user()->id
    ]);

    return response()->json([

        'success' => true,

        'message' => 'Stock report added successfully',

        'data' => $stock

    ]);
    }

    public function stockReportList(Request $request)
{
    $search = $request->get('search');

    $date = $request->get(
        'date',
        Carbon::today()->toDateString()
    );

    $query = StockReport::with([

            'item:id,name',

            'vendor:id,name'

        ])

        ->whereDate('date', $date)

        ->where('added_by', $request->user()->id);

    // ✅ Search
    if ($search) {

        $query->where(function ($q) use ($search) {

            $q->whereHas('vendor', function ($vendorQuery) use ($search) {

                $vendorQuery->where(
                    'name',
                    'LIKE',
                    "%{$search}%"
                );

            })

            ->orWhereHas('item', function ($itemQuery) use ($search) {

                $itemQuery->where(
                    'name',
                    'LIKE',
                    "%{$search}%"
                );

            });

        });
    }

    $stocks = $query->latest()->get();

    $data = $stocks->map(function ($stock) {

        return [

            'id' => $stock->id,

            'date' => $stock->date,

            'vendor' => [

                'id' => optional($stock->vendor)->id,

                'name' => optional($stock->vendor)->name

            ],

            'item' => [

                'id' => optional($stock->item)->id,

                'name' => optional($stock->item)->name

            ],

            'opening_balance' => $stock->opening_balance,

            'received' => $stock->received,

            'used' => $stock->used,

            'balance' => $stock->balance,

            'added_by' => $stock->added_by,

            'updated_by' => $stock->updated_by,

            'created_at' => $stock->created_at

        ];

    });

    return response()->json([

        'success' => true,

        'selected_date' => $date,

        'data' => $data

    ]);
    }

    public function stockReportDetails($id, Request $request)
{
    $stock = StockReport::with([

            'item:id,name',

            'vendor:id,name'

        ])

        ->where('id', $id)

        ->where('added_by', $request->user()->id)

        ->first();

    if (!$stock) {

        return response()->json([

            'success' => false,

            'message' => 'Stock report not found'

        ], 404);
    }

    return response()->json([

        'success' => true,

        'data' => [

            'id' => $stock->id,

            'date' => $stock->date,

            'item' => [

                'id' => optional($stock->item)->id,

                'name' => optional($stock->item)->name

            ],

            'vendor' => [

                'id' => optional($stock->vendor)->id,

                'name' => optional($stock->vendor)->name

            ],

            'opening_balance' => $stock->opening_balance,

            'received' => $stock->received,

            'used' => $stock->used,

            'balance' => $stock->balance

        ]

    ]);
    }

    public function updateStockReport(Request $request, $id)
{
    $validator = Validator::make($request->all(), [

        'date' => 'required|date',

        'item_id' => 'required|exists:items,id',

        'vendor_id' => 'nullable|exists:vendors,id',

        'opening_balance' => 'required|numeric',

        'received' => 'required|numeric',

        'used' => 'required|numeric',

        'reason' => 'required|string'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    $stock = StockReport::where('id', $id)

        ->where('added_by', $request->user()->id)

        ->first();

    if (!$stock) {

        return response()->json([

            'success' => false,

            'message' => 'Stock report not found'

        ], 404);
    }

    // ✅ Store Edit History
    StockReportEditHistory::create([

        'stock_report_id' => $stock->id,

        'reason' => $request->reason,

        'old_opening_balance' => $stock->opening_balance,

        'old_received' => $stock->received,

        'old_used' => $stock->used,

        'old_balance' => $stock->balance,

        'edited_by' => $request->user()->id
    ]);

    // ✅ Auto Balance
    $balance = (
        $request->opening_balance +
        $request->received
    ) - $request->used;

    // ✅ Update
    $stock->update([

        'date' => $request->date,

        'item_id' => $request->item_id,

        'vendor_id' => $request->vendor_id,

        'opening_balance' => $request->opening_balance,

        'received' => $request->received,

        'used' => $request->used,

        'balance' => $balance,

        'updated_by' => $request->user()->id

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Stock updated successfully',

        'data' => $stock

    ]);
    }

    public function deleteStockReport(Request $request, $id)
{
    $validator = Validator::make($request->all(), [

        'remarks' => 'required|string'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    $stock = StockReport::where('id', $id)

        ->where('added_by', $request->user()->id)

        ->first();

    if (!$stock) {

        return response()->json([

            'success' => false,

            'message' => 'Stock report not found'

        ], 404);
    }

    // ✅ Store Delete History
    StockReportDeleteHistory::create([

        'stock_report_id' => $stock->id,

        'remarks' => $request->remarks,

        'deleted_by' => $request->user()->id

    ]);

    // ✅ Delete Stock Report
    $stock->delete();

    return response()->json([

        'success' => true,

        'message' => 'Stock report deleted successfully'

    ]);
}
}
