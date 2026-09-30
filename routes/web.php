<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Admin\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all(); // Fetch all users from the database
        return view('admin.dashboard', compact('users')); // Pass them to the view
    })->name('dashboard');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
