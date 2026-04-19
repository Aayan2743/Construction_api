<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
{
    $validator = Validator::make($request->all(), [
        'labour_ids' => 'required|array',
        'labour_ids.*' => 'exists:labours,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()->first()
        ], 422);
    }

    $today = Carbon::today()->toDateString();

    foreach ($request->labour_ids as $labourId) {

        Attendance::updateOrCreate(
            [
                'labour_id' => $labourId,
                'date' => $today
            ],
            [
                'is_present' => 1,
                'added_by' => $request->user()->id
            ]
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Attendance marked successfully'
    ]);
}

public function todayAttendance(Request $request)
{
    $today = now()->toDateString();

    $data = Attendance::with('labour:id,full_name,profile_pic')
        ->where('date', $today)
        ->where('added_by', $request->user()->id)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}
}
