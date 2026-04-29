<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|digits:10',
            'role'     => 'required|in:admin,manager,supervisor,accountent',
            // 'project' => 'required|string',

            'password' => 'required|min:6',
            'status'   => 'required|in:0,1',
        ], [
            'role.required' => 'Role is required.',
            'role.in'       => 'The role must be one of: admin, manager, supervisor, accountent.',
        ]);

        // ❌ Validation fail
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // ✅ Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            // 'project' => $request->project,

            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data'    => $user,
        ]);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'phone'    => 'nullable|digits:10',
            'role'     => 'required|in:admin,manager,supervisor,accountent',
            'status'   => 'required|in:0,1',
            'password' => 'nullable|min:6',
        ], [
            'role.required' => 'Role is required.',
            'role.in'       => 'The role must be one of: admin, manager, supervisor, accountent.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $data = $request->only(['name', 'email', 'phone', 'role', 'status']);

        // Update password only when provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data'    => $user,
        ]);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    // ✅ UPDATE LOGGED-IN USER PROFILE (for your profile UI)
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|digits:10',
            // 'role'   => 'required|in:admin,manager,supervisor,accountent',
            // 'status' => 'sometimes|in:0,1',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $data = $request->only(['name', 'email', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $user,
        ]);
    }

    // ✅ GET LOGGED-IN USER PROFILE (for your profile UI)
    public function getProfile(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data'    => $user,
        ]);
    }

    // ✅ LIST + SEARCH + PAGINATION
    public function index(Request $request)
    {
        $search  = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = User::query();

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        // 🎯 Filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 📄 Pagination
        $users = $query->latest()->paginate($perPage);

        // ✅ Custom response
        return response()->json([
            'success'    => true,
            'data'       => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ],
        ]);
    }

    public function get_all_old(Request $request)
    {
        $search = $request->get('search');

        $query = User::query();

        // ❌ Exclude admin
        $query->where('role', '!=', 'admin');

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        // 🎯 Filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ❌ No pagination
        $users = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

    public function get_all(Request $request)
    {
        $query = User::query();

        // ❌ Exclude admin
        $query->where('role', '!=', 'admin');

        // 🎯 Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role)
                ->select('id', 'name', 'email'); // 👈 only needed fields
        }

        $users = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

}
