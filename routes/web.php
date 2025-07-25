<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Show login form
Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/');
    }
    return view('auth.login');
})->name('login');

// Show register form
Route::get('/register', function () {
    if (auth()->check()) {
        return redirect('/');
    }  
    return view('auth.register');
})->name('register');

// Handle login submit
Route::post('/login', [AuthController::class, 'login']);

// Handle register submit
Route::post('/register', [AuthController::class, 'register']);

// Handle logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Tasks
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');
});
