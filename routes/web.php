<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\CallRailService\CallRail;
use App\Http\Controllers\LeadColorController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;



Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
       // Permission::create(['name' => 'view_dashboard']);
        return Inertia::render('User/Index');
    })->name('users');

    Route::get('user/{id?}', function ($id = '') {
        return Inertia::render('User/Add-Edit', ['id' => $id]);
    })->name('user.add-edit');

    Route::get('/leads', function () {
        return Inertia::render('Lead/Index');
    })->name('leads');

    Route::get('/lead-colors/{id?}', [LeadColorController::class, 'index'])->name('lead_color');
    Route::post('/lead-colors/{id?}', [LeadColorController::class, 'store']);
    Route::delete('/lead-colors/{id?}', [LeadColorController::class, 'delete'])->name('lead_color.delete');

    Route::get('/assign-permissions', [RolePermissionController::class, 'index'])->name('permission.assign');

    Route::get('lead/import', function () {
        return Inertia::render('Lead/Import');
    })->name('lead.import.page');
});


require __DIR__ . '/auth.php';
