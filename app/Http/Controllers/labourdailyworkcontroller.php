<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\Models\LabourWork;
use App\Models\LabourWorkDeleteHistory;
use App\Models\LabourWorkEditHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Str;
class labourdailyworkcontroller extends Controller
{

public function addWork(Request $request)
{
    $validator = Validator::make($request->all(), [

        'labour_ids'   => 'required|array',

        'labour_ids.*' => 'exists:labours,id',

        'work_done'    => 'required|string',

        'measurement'  => 'nullable|string',

        'date'         => 'required|date'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    // ✅ Common Work Group ID
    $workGroupId = Str::uuid();

    foreach ($request->labour_ids as $labourId) {

        LabourWork::create([

            'work_group_id' => $workGroupId,

            'labour_id'     => $labourId,

            'date'          => $request->date,

            'work_done'     => $request->work_done,

            'measurement'   => $request->measurement,

            'added_by'      => $request->user()->id
        ]);
    }

    return response()->json([

        'success' => true,

        'work_group_id' => $workGroupId,

        'message' => 'Work added successfully'

    ]);
}

public function updateWork(Request $request, $work_group_id)
{
    $validator = Validator::make($request->all(), [

        'labour_ids'         => 'required|array',

        'labour_ids.*'       => 'exists:labours,id',

        'date'               => 'required|date',

        'work_done'          => 'required|string',

        'measurement'        => 'nullable|string',

        'reason_for_editing' => 'required|string',

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    // ✅ Get Existing Group Works
    $groupWorks = LabourWork::where('work_group_id', $work_group_id)

        ->where('added_by', $request->user()->id)

        ->get();

    if ($groupWorks->isEmpty()) {

        return response()->json([

            'success' => false,

            'message' => 'Work group not found'

        ], 404);
    }

    // ✅ Store Edit History
    foreach ($groupWorks as $item) {

        LabourWorkEditHistory::create([

            'labour_work_id' => $item->id,

            'reason'         => $request->reason_for_editing,

            'old_work_done'  => $item->work_done,

            'old_measurement'=> $item->measurement,

            'old_date'       => $item->date,

            'edited_by'      => $request->user()->id
        ]);
    }

    // ✅ Existing Labour IDs
    $existingLabourIds = $groupWorks
        ->pluck('labour_id')
        ->toArray();

    // ✅ Update Existing Group
    LabourWork::where('work_group_id', $work_group_id)

        ->where('added_by', $request->user()->id)

        ->update([

            'date'        => $request->date,

            'work_done'   => $request->work_done,

            'measurement' => $request->measurement

        ]);

    // ✅ Add New Labour IDs
    $newLabours = array_diff(
        $request->labour_ids,
        $existingLabourIds
    );

    foreach ($newLabours as $labourId) {

        LabourWork::create([

            'work_group_id' => $work_group_id,

            'labour_id'     => $labourId,

            'date'          => $request->date,

            'work_done'     => $request->work_done,

            'measurement'   => $request->measurement,

            'added_by'      => $request->user()->id
        ]);
    }

    // ✅ Remove Unchecked Labour IDs
    $removeLabours = array_diff(
        $existingLabourIds,
        $request->labour_ids
    );

    LabourWork::where('work_group_id', $work_group_id)

        ->whereIn('labour_id', $removeLabours)

        ->delete();

    // ✅ Updated Data
    $updatedWorks = LabourWork::with('labour:id,full_name')

        ->where('work_group_id', $work_group_id)

        ->get();

    return response()->json([

        'success' => true,

        'message' => 'Work updated successfully',

        'data' => [

            'work_group_id' => $work_group_id,

            'date' => $request->date,

            'work_done' => $request->work_done,

            'measurement' => $request->measurement,

            'labours' => $updatedWorks->map(function ($item) {

                return [

                    'labour_work_id' => $item->id,

                    'labour_id' => $item->labour_id,

                    'full_name' => optional($item->labour)->full_name

                ];

            })->values()

        ]

    ]);
}

public function workDetails($work_group_id, Request $request)
{
    $query = LabourWork::with([

            'labour:id,full_name,phone,vendor_id',

            'labour.vendor:id,name'

        ])

        ->where('work_group_id', $work_group_id)

        ->where('added_by', $request->user()->id);

    // ✅ Optional Date Filter
    if ($request->date) {

        $query->whereDate('date', $request->date);
    }

    $works = $query->get();

    if ($works->isEmpty()) {

        return response()->json([

            'success' => false,

            'message' => 'Work not found'

        ], 404);
    }

    $firstWork = $works->first();

    return response()->json([

        'success' => true,

        'data' => [

            'work_group_id' => $work_group_id,

            'date' => $firstWork->date,

            'work_done' => $firstWork->work_done,

            'measurement' => $firstWork->measurement,

            'vendor' => [

                'id' => optional($firstWork->labour->vendor)->id,

                'name' => optional($firstWork->labour->vendor)->name
            ],

            'labours' => $works->map(function ($item) {

                return [

                    'labour_work_id' => $item->id,

                    'labour_id' => $item->labour->id,

                    'full_name' => $item->labour->full_name,

                    'phone' => $item->labour->phone

                ];

            })->values()

        ]
    ]);
}

public function deleteWork(Request $request, $work_group_id)
{
    $validator = Validator::make($request->all(), [

        'remarks' => 'required|string'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    // ✅ Get Group Works
    $works = LabourWork::where('work_group_id', $work_group_id)

        ->where('added_by', $request->user()->id)

        ->get();

    if ($works->isEmpty()) {

        return response()->json([

            'success' => false,

            'message' => 'Work group not found'

        ], 404);
    }

    // ✅ Store Delete History
    foreach ($works as $work) {

        LabourWorkDeleteHistory::create([

            'labour_work_id' => $work->id,

            'remarks' => $request->remarks,

            'deleted_by' => $request->user()->id

        ]);
    }

    // ✅ Delete Full Group
    LabourWork::where('work_group_id', $work_group_id)

        ->where('added_by', $request->user()->id)

        ->delete();

    return response()->json([

        'success' => true,

        'message' => 'Work deleted successfully'

    ]);
}



// inintally listing work based on date and attendance, later we can add more filters like work type etc
public function workList(Request $request)
{
    $search     = $request->get('search');

    $attendance = $request->get('attendance');

    $date       = $request->get('date', Carbon::today()->toDateString());

    $query = Labour::with([

            'vendor:id,name',

            'attendance' => function ($q) use ($date) {

                $q->whereDate('date', $date);
            },

            'works' => function ($q) use ($date) {

                $q->whereDate('date', $date);

            }

        ])

        ->where('added_by', $request->user()->id);

    // 🔍 Search
    if ($search) {

        $query->where(function ($q) use ($search) {

            $q->where('full_name', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");

        });
    }

    // ✅ Attendance Filter
    if ($attendance == 'present') {

        $query->whereHas('attendance', function ($q) use ($date) {

            $q->whereDate('date', $date)
              ->where('is_present', 1);

        });

    } elseif ($attendance == 'absent') {

        $query->whereDoesntHave('attendance', function ($q) use ($date) {

            $q->whereDate('date', $date)
              ->where('is_present', 1);

        });
    }

    $labours = $query->latest()->get();

    // ✅ Vendor Wise Group
    $groupedData = $labours->groupBy('vendor_id')

        ->map(function ($vendorLabours) {

            $vendor = optional($vendorLabours->first()->vendor);

            // ✅ Combine all works
            $allWorks = $vendorLabours->flatMap(function ($labour) {

                return $labour->works->map(function ($work) use ($labour) {

                    return [

                        'work_id'     => $work->id,

                        'labour_id'   => $labour->id,

                        'labour_name' => $labour->full_name,

                        'date'        => $work->date,

                        'work_done'   => $work->work_done,

                        'measurement' => $work->measurement
                    ];
                });

            });

            // ✅ Group Same Works
            $groupedWorks = $allWorks

                ->groupBy(function ($item) {

                    return $item['date'] . '_' .
                           $item['work_done'] . '_' .
                           $item['measurement'];
                })

                ->map(function ($group) {

                    $first = collect($group)->first();

                    return [

                        'group_id' => $first['work_id'],

                        'date' => $first['date'],

                        'work_done' => $first['work_done'],

                        'measurement' => $first['measurement'],

                        'labour_names' => collect($group)
                            ->pluck('labour_name')
                            ->implode(', '),

                        'labours' => collect($group)->values()
                    ];

                })->values();

            return [

                'vendor_id'   => $vendor->id,

                'vendor_name' => $vendor->name,

                // ✅ Counts
                'male_count' => $vendorLabours
                    ->where('gender', 'M')
                    ->count(),

                'female_count' => $vendorLabours
                    ->where('gender', 'F')
                    ->count(),

                'total_count' => $vendorLabours->count(),

                // ✅ Labour Names Top
                'labour_names' => $vendorLabours
                    ->pluck('full_name')
                    ->implode(', '),

                // ✅ Work Cards
                'works' => $groupedWorks

            ];

        })

        ->values();

    return response()->json([

        'success' => true,

        'selected_date' => $date,

        'data' => $groupedData

    ]);
}
}
