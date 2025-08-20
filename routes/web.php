<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::view('/std','students.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // *** Roles and Permissions Routes ***

    // Permissions Routes
    Route::resource('permissions', PermissionController::class);

    // Roles Routes
    Route::resource('roles', RoleController::class);

    // Ticket Routes
    Route::resource('tickets', TicketController::class);

    // User Routes
    Route::resource('users', UserController::class);

    // Categories Routes
    Route::resource('categories', CategoryController::class);

    // Labels Routes
    Route::resource('labels', LabelController::class);

    // File pond Route
    Route::post('/filepond/upload', [TicketController::class, 'upload'])->name('filepond.upload');

    
});




require __DIR__ . '/auth.php';
