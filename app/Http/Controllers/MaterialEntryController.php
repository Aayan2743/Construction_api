<?php

namespace App\Http\Controllers;

use App\Models\MaterialEntry;
use App\Models\MaterialEntryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialEntryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'supplier' => 'nullable|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $entry = MaterialEntry::create([
            'item_id' => $request->item_id,
            'qty' => $request->qty,
            'project_id' => $request->project_id,
            'supplier' => $request->supplier,
            'vendor_id' => $request->vendor_id,
            'added_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $entry,
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $projectId = $request->get('project_id');

        $query = MaterialEntry::with([
            'item:id,name',
            'project:id,name',
            'vendor:id,name',
        ])->where('added_by', $request->user()->id);

        if ($search) {
            $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            });
        }

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $data = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function show(Request $request, $id)
    {
        $entry = MaterialEntry::with(['item', 'project', 'vendor'])
            ->where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $entry) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $entry,
        ]);
    }

    public function update(Request $request, $id)
    {
        $entry = MaterialEntry::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $entry) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'supplier' => 'nullable|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'remarks' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $before = $entry->only(['item_id', 'qty', 'project_id', 'supplier', 'vendor_id']);

        $entry->update([
            'item_id' => $request->item_id,
            'qty' => $request->qty,
            'project_id' => $request->project_id,
            'supplier' => $request->supplier,
            'vendor_id' => $request->vendor_id,
        ]);

        $entry->refresh();
        $after = $entry->only(['item_id', 'qty', 'project_id', 'supplier', 'vendor_id']);

        $changes = [];
        foreach ($after as $key => $value) {
            if (($before[$key] ?? null) !== $value) {
                $changes[$key] = [
                    'old' => $before[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        MaterialEntryHistory::create([
            'material_entry_id' => $entry->id,
            'user_id' => $request->user()->id,
            'remarks' => $request->remarks,
            'changes' => $changes ?: null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $entry,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $entry = MaterialEntry::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $entry) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found',
            ], 404);
        }

        $entry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    public function history(Request $request, $id)
    {
        $entry = MaterialEntry::where('id', $id)
            ->where('added_by', $request->user()->id)
            ->first();

        if (! $entry) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found',
            ], 404);
        }

        $items = MaterialEntryHistory::with('user:id,name')
            ->where('material_entry_id', $entry->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
}

