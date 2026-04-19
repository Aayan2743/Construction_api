<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabourReport;
use App\Models\Attendance;
use Illuminate\Support\Facades\Validator;

class LabourReportController extends Controller
{
   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'mason' => 'required|integer|min:0',
            'male_skilled' => 'required|integer|min:0',
            'female_unskilled' => 'required|integer|min:0',
            'others' => 'required|integer|min:0',
            'work_done' => 'required|string',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // 🔥 Calculate total (optional check)
        $total =
            ($request->mason ?? 0) +
            ($request->male_skilled ?? 0) +
            ($request->female_unskilled ?? 0) +
            ($request->others ?? 0);

        if ($total == 0) {
            return response()->json([
                'success' => false,
                'message' => 'At least one labour count required'
            ], 422);
        }

        // 🔥 Prevent duplicate
        $exists = LabourReport::where('vendor_id', $request->vendor_id)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Report already exists for this vendor & date'
            ], 422);
        }

        $report = LabourReport::create([
            'vendor_id' => $request->vendor_id,
            'mason' => $request->mason ?? 0,
            'male_skilled' => $request->male_skilled ?? 0,
            'female_unskilled' => $request->female_unskilled ?? 0,
            'others' => $request->others ?? 0,
            'work_done' => $request->work_done,
            'date' => $request->date,
            'added_by' => $request->user()->id
        ]);

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

   public function index(Request $request)
{
    $search  = $request->get('search');
    $date    = $request->get('date');
    $perPage = $request->get('per_page', 10);

    $query = LabourReport::with('vendor:id,name')
        ->where('added_by', $request->user()->id);

    // 🔍 Search (vendor name + work_done)
    if ($search) {
        $query->where(function ($q) use ($search) {

            // search in work_done
            $q->where('work_done', 'LIKE', "%$search%")

              // search in vendor name
              ->orWhereHas('vendor', function ($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%$search%");
              });
        });
    }

    // 📅 Filter by date
    if ($date) {
        $query->whereDate('date', $date);
    }

    // 📄 Pagination
    $reports = $query->latest()->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $reports->items(),
        'pagination' => [
            'current_page' => $reports->currentPage(),
            'last_page' => $reports->lastPage(),
            'per_page' => $reports->perPage(),
            'total' => $reports->total(),
        ]
    ]);
}

    public function update(Request $request, $id)
{
    $report = LabourReport::where('id', $id)
        ->where('added_by', $request->user()->id)
        ->first();

    if (!$report) {
        return response()->json([
            'success' => false,
            'message' => 'Report not found'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'vendor_id' => 'required|exists:vendors,id',
        'mason' => 'required|integer|min:0',
        'male_skilled' => 'required|integer|min:0',
        'female_unskilled' => 'required|integer|min:0',
        'others' => 'required|integer|min:0',
        'work_done' => 'required|string',
        'date' => 'required|date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    // 🔥 New total
    $newTotal =
        $request->mason +
        $request->male_skilled +
        $request->female_unskilled +
        $request->others;

    // 🔥 Existing attendance count
    // $attendanceCount = Attendance::where('vendor_id', $report->vendor_id)
    //     ->whereDate('date', $report->date)
    //     ->where('added_by', $request->user()->id)
    //     ->count();

    // // ❌ Prevent reducing below attendance
    // if ($newTotal < $attendanceCount) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => "Cannot reduce below attendance ($attendanceCount)"
    //     ], 422);
    // }

    // ❌ Prevent duplicate (if vendor/date changed)
    // $exists = LabourReport::where('vendor_id', $request->vendor_id)
    //     ->whereDate('date', $request->date)
    //     ->where('added_by', $request->user()->id)
    //     ->where('id', '!=', $id)
    //     ->exists();

    // if ($exists) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Report already exists for this vendor & date'
    //     ], 422);
    // }

    // ✅ Update
    $report->update([
        'vendor_id' => $request->vendor_id,
        'mason' => $request->mason,
        'male_skilled' => $request->male_skilled,
        'female_unskilled' => $request->female_unskilled,
        'others' => $request->others,
        'work_done' => $request->work_done,
        'date' => $request->date,
    ]);

    return response()->json([
        'success' => true,
        'data' => $report
    ]);
}
}
