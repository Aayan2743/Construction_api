<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;

class ItemController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'type' => 'required|in:machinery,material',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    $item = Item::create([
        'name' => $request->name,
        'type' => $request->type
    ]);

    return response()->json([
        'success' => true,
        'data' => $item
    ]);
}

public function index(Request $request)
{
    $search  = $request->get('search');
    $type    = $request->get('type'); // machinery/material
    $perPage = $request->get('per_page', 10);

    $query = Item::query();

    // 🔍 Search
    if ($search) {
        $query->where('name', 'LIKE', "%$search%");
    }

    // 🔥 Filter by type
    if ($type) {
        $query->where('type', $type);
    }

    $items = $query->latest()->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $items->items(),
        'pagination' => [
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'per_page' => $items->perPage(),
            'total' => $items->total(),
        ]
    ]);
}


public function get_machinery(Request $request)
{
    $search = $request->get('search');

    $query = Item::where('type', 'machinery'); // 🔥 only machinery

    // 🔍 Search
    if ($search) {
        $query->where('name', 'LIKE', "%$search%");
    }

    $items = $query->latest()->get(); // ❌ no pagination

    return response()->json([
        'success' => true,
        'data' => $items
    ]);
}



public function get_material(Request $request)
{
    $search = $request->get('search');

    $query = Item::where('type', 'material'); // 🔥 only machinery

    // 🔍 Search
    if ($search) {
        $query->where('name', 'LIKE', "%$search%");
    }

    $items = $query->latest()->get(); // ❌ no pagination

    return response()->json([
        'success' => true,
        'data' => $items
    ]);
}


public function update(Request $request, $id)
{
    $item = Item::find($id);

    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'type' => 'required|in:machinery,material',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    $item->update($request->only(['name', 'type']));

    return response()->json([
        'success' => true,
        'data' => $item
    ]);
}

public function destroy($id)
{
    $item = Item::find($id);

    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    $item->delete();

    return response()->json([
        'success' => true,
        'message' => 'Item deleted successfully'
    ]);
}
}

