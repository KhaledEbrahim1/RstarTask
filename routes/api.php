<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PartitionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('User/Login', [AuthController::class, 'Login']);
Route::post('User/Register', [AuthController::class, 'Register']);



Route::middleware('auth:sanctum')->group(function () {

    // Users CRUD Endpoints
    Route::get('Users', [UserController::class, 'index'])->middleware('admin');
    Route::post('User/show/{id}', [UserController::class, 'show']);
    Route::post('User/update/{id}', [UserController::class, 'update']);
    Route::post('User/delete/{id}', [UserController::class, 'destroy'])->middleware('admin');
    Route::post('User/Logout', [AuthController::class, 'Logout']);



    // Categories CRUD Endpoints
    Route::apiResource('categories', CategoryController::class);

    // Partitions CRUD Endpoints
    Route::apiResource('partitions', PartitionController::class);

    // Items CRUD Endpoints
    Route::apiResource('items', ItemController::class);
});
