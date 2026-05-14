<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(Request $request)
{
    $user = User::find($request->user()->id);

    return response()->json([

        'success' => true,

        'data' => [

            'id' => $user->id,

            'name' => $user->name,

            'role' => $user->role,

            'profile_image' => $user->avatar
                ? asset($user->avatar)
                : null
        ]

    ]);
    }

    public function updateProfileImage(Request $request)
{
    $validator = Validator::make($request->all(), [

        'profile_image' => 'required|image|mimes:jpg,jpeg,png'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    $user = User::find($request->user()->id);

    if ($request->hasFile('profile_image')) {

        $file = $request->file('profile_image');

        $filename = time() . '.' .
            $file->getClientOriginalExtension();

        $path = 'uploads/profile/';

        $file->move(public_path($path), $filename);

        $user->avatar = $path . $filename;

        $user->save();
    }

    return response()->json([

        'success' => true,

        'message' => 'Profile image updated successfully',

        'profile_image' => asset($user->avatar)

    ]);
    }

    public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [

        'current_password' => 'required',

        'new_password' => 'required|min:6',

        'confirm_password' => 'required|same:new_password'

    ]);

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'message' => $validator->errors()->first()

        ], 422);
    }

    $user = User::find($request->user()->id);

    // ✅ Check Current Password
    if (!Hash::check(
        $request->current_password,
        $user->password
    )) {

        return response()->json([

            'success' => false,

            'message' => 'Current password is incorrect'

        ], 422);
    }

    // ✅ Update Password
    $user->password = bcrypt($request->new_password);

    $user->save();

    return response()->json([

        'success' => true,

        'message' => 'Password changed successfully'

    ]);
    }


    public function admin_profile(Request $request)
{
$user = User::find($request->user()->id);


return response()->json([

    'success' => true,

    'data' => [

        'id' => $user->id,

        'name' => $user->name,

        'email' => $user->email,

        'phone' => $user->phone,

        'role' => ucfirst($user->role),

        'status' => 'Active Account'

    ]

]);


    }


    public function updateProfile(Request $request)
{
$validator = Validator::make($request->all(), [

    'name' => 'required|string|max:255',

    'email' => 'required|email|unique:users,email,' . $request->user()->id,
    'phone' => 'required|unique:users,phone,' . $request->user()->id,

    'old_password' => 'nullable',

    'new_password' => 'nullable|min:6'

]);

if ($validator->fails()) {

    return response()->json([

        'success' => false,

        'message' => $validator->errors()->first()

    ], 422);
}

$user = User::find($request->user()->id);

// ✅ Check old password if changing password
if ($request->filled('new_password')) {

    if (!Hash::check(
        $request->old_password,
        $user->password
    )) {

        return response()->json([

            'success' => false,

            'message' => 'Old password incorrect'

        ], 422);
    }

    $user->password = bcrypt(
        $request->new_password
    );
}

// ✅ Update Profile
$user->update([

    'name' => $request->name,

    'email' => $request->email,

    'phone' => $request->phone,

]);

$user->save();

return response()->json([

    'success' => true,

    'message' => 'Profile updated successfully',

    'data' => $user

]);


    }


}
