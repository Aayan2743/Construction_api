<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetOtpJob;
use App\Models\User;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

use Laravel\Socialite\Facades\Socialite;

/**
 * @group Admin Dashboard
 * @authenticated
 */
class AuthController extends Controller
{


    public function register(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'phone'    => 'required|digits:10|unique:users,phone',
                'password' => 'required|min:6',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()->first(),
                ], 422);
            }

            $user = User::create([
                'name'            => $request->name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'password'        => Hash::make($request->password),
                'role'            => 'admin',

            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'token'   => $token,
                'user'    => $user,
            ]);
        }
    // User Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string', // email OR phone
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->first(),
            ], 422);
        }

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        // Fetch user manually
        $user = User::where($loginField, $request->login)->first();

        // User not found
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

                                     // ❌ Block non-admins explicitly
        if ($user->role != 'admin') { // 2 = admin
            return response()->json([
                'success' => false,
                'message' => 'Access denied. User only.',
            ], 403);
        }

        // Password check
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 422);
        }

        // Generate JWT token manually
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success'    => true,
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => $user,
        ]);
    }

     public function managerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string', // email OR phone
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->first(),
            ], 422);
        }

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        // Fetch user manually
        $user = User::where($loginField, $request->login)->first();

        // User not found
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // ❌ Block non-admins explicitly
        if ($user->role !== 'manager') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Manager only.',
            ], 403);
        }

        // Password check
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 422);
        }

        // Generate JWT token manually
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success'    => true,
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => $user,
        ]);
    }





    public function logout()
    {
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

}
