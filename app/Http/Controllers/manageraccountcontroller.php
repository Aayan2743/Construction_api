<?php

namespace App\Http\Controllers;

use App\Models\AccountAllocation;
use App\Models\ProjectExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class manageraccountcontroller extends Controller
{
    public function dashboard($project_id, Request $request)
{
    // ✅ Total Allocated Amount
    $totalAmount = AccountAllocation::where('project_id', $project_id)

        ->sum('amount');

    // ✅ Total Expenses
    $expenses = ProjectExpense::where('project_id', $project_id)

        ->sum('amount');

    // ✅ Balance
    $balance = $totalAmount - $expenses;

    return response()->json([

        'success' => true,

        'data' => [

            'project_id' => $project_id,

            'total_amount' => $totalAmount,

            'expenses' => $expenses,

            'balance' => $balance

        ]

    ]);
    }

        public function addExpense(Request $request)
        {
            $validator = Validator::make($request->all(), [

                'project_id' => 'required',

                'expense_type' => 'required|in:labour,material,machine',

                'party_id' => 'required|exists:vendors,id',

                'amount' => 'required|numeric|min:1',

                'date' => 'required|date',

                'remarks' => 'nullable|string'

            ]);

            if ($validator->fails()) {

                return response()->json([

                    'success' => false,

                    'message' => $validator->errors()->first()

                ], 422);
            }

            $expense = ProjectExpense::create([

                'project_id' => $request->project_id,

                'expense_type' => $request->expense_type,

                'party_id' => $request->party_id,

                'amount' => $request->amount,

                'remarks' => $request->remarks,

                'date' => $request->date,

                'added_by' => $request->user()->id

            ]);

            return response()->json([

                'success' => true,

                'message' => 'Expense added successfully',

                'data' => $expense

            ]);
        }

        public function expenseList($project_id, Request $request)
{
    $expenses = ProjectExpense::where('project_id', $project_id)

        ->where('added_by', $request->user()->id)

        ->latest()

        ->get();

    return response()->json([

        'success' => true,

        'data' => $expenses

    ]);
        }
      public function expenseDetails($id, Request $request)
{
    $expense = ProjectExpense::with([

            'party:id,name'

        ])

        ->where('id', $id)

        ->first();

    if (!$expense) {

        return response()->json([

            'success' => false,

            'message' => 'Expense not found'

        ], 404);
    }

    return response()->json([

        'success' => true,

        'data' => [

            'id' => $expense->id,

            'project_id' => $expense->project_id,

            'party' => [

                'id' => optional($expense->party)->id,

                'name' => optional($expense->party)->name

            ],

            'expense_type' => ucfirst($expense->expense_type),

            'amount' => $expense->amount,

            'remarks' => $expense->remarks,

            'date' => $expense->date,

            'created_at' => $expense->created_at->format('d/m/Y, h:i:s a')

        ]

    ]);
}
}
