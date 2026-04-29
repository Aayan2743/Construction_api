<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\LabourHistory;
use App\Models\Labour;
use App\Models\LabourWage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

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
            'daily_wage' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
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
                $profilePicPath = 'labours/profile_pics/' . $filename;
            }
        }

        $effectiveFrom = Carbon::parse($request->effective_from)->toDateString();

        $labour = Labour::create([
            'full_name' => $request->full_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'vendor_id' => $request->vendor_id,
            'phone' => $request->phone,
            'daily_wage' => $request->daily_wage,
            'profile_pic' => $profilePicPath,
            'added_by' => $request->user()->id
        ]);

        // Create first wage record (effective-date based history)
        $labour->wages()->create([
            'daily_wage' => $request->daily_wage,
            'effective_from' => $effectiveFrom,
            'effective_to' => null,
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
            'remarks' => 'required|string|max:500',
            'daily_wage' => 'nullable|numeric|min:0',
            'effective_from' => 'required_with:daily_wage|date',
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

        $before = $labour->only(['full_name', 'age', 'gender', 'vendor_id', 'phone', 'daily_wage']);

        $labour->update($request->only([
            'full_name', 'age', 'gender', 'vendor_id', 'phone'
        ]));

        // ✅ Optional: update daily wage (effective-date based)
        if ($request->filled('daily_wage')) {
            $effectiveFrom = Carbon::parse($request->effective_from)->toDateString();

            $existingSameDate = LabourWage::where('labour_id', $labour->id)
                ->whereDate('effective_from', $effectiveFrom)
                ->first();

            if ($existingSameDate) {
                // If wage for same effective date exists, just update it
                $existingSameDate->update([
                    'daily_wage' => $request->daily_wage,
                ]);
            } else {
                // Close overlapping/current wage so ranges stay clean
                $overlapping = LabourWage::where('labour_id', $labour->id)
                    ->whereDate('effective_from', '<=', $effectiveFrom)
                    ->where(function ($q) use ($effectiveFrom) {
                        $q->whereNull('effective_to')
                            ->orWhereDate('effective_to', '>=', $effectiveFrom);
                    })
                    ->orderByDesc('effective_from')
                    ->first();

                if ($overlapping) {
                    $endDate = Carbon::parse($effectiveFrom)->subDay()->toDateString();
                    if ($endDate >= $overlapping->effective_from) {
                        $overlapping->update(['effective_to' => $endDate]);
                    }
                }

                $labour->wages()->create([
                    'daily_wage' => $request->daily_wage,
                    'effective_from' => $effectiveFrom,
                    'effective_to' => null,
                ]);
            }

            // Snapshot on labours table
            $labour->update(['daily_wage' => $request->daily_wage]);
        }

        $labour->refresh();
        $after = $labour->only(['full_name', 'age', 'gender', 'vendor_id', 'phone', 'daily_wage']);

        $changes = [];
        foreach ($after as $key => $value) {
            if (($before[$key] ?? null) !== $value) {
                $changes[$key] = [
                    'old' => $before[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        LabourHistory::create([
            'labour_id' => $labour->id,
            'user_id' => $request->user()->id,
            'type' => 'update',
            'remarks' => $request->remarks,
            'changes' => $changes ?: null,
        ]);

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

    // ✅ Add / change daily wage by effective date
    public function addWage(Request $request, $id)
    {
        $labour = Labour::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'daily_wage' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'remarks' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
            ], 422);
        }

        $effectiveFrom = Carbon::parse($request->effective_from)->toDateString();

        // Prevent duplicate effective_from for same labour
        if (LabourWage::where('labour_id', $labour->id)->whereDate('effective_from', $effectiveFrom)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Wage already exists for this effective date',
            ], 422);
        }

        // Close current wage if it overlaps the new effective date
        $overlapping = LabourWage::where('labour_id', $labour->id)
            ->whereDate('effective_from', '<=', $effectiveFrom)
            ->where(function ($q) use ($effectiveFrom) {
                $q->whereNull('effective_to')
                    ->orWhereDate('effective_to', '>=', $effectiveFrom);
            })
            ->orderByDesc('effective_from')
            ->first();

        if ($overlapping) {
            $endDate = Carbon::parse($effectiveFrom)->subDay()->toDateString();
            if ($endDate >= $overlapping->effective_from) {
                $overlapping->update(['effective_to' => $endDate]);
            }
        }

        $wage = $labour->wages()->create([
            'daily_wage' => $request->daily_wage,
            'effective_from' => $effectiveFrom,
            'effective_to' => null,
        ]);

        // Keep a "current" snapshot in labours table too
        $labour->update(['daily_wage' => $request->daily_wage]);

        LabourHistory::create([
            'labour_id' => $labour->id,
            'user_id' => $request->user()->id,
            'type' => 'wage',
            'remarks' => $request->remarks,
            'changes' => [
                'daily_wage' => [
                    'old' => $overlapping?->daily_wage,
                    'new' => $request->daily_wage,
                ],
                'effective_from' => $effectiveFrom,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Daily wage updated',
            'data' => $wage,
        ]);
    }

    // ✅ Labour update history (remarks + changes)
    public function history(Request $request, $id)
    {
        $labour = Labour::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found',
            ], 404);
        }

        $items = LabourHistory::with('user:id,name')
            ->where('labour_id', $labour->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    // ✅ Wage details + history (optionally "as of" a date)
    public function wageDetails(Request $request, $id)
    {
        $labour = Labour::with('wages')
            ->where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $labour) {
            return response()->json([
                'success' => false,
                'message' => 'Labour not found',
            ], 404);
        }

        $date = $request->get('date'); // optional YYYY-MM-DD
        $asOf = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();

        $current = LabourWage::where('labour_id', $labour->id)
            ->whereDate('effective_from', '<=', $asOf)
            ->where(function ($q) use ($asOf) {
                $q->whereNull('effective_to')
                    ->orWhereDate('effective_to', '>=', $asOf);
            })
            ->orderByDesc('effective_from')
            ->first();

        $history = LabourWage::where('labour_id', $labour->id)
            ->orderByDesc('effective_from')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'labour' => $labour,
                'as_of' => $asOf,
                'current_wage' => $current,
                'history' => $history,
            ],
        ]);
    }
}
