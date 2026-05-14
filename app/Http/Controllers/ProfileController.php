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
}
