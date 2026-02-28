<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [AuthController::class, 'stats']);
    Route::apiResource('employees', EmployeeController::class)
        ->only(['index', 'store', 'show','update', 'destroy']);

    Route::post('attendance', [AttendanceController::class, 'store']);
    Route::get('attendance', [AttendanceController::class, 'index']);
    Route::get('attendance/{employee}', [AttendanceController::class, 'employeeAttendance']);
});
