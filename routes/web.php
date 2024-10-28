<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('enforcer');
    Route::get('/dashboard/workspace', [DashboardController::class, 'index'])->name('dashboard.workspace')->middleware('enforcer');

    Route::resource('organizations', OrganizationController::class)->middleware('enforcer');
    Route::resource('users', UserController::class)->middleware('enforcer');
    Route::resource('roles', RoleController::class)->middleware('enforcer');
    Route::resource('menus', MenuController::class)->middleware('enforcer');
});
