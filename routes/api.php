<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;

Route::get('/say-hi', function () {
    return response()->json(['message' => 'Hello, World!']);
});

// Login
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    
    // divisions
    Route::get('/divisions', [DivisionController::class, 'index']);

    // employees
    Route::resource('employees', EmployeeApiController::class);
});