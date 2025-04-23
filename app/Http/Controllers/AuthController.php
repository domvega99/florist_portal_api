<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([    
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        $user = User::with('role_name')->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'username' => ['Credentials Invalid']
                ]
            ];
        }

        $token = $user->createToken($user->username);

        return [
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role_name->name ?? null,
                'can_login' => $user->can_login,
                'locked' => $user->locked,
                'created_at' => $user->created_at,
            ],
            'token' => $token->plainTextToken
        ];
        
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logout successfully'
        ];
    }
}
