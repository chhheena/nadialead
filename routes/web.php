<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/users', function () {
        return Inertia::render('User/Index');
    })->name('users');

    Route::get('user/{id?}', function ($id = '') {
        return Inertia::render('User/Add-Edit', ['id' => $id]);
    })->name('user.add-edit');

    Route::get('/leads', function () {
        return Inertia::render('Lead/Index');
    })->name('leads');

    Route::get('lead/import', function () {
        return Inertia::render('Lead/Import');
    })->name('lead.import.page');
});


require __DIR__ . '/auth.php';
