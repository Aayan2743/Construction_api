<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaterialConsumption;
use App\Models\MaterialEntry;
use App\Models\MaterialStockReport;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialStockReportController extends Controller
{
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'item_id' => 'nullable|exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user()->id;
        // $userId = 2;
        $projectId = (int) $request->project_id;
        $vendorId = (int) $request->vendor_id;
        $date = Carbon::parse($request->date)->toDateString();

        $project = Project::where('id', $projectId)
            ->where('manager_id', $userId)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $itemId = $request->item_id ? (int) $request->item_id : null;

        // Default to "cement" item if not provided (best-effort)
        if (! $itemId) {
            $cement = Item::where('type', 'material')
                ->where('name', 'LIKE', '%cement%')
                ->orderBy('id')
                ->first();

            if (! $cement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cement item not found. Please pass item_id.',
                ], 422);
            }

            $itemId = (int) $cement->id;
        }

        // Received = sum of material entries qty for this vendor+project+item on that date
        $receivedQty = (float) MaterialEntry::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('entry_date', $date)
            ->sum('qty');

        // Get existing report for date (to preserve manual opening/consumed if already set)
        $report = MaterialStockReport::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('report_date', $date)
            ->first();

        $openingBalance = (float) ($report?->opening_balance ?? 0);
        $consumedQty = (float) MaterialConsumption::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('consumption_date', $date)
            ->sum('qty');

        // If no report yet, opening = last closing before date (if any)
        if (! $report) {
            $prev = MaterialStockReport::where('added_by', $userId)
                ->where('project_id', $projectId)
                ->where('vendor_id', $vendorId)
                ->where('item_id', $itemId)
                ->whereDate('report_date', '<', $date)
                ->orderByDesc('report_date')
                ->first();

            $openingBalance = (float) ($prev?->closing_balance ?? 0);
        }

        $cumulative = $openingBalance + $receivedQty;
        $closingBalance = $cumulative - $consumedQty;

        // Upsert report row (keep consumed/opening if previously set)
        $report = MaterialStockReport::updateOrCreate(
            [
                'project_id' => $projectId,
                'vendor_id' => $vendorId,
                'item_id' => $itemId,
                'report_date' => $date,
                'added_by' => $userId,
            ],
            [
                'opening_balance' => $openingBalance,
                'received_qty' => $receivedQty,
                'consumed_qty' => $consumedQty,
                'closing_balance' => $closingBalance,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => [
                'project_id' => $projectId,
                'vendor_id' => $vendorId,
                'item_id' => $itemId,
                'date' => $date,
                'opening_balance' => (float) $report->opening_balance,
                'received' => (float) $report->received_qty,
                'cumulative' => $cumulative,
                'balance' => (float) $report->closing_balance,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'item_id' => 'required|exists:items,id',
            'opening_balance' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user()->id;
        // $userId = 2;
        $projectId = (int) $request->project_id;
        $vendorId = (int) $request->vendor_id;
        $itemId = (int) $request->item_id;
        $date = Carbon::parse($request->date)->toDateString();

        $project = Project::where('id', $projectId)
            ->where('manager_id', $userId)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $report = MaterialStockReport::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('report_date', $date)
            ->first();

        if (! $report) {
            // Create by calling show-like computation of received and prev opening
            $receivedQty = (float) MaterialEntry::where('added_by', $userId)
                ->where('project_id', $projectId)
                ->where('vendor_id', $vendorId)
                ->where('item_id', $itemId)
                ->whereDate('entry_date', $date)
                ->sum('qty');

            $prev = MaterialStockReport::where('added_by', $userId)
                ->where('project_id', $projectId)
                ->where('vendor_id', $vendorId)
                ->where('item_id', $itemId)
                ->whereDate('report_date', '<', $date)
                ->orderByDesc('report_date')
                ->first();

            $report = MaterialStockReport::create([
                'project_id' => $projectId,
                'vendor_id' => $vendorId,
                'item_id' => $itemId,
                'report_date' => $date,
                'opening_balance' => (float) ($prev?->closing_balance ?? 0),
                'received_qty' => $receivedQty,
                'consumed_qty' => 0,
                'closing_balance' => ((float) ($prev?->closing_balance ?? 0)) + $receivedQty,
                'added_by' => $userId,
            ]);
        }

        if ($request->has('opening_balance')) {
            $report->opening_balance = (float) $request->opening_balance;
        }

        $report->received_qty = (float) MaterialEntry::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('entry_date', $date)
            ->sum('qty');

        $report->consumed_qty = (float) MaterialConsumption::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $vendorId)
            ->where('item_id', $itemId)
            ->whereDate('consumption_date', $date)
            ->sum('qty');

        $cumulative = (float) $report->opening_balance + (float) $report->received_qty;
        $report->closing_balance = $cumulative - (float) $report->consumed_qty;
        $report->save();

        return response()->json([
            'success' => true,
            'data' => [
                'project_id' => $projectId,
                'vendor_id' => $vendorId,
                'item_id' => $itemId,
                'date' => $date,
                'opening_balance' => (float) $report->opening_balance,
                'received' => (float) $report->received_qty,
                'cumulative' => $cumulative,
                'balance' => (float) $report->closing_balance,
            ],
        ]);
    }
}

