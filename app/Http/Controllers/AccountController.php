<?php
namespace App\Http\Controllers;

use App\Models\AccountAllocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function storeAllocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            // 'role'       => 'required|in:manager,supervisor,accountent',
            'project_id' => 'required|exists:projects,id',
            'amount'     => 'required|numeric|min:1',
            'remarks'    => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // ❌ Prevent duplicate
        // $exists = AccountAllocation::where('user_id', $request->user_id)
        //     ->where('project_id', $request->project_id)
        //     ->exists();

        // if ($exists) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Already allocated',
        //     ], 400);
        // }

        $role = User::find($request->user_id)->role;

        // ✅ Save
        $allocation = AccountAllocation::create([
            'user_id'    => $request->user_id,
            'role'       => $role,
            'project_id' => $request->project_id,
            'amount'     => $request->amount,
            'remarks'    => $request->remarks,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Allocation saved successfully',
            'data'    => $allocation,
        ]);
    }

    public function index(Request $request)
    {
        $query = AccountAllocation::with(['user', 'project']);

        // 🔍 Search (name/email)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // 📅 Date filter
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from,
                $request->to,
            ]);
        }

        // 📄 Pagination
        $data = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'success'    => true,
            'message'    => 'Account allocations fetched successfully',
            'data'       => collect($data->items())->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'name'        => $item->user->name ?? '',
                    'designation' => $item->user->role ?? '',
                    'email'       => $item->user->email ?? '',
                    'project'     => $item->project->name ?? '',
                    'amount'      => $item->amount,
                    'created_at'  => $item->created_at->format('Y-m-d'),
                ];
            }),

            // 🔥 Pagination Meta (IMPORTANT for frontend)
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
            ],
        ]);
    }

    public function destroy($id)
    {
        $allocation = AccountAllocation::find($id);

        if (! $allocation) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        $allocation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $allocation = AccountAllocation::find($id);

        if (! $allocation) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'amount'     => 'required|numeric|min:1',
            'remarks'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // ✅ Update
        $allocation->update([
            'user_id'    => $request->user_id,
            'project_id' => $request->project_id,
            'amount'     => $request->amount,
            'remarks'    => $request->remarks,
        ]);

        // 🔁 Reload relations
        $allocation->load(['user', 'project']);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data'    => [
                'id'          => $allocation->id,
                'name'        => $allocation->user->name ?? '',
                'designation' => $allocation->user->role ?? '',
                'email'       => $allocation->user->email ?? '',
                'project'     => $allocation->project->name ?? '',
                'amount'      => $allocation->amount,
                'remarks'     => $allocation->remarks,
                'created_at'  => $allocation->created_at->format('Y-m-d'),
            ],
        ]);
    }

}
