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
            'role'     => 'required|in:manager,supervisor,accountent',
            // 'project' => 'required|string',

            'password' => 'required|min:6',
            'status'   => 'required|in:0,1',
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
