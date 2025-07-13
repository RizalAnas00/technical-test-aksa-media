<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function login($credentials)
    { 
        $user = User::where('username', $credentials['username'])->first();
        // dd('Login return:', [
        //     'token' => $user?->createToken('auth_token')->plainTextToken,
        //     'admin' => $user
        // ]);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return [
                'token' => $user->createToken('auth_token')->plainTextToken,
                'admin' => $user->load('admin'),
            ];
        }

        return null;
    }
}
