<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public category list
Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);

// Public users list
Route::get('/users-list', function () {
    return \App\Models\User::select('id', 'name')->get();
});

// Authentication routes
Route::post('/auth/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('api.register');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Category management
    Route::post('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::put('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'destroy']);

    // Article management (authenticated user)
    Route::get('/articles/mine', [\App\Http\Controllers\Api\ArticleController::class, 'mine']);
    Route::post('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'store']);
    Route::get('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'show']);
    Route::put('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'destroy']);
});


// Public article listing
Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'publicIndex']);
Route::get('/articles/public/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'publicShow']);

// User info endpoint for public articles view
Route::get('/user-info/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if (!$user) return response()->json(['id' => $id, 'name' => 'Unknown'], 404);
    return response()->json(['id' => $user->id, 'name' => $user->name]);
});

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
