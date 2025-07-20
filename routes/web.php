<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// API Authentication pages
Route::get('/api/login', function () {
    return view('api.auth.login');
})->name('api.login');

Route::get('/api/register', function () {
    return view('api.auth.register');
})->name('api.register');

Route::get('/api/documentation', function () {
    return view('api.documentation');
})->name('api.documentation');

Route::get('/categories', function () {
    return view('categories');
});

Route::get('/my-articles', function () {
    return view('my-articles');
});

Route::get('/public-articles', function () {
    return view('public-articles');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
