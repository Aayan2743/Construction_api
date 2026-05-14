<?php

namespace App\Http\Controllers;

use App\Models\MaterialEntry;
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
        'project_id' => 'required|exists:projects,id',

        'item_id'          => 'required|exists:items,id',

        'vendor_id'        => 'required|exists:vendors,id',

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

        'project_id' => $request->project_id,

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
        'project_id' => 'required|exists:projects,id',

        'vendor_id' => 'required|exists:vendors,id',

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

        'project_id' => $request->project_id,

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

   public function stockHistoryReport(Request $request)
{
$projectId = $request->get('project_id');

$date = $request->get('date');

$query = StockReport::with([

        'item:id,name',

        'vendor:id,name',

        'manager:id,name',

        'editHistories',

        'deleteHistories'

    ]);

// ✅ Project Filter
if ($projectId) {

    $query->where('project_id', $projectId);
}

// ✅ Date Filter
if ($date) {

    $query->whereDate('date', $date);
}

$stocks = $query->latest()->get();

$data = $stocks->map(function ($stock) {


return [

    'id' => $stock->id,

    'project_id' => $stock->project_id,

    'date' => $stock->date,

    'manager' => [

        'id' => optional(
            $stock->manager
        )->id,

        'name' => optional(
            $stock->manager
        )->name

    ],

    'vendor' => optional(
        $stock->vendor
    )->name,

    'item_name' => optional(
        $stock->item
    )->name,

    'opening_balance' => $stock->opening_balance,

    'received' => $stock->received,

    'used' => $stock->used,

    'balance' => $stock->balance,

    // ✅ All Edit Histories
    'edit_histories' => $stock->editHistories
        ->map(function ($history) {

            return [

                'id' => $history->id,

                'reason' => $history->reason,

                'edited_by' => $history->edited_by,

                'created_at' => $history->created_at
                    ->format('d/m/Y h:i A')

            ];

        }),

    // ✅ All Delete Histories
    'delete_histories' => $stock->deleteHistories
        ->map(function ($history) {

            return [

                'id' => $history->id,

                'remarks' => $history->remarks,

                'deleted_by' => $history->deleted_by,

                'created_at' => $history->created_at
                    ->format('d/m/Y h:i A')

            ];

        })

];


});


return response()->json([

    'success' => true,

    'data' => $data

]);


    }


   public function materialEntryHistory(Request $request)
{
$projectId = $request->get('project_id');


$date = $request->get('date');

$query = MaterialEntry::with([

        'item:id,name',

        'vendor:id,name',

        'manager:id,name',

        'histories'

    ]);

// ✅ Project Filter
if ($projectId) {

    $query->where('project_id', $projectId);
}

// ✅ Date Filter
if ($date) {

    $query->whereDate('entry_date', $date);
}

$entries = $query->latest()->get();

$data = $entries->map(function ($entry, $index) {

    // ✅ Latest Edit History
    $latestHistory = $entry->histories->last();

    return [

        's_no' => $index + 1,

        'id' => $entry->id,

        'project_id' => $entry->project_id,

        'date' => $entry->entry_date,

        'manager' => [

            'id' => optional(
                $entry->manager
            )->id,

            'name' => optional(
                $entry->manager
            )->name

        ],

        'vendor' => optional(
            $entry->vendor
        )->name,

        'item_name' => optional(
            $entry->item
        )->name,

        'quantity' => $entry->qty,

        'edit_reason' => optional(
            $latestHistory
        )->remarks,

        'changes' => optional(
            $latestHistory
        )->changes

    ];

});

return response()->json([

    'success' => true,

    'data' => $data

]);


    }






}
