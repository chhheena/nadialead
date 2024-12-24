<?php

use App\Http\Controllers\LeadColorController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Enums\{LeadTag, LeadRating, NoteStrikeFirst, LeadStatus};


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        return Inertia::render('User/Index');
    })->name('users');

    Route::get('user/{id?}', function ($id = '') {
        return Inertia::render('User/Add-Edit', ['id' => $id]);
    })->name('user.add-edit');

    Route::get('/leads', function () {
        return Inertia::render('Lead/Index', [
            'leadTags' => LeadTag::cases(),
            'leadRatings' => LeadRating::cases(),
            'noteStrikeFirst' => NoteStrikeFirst::cases(),
            'statuses' => LeadStatus::cases()
        ]);
    })->name('leads');

    Route::get('/lead/update/{id}', function ($id) {
        return Inertia::render('Lead/Update', [
            'id' => $id,
            'leadTags' => LeadTag::cases(),
            'leadRatings' => LeadRating::cases(),
            'noteStrikeFirst' => NoteStrikeFirst::cases(),
            'statuses' => LeadStatus::cases()
        ]);
    })->name('lead.update');

    Route::get('/lead-colors', [LeadColorController::class, 'color_list_page'])->name('lead_color');

    Route::post('/lead-colors/{id?}', [LeadColorController::class, 'store']);
    Route::delete('/lead-colors/{id?}', [LeadColorController::class, 'delete'])->name('lead_color.delete');
    Route::get('/assign-permissions', [RolePermissionController::class, 'index'])->name('permission.assign');

    Route::get('lead/import', function () {
        return Inertia::render('Lead/Import');
    })->name('lead.import.page');
});


require __DIR__ . '/auth.php';
