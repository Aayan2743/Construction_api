<?php

namespace App\Http\Controllers;

use App\Models\MaterialConsumption;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialConsumptionController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'vendor_id' => 'required|exists:vendors,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user()->id;
        $projectId = (int) $request->project_id;

        $project = Project::where('id', $projectId)
            ->where('manager_id', $userId)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $date = Carbon::parse($request->date)->toDateString();

        $lines = MaterialConsumption::where('added_by', $userId)
            ->where('project_id', $projectId)
            ->where('vendor_id', $request->vendor_id)
            ->where('item_id', $request->item_id)
            ->whereDate('consumption_date', $date)
            ->latest()
            ->get(['id', 'work', 'qty', 'consumption_date', 'created_at']);

        $total = (float) $lines->sum('qty');

        return response()->json([
            'success' => true,
            'data' => [
                'lines' => $lines,
                'total_consumed' => $total,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'vendor_id' => 'required|exists:vendors,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
            'work' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user()->id;
        $projectId = (int) $request->project_id;

        $project = Project::where('id', $projectId)
            ->where('manager_id', $userId)
            ->first();

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or unauthorized',
            ], 404);
        }

        $line = MaterialConsumption::create([
            'project_id' => $projectId,
            'vendor_id' => $request->vendor_id,
            'item_id' => $request->item_id,
            'consumption_date' => Carbon::parse($request->date)->toDateString(),
            'work' => $request->work,
            'qty' => $request->qty,
            'added_by' => $userId,
        ]);

        return response()->json([
            'success' => true,
            'data' => $line,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $line = MaterialConsumption::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $line) {
            return response()->json([
                'success' => false,
                'message' => 'Consumption line not found',
            ], 404);
        }

        $line->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}

