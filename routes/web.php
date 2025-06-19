<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReferenciaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('SuperAdmin')) {
        return view('dashboard_admin');
    } else {
        return view('dashboard_departamento');
    }
})->middleware('auth')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'SuperAdminOnly'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('referencias', ReferenciaController::class)->only(['index', 'create', 'store', 'edit', 'update']);
});
require __DIR__ . '/auth.php';
