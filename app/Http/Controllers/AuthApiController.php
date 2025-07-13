<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminLoginResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('username', 'password');

            $validator = Validator::make($credentials, [
                'username' => 'required|string|exists:users,username',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422); // 422 Unprocessable Entity
            }

            $user = $this->authService->login($credentials);

            if ($user) {
                return new AdminLoginResource(   
                    'success',
                    'Login successful',
                    $user
                );
            }

            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

    }

    public function logout(Request $request)
    {
       try {
            $request->user()->tokens()->delete();
            
            return response()->json(['status' => 'success', 'message' => 'Logout successful'], 200);
       } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
       }
    }
}

