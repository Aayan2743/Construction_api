<?php

namespace App\Http\Controllers;

use App\Models\AccountAllocation;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerDashboardController extends Controller
{
    public function summary(Request $request, $projectId)
    {
        // $project = Project::where('id', $projectId)
        //     ->where('manager_id', $request->user()->id)
        //     ->first();

        $id = $request->user()->id;
        // $id = 2;

            $project = Project::where('id', $projectId)
            ->where('manager_id', 2)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $totalReceived = (float) AccountAllocation::where('project_id', $project->id)
            ->where('user_id', $id)
            ->sum('amount');

        $totalExpenses = (float) Expense::where('project_id', $project->id)
            ->where('added_by', $id)
            ->sum('amount');

        $balance = $totalReceived - $totalExpenses;

        return response()->json([
            'success' => true,
            'data' => [
                'project_id' => $project->id,
                'total_received' => $totalReceived,
                'total_expenses' => $totalExpenses,
                'balance' => $balance,
            ],
        ]);
    }

    public function setTotalReceived(Request $request, $projectId)
    {
        $project = Project::where('id', $projectId)
            ->where('manager_id', $request->user()->id)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'total_received' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // We store received amount using account_allocations entries.
        // The UI sends the desired TOTAL; we add only the difference as a new allocation.
        $currentTotal = (float) AccountAllocation::where('project_id', $project->id)
            ->where('user_id', $request->user()->id)
            ->sum('amount');

        $desiredTotal = (float) $request->total_received;
        $delta = $desiredTotal - $currentTotal;

        if ($delta < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total amount cannot be reduced',
            ], 422);
        }

        if ($delta > 0) {
            AccountAllocation::create([
                'user_id' => $request->user()->id,
                'role' => $request->user()->role,
                'project_id' => $project->id,
                'amount' => $delta,
                'remarks' => $request->remarks ?: 'Funds added via dashboard',
            ]);
        }

        $totalExpenses = (float) Expense::where('project_id', $project->id)
            ->where('added_by', $request->user()->id)
            ->sum('amount');

        $totalReceived = (float) AccountAllocation::where('project_id', $project->id)
            ->where('user_id', $request->user()->id)
            ->sum('amount');
        $balance = $totalReceived - $totalExpenses;

        return response()->json([
            'success' => true,
            'data' => [
                'project_id' => $project->id,
                'total_received' => $totalReceived,
                'total_expenses' => $totalExpenses,
                'balance' => $balance,
            ],
        ]);
    }
}

