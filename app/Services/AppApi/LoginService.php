<?php

namespace App\Services\AppApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginService
{
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid login details.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)
            ->where('is_admin', 1)
            ->where('active', 1)
            ->whereIn('role_id', [1, 3, 4])
            ->first();

        Log::info($user->id);

        if (! $user || ! Auth::guard()->validate([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Incorrect email or password.',
            ], 401);
        }

        return response()->json([
            'status' => 'ok',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'role_id' => $user->role_id,
            ]
        ]);
    }
}
