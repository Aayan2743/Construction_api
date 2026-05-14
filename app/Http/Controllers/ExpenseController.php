<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Labour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'type' => 'required|in:labour,material,machinery',
            // If type=labour, vendor_id will be auto-derived from labour_id.
            'vendor_id' => 'nullable|exists:vendors,id|required_unless:type,labour',
            'labour_id' => 'nullable|exists:labours,id|required_if:type,labour',
            // If type=material, UI must send selected material item_id
            'item_id' => 'nullable|exists:items,id|required_if:type,material',
            'sector' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'expense_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $vendorId = $request->vendor_id;
        $labourId = null;
        $itemId = null;

        if ($request->type === 'labour') {
            $labour = Labour::where('id', $request->labour_id)
                ->where('added_by', $request->user()->id)
                ->first();

            if (! $labour) {
                return response()->json([
                    'success' => false,
                    'message' => 'Labour not found',
                ], 404);
            }

            $vendorId = $labour->vendor_id;
            $labourId = $labour->id;
        }

        if ($request->type === 'material') {
            $itemId = $request->item_id;
        }

        $expense = Expense::create([
            'project_id' => $request->project_id,
            'vendor_id' => $vendorId,
            'labour_id' => $labourId,
            'item_id' => $itemId,
            'type' => $request->type,
            'sector' => $request->sector,
            'amount' => $request->amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
            'added_by' => $request->user()->id,
        ]);

        $expense->load(['vendor:id,name', 'project:id,name', 'labour:id,full_name', 'item:id,name']);

        return response()->json([
            'success' => true,
            'data' => $expense,
        ]);
    }

    public function index(Request $request)
    {
        $projectId = $request->get('project_id');
        $type = $request->get('type');
        $vendorId = $request->get('vendor_id');
        $labourId = $request->get('labour_id');
        $itemId = $request->get('item_id');
        $from = $request->get('from');
        $to = $request->get('to');

        $query = Expense::with([
            'project:id,name',
            'vendor:id,name',
            'labour:id,full_name',
            'item:id,name',
        ])->where('added_by', $request->user()->id);

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }

        if ($labourId) {
            $query->where('labour_id', $labourId);
        }

        if ($itemId) {
            $query->where('item_id', $itemId);
        }

        if ($from && $to) {
            $query->whereBetween('expense_date', [$from, $to]);
        }

        $data = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function show(Request $request, $id)
    {

        // $id = $request->user()->id;
        $id = 2;
        $expense = Expense::with([
            'project:id,name',
            'vendor:id,name',
            'labour:id,full_name',
            'item:id,name',
        ])
            ->where('id', $id)
            ->where('added_by', $id)
            ->first();

        if (! $expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $expense,
        ]);
    }
}

