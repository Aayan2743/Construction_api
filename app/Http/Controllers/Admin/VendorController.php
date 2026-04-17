<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|array',
            'type.*' => 'required|in:labour,machinery,material',
            'name' => 'required|string|max:255',
            'contact' => 'required|digits:10|max:10',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $vendor = Vendor::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vendor created',
            'data' => $vendor
        ]);
    }

    // ✅ LIST (Pagination + Search)
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = Vendor::query();

        // 🔍 Search
        if ($search) {
            $query->where('name', 'LIKE', "%$search%")
                  ->orWhere('contact', 'LIKE', "%$search%");
        }

        $vendors = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $vendors->items(),
            'pagination' => [
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'per_page' => $vendors->perPage(),
                'total' => $vendors->total(),
            ]
        ]);
    }

    // ✅ SHOW
    public function show($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vendor
        ]);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|array',
            'type.*' => 'required|in:labour,machinery,material',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $vendor->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vendor updated',
            'data' => $vendor
        ]);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found'
            ], 404);
        }

        $vendor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendor deleted'
        ]);
    }
}
