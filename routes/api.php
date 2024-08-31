<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TimesheetController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], static function () {
    // Auth
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/verify/{id}', [AuthController::class, 'verify']);

    // User
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'find']);
    Route::post('users', [UserController::class, 'create']);
    Route::post('users/update', [UserController::class, 'update']);
    Route::post('users/delete', [UserController::class, 'delete']);

    // Project
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{user}', [ProjectController::class, 'find']);
    Route::post('projects', [ProjectController::class, 'create']);
    Route::post('projects/update', [ProjectController::class, 'update']);
    Route::post('projects/delete', [ProjectController::class, 'delete']);

    // UserProject
    Route::post('user-projects', [UserProjectController::class, 'create']);
    Route::post('user-projects/delete', [UserProjectController::class, 'delete']);

    // Timesheet
    Route::get('timesheets', [TimesheetController::class, 'index']);
    Route::get('timesheets/{timesheet}', [TimesheetController::class, 'find']);
    Route::post('timesheets', [TimesheetController::class, 'create']);
    Route::post('timesheets/update', [TimesheetController::class, 'update']);
    Route::post('timesheets/delete', [TimesheetController::class, 'delete']);

});
