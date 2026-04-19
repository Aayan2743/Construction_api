<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EquipmentEntry;

class EquipmentEntryController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'equipment_id' => 'required|exists:items,id',
        'vendor_id' => 'required|exists:vendors,id',
        'start_time' => 'required',
        'end_time' => 'required',
        'date' => 'required|date',
        'work_done' => 'required|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    // 🔥 Calculate hours
    $start = strtotime($request->start_time);
    $end   = strtotime($request->end_time);

    $hours = ($end - $start) / 3600;

    $entry = EquipmentEntry::create([
        'equipment_id' => $request->equipment_id,
        'vendor_id' => $request->vendor_id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'total_hours' => $hours,
        'work_done' => $request->work_done,
        'date' => $request->date,
        'added_by' => $request->user()->id
    ]);

    return response()->json([
        'success' => true,
        'data' => $entry
    ]);
}


public function index(Request $request)
{
    $search = $request->get('search');
    $date   = $request->get('date');

    $query = EquipmentEntry::with([
        'equipment:id,name',
        'vendor:id,name'
    ])->where('added_by', $request->user()->id);

    if ($search) {
        $query->whereHas('equipment', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        });
    }

    if ($date) {
        $query->whereDate('date', $date);
    }

    $data = $query->latest()->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}


public function show($id)
{
    $entry = EquipmentEntry::with('equipment', 'vendor')->find($id);

    if (!$entry) {
        return response()->json([
            'success' => false,
            'message' => 'Entry not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $entry
    ]);
}


public function update(Request $request, $id)
{
    $entry = EquipmentEntry::find($id);

    if (!$entry) {
        return response()->json([
            'success' => false,
            'message' => 'Entry not found'
        ], 404);
    }

    $start = strtotime($request->start_time);
    $end   = strtotime($request->end_time);

    $hours = ($end - $start) / 3600;

    $entry->update([
        'equipment_id' => $request->equipment_id,
        'vendor_id' => $request->vendor_id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'total_hours' => $hours,
        'work_done' => $request->work_done,
        'date' => $request->date,
    ]);

    return response()->json([
        'success' => true,
        'data' => $entry
    ]);
}


public function destroy($id)
{
    $entry = EquipmentEntry::find($id);

    if (!$entry) {
        return response()->json([
            'success' => false,
            'message' => 'Entry not found'
        ], 404);
    }

    $entry->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted successfully'
    ]);
}
}
