<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\Labour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\WebpService;
use Illuminate\Support\Str;

class LabourController extends Controller
{
     // ✅ List (only current user)
   public function index(Request $request)
{
    $search  = $request->get('search');
    $perPage = $request->get('per_page', 10);

    $query = Labour::with('vendor:id,name')
        ->where('added_by', $request->user()->id);

    // 🔍 Search
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'LIKE', "%$search%")
              ->orWhere('phone', 'LIKE', "%$search%");
        });
    }

    // 📄 Pagination
    $labours = $query->latest()->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $labours->items(),
        'pagination' => [
            'current_page' => $labours->currentPage(),
            'last_page' => $labours->lastPage(),
            'per_page' => $labours->perPage(),
            'total' => $labours->total(),
        ]
    ]);
}

    // ✅ Store
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:100',
            'gender' => 'required|in:male,female,other',
            'vendor_id' => 'required|exists:vendors,id',
            'phone' => 'required|digits:10|unique:labours,phone', // ✅ comma added
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
            ], 422);
        }

   

            $profilePicPath = null;

              if ($request->hasFile('profile_pic')) {

            if ($labour->getRawOriginal('profile_pic') && 
                file_exists(storage_path('app/public/' . $labour->getRawOriginal('profile_pic')))) {
                unlink(storage_path('app/public/' . $labour->getRawOriginal('profile_pic')));
            }

            $file = $request->file('profile_pic');
            $filename = Str::random(20) . '.webp';
            $destPath = storage_path('app/public/labours/profile_pics/' . $filename);

            $converted = WebpService::convert(
                $file->getRealPath(),
                $destPath,
                60,
                300,
                300
            );

            if ($converted) {
                $labour->profile_pic = 'labours/profile_pics/' . $filename;
            }
        }

            $labour = Labour::create([
                'full_name' => $request->full_name,
                'age' => $request->age,
                'gender' => $request->gender,
                'vendor_id' => $request->vendor_id,
                'phone' => $request->phone,
                'profile_pic' => $profilePicPath,
                'added_by' => $request->user()->id
            ]);

        return response()->json([
            'success' => true,
            'data' => $labour
        ]);
    }

    // ✅ Show (only own)
    public function show(Request $request, $id)
    {
        $labour = Labour::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (!$labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $labour
        ]);
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $labour = Labour::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (!$labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:100',
            'gender' => 'required|in:male,female,other',
            'vendor_id' => 'required|exists:vendors,id',
            'phone' => 'required|digits:10|unique:labours,phone,' . $id,
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
            ], 422);
        }

        // ✅ Update image if exists
        if ($request->hasFile('profile_pic')) {

            // 🔥 delete old image
            if ($labour->profile_pic && file_exists(storage_path('app/public/' . $labour->profile_pic))) {
                unlink(storage_path('app/public/' . $labour->profile_pic));
            }

            $file = $request->file('profile_pic');
            $filename = Str::random(20) . '.webp';
            $destPath = storage_path('app/public/labours/profile_pics/' . $filename);

            WebpService::convert($file->getRealPath(), $destPath, 60, 300, 300);

            $labour->profile_pic = 'labours/profile_pics/' . $filename;
        }

        $labour->update($request->only([
            'full_name', 'age', 'gender', 'vendor_id', 'phone'
        ]));

        return response()->json([
            'success' => true,
            'data' => $labour
        ]);
    }

    // ✅ Delete
    public function destroy(Request $request, $id)
    {
        $labour = Labour::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (!$labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found'
            ], 404);
        }

        $labour->delete();

        return response()->json([
            'success' => true,
            'message' => 'Labour deleted successfully'
        ]);
    }
}
