<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\User;
use App\Models\Vendor;
use App\Models\LabourWork;
use App\Models\StockReport;
use App\Models\MaterialEntry;
use App\Models\EquipmentEntry;
use App\Models\AccountAllocation;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
{
$projectId = $request->get('project_id');


// ✅ Total Projects
$projects = Project::count();

// ✅ Accounts
$accounts = AccountAllocation::count();

// ✅ Users
$users = User::count();

// ✅ Vendors
$vendors = Vendor::count();

// ✅ Labour Rows
$labourQuery = LabourWork::query();

// ✅ Stock Rows
$stockQuery = StockReport::query();

// ✅ Material Entries
$materialQuery = MaterialEntry::query();

// ✅ Equipment Entries
$equipmentQuery = EquipmentEntry::query();

// ✅ Project Filter
if ($projectId) {

    $labourQuery->where(
        'project_id',
        $projectId
    );

    $stockQuery->where(
        'project_id',
        $projectId
    );

    $materialQuery->where(
        'project_id',
        $projectId
    );

    $equipmentQuery->where(
        'project_id',
        $projectId
    );
}

$labourRows = $labourQuery->count();

$stockRows = $stockQuery->count();

$materialEntries = $materialQuery->count();

$equipmentEntries = $equipmentQuery->count();

// ✅ Target Calculation
$target = 30;

$achievement = (
    $materialEntries +
    $equipmentEntries +
    $labourRows
);

// ✅ Achievement %
$achievementPercentage = 0;

if ($target > 0) {

    $achievementPercentage = round(
        ($achievement / $target) * 100,
        2
    );
}

return response()->json([

    'success' => true,

    'data' => [

        'cards' => [

            'projects' => $projects,

            'accounts' => $accounts,

            'users' => $users,

            'labour_rows' => $labourRows,

            'vendors' => $vendors,

            'stock_rows' => $stockRows

        ],

        'reporting_snapshot' => [

            'material_entries' => $materialEntries,

            'machinery_entries' => $equipmentEntries,

            'labour_entries' => $labourRows

        ],

        'target_vs_achievement' => [

            'target' => $target,

            'achieved' => $achievement,

            'percentage' => $achievementPercentage

        ]

    ]

]);


}

}
