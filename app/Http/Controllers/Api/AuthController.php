<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                return $this->successResponse(
                    [
                        'token' => $user->createToken($user->email)->plainTextToken
                    ],
                    'success',
                );
            }
            return $this->errorResponse('Unauthorized');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
