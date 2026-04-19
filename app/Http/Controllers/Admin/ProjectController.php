<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
     // ✅ CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'manager_id' => 'required|exists:users,id',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $project = Project::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Project created',
            'data' => $project
        ]);
    }

    // ✅ LIST
    public function index(Request $request)
{
    $search = $request->get('search');
    $perPage = $request->get('per_page', 10);

    $query = Project::with('manager:id,name');

    // 🔍 Search (project name + location)
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%")
              ->orWhere('location', 'LIKE', "%$search%");
        });
    }

    // 🎯 Filter by manager
    if ($request->filled('manager_id')) {
        $query->where('manager_id', $request->manager_id);
    }

    // 🎯 Filter by status (boolean)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 📄 Pagination
    $projects = $query->latest()->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $projects->items(),
        'pagination' => [
            'current_page' => $projects->currentPage(),
            'last_page' => $projects->lastPage(),
            'per_page' => $projects->perPage(),
            'total' => $projects->total(),
        ]
    ]);
}

    // ✅ SHOW
    public function show($id)
    {
        $project = Project::with('manager:id,name')->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'manager_id' => 'required|exists:users,id',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $project->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Project updated',
            'data' => $project
        ]);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted'
        ]);
    }


        // Mobile Api

    public function myProjects()
{
    $userId = Auth::id(); // current logged in user

    $projects = Project::where('manager_id', $userId)->get();

    return response()->json([
        'success' => true,
        'data' => $projects
    ]);
}

public function myProject(Request $request, $id)
{
    $user = $request->user();

    $project = Project::with('manager:id,name')
        ->where('id', $id)
        ->where('manager_id', $user->id) // 🔥 important
        ->first();

    if (!$project) {
        return response()->json([
            'success' => false,
            'message' => 'Project not found or unauthorized'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $project
    ]);
}

}
