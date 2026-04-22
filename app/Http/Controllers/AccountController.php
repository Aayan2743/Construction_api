<?php
namespace App\Http\Controllers;

use App\Models\AccountAllocation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function storeAllocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            'role'       => 'required|in:manager,supervisor,accountent',
            'project_id' => 'required|exists:projects,id',
            'amount'     => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // ❌ Prevent duplicate
        $exists = AccountAllocation::where('user_id', $request->user_id)
            ->where('project_id', $request->project_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Already allocated',
            ], 400);
        }

        // ✅ Save
        $allocation = AccountAllocation::create([
            'user_id'    => $request->user_id,
            'role'       => $request->role,
            'project_id' => $request->project_id,
            'amount'     => $request->amount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Allocation saved successfully',
            'data'    => $allocation,
        ]);
    }
}