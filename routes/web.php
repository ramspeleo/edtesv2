<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRouteController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\OutboxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::middleware(['auth'])->group(function () {

    // Offices
    Route::get('/offices/ajax-data', [OfficeController::class, 'ajaxData'])
        ->name('offices.ajaxData');

    // Users
    Route::get('/users/ajax-data', [UserController::class, 'ajaxData'])
        ->name('users.ajaxData');

    // Roles
    Route::get('/roles/ajax-data', [RoleController::class, 'ajaxData'])
        ->name('roles.ajaxData');

    // Permissions
    Route::get('/permissions/ajax-data', [PermissionController::class, 'ajaxData'])
        ->name('permissions.ajaxData');

    Route::resource('offices', OfficeController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Outbox
|--------------------------------------------------------------------------
*/
Route::get('/outbox/ajax-data', [OutboxController::class, 'ajaxData'])
    ->name('outbox.ajaxData');

Route::get('/outbox', [OutboxController::class, 'index'])
    ->name('outbox.index');

/*
|--------------------------------------------------------------------------
| Inbox / Outbox
|--------------------------------------------------------------------------
*/

Route::get('/inbox', [InboxController::class, 'index'])
    ->name('inbox.index');

Route::get('/routes/incoming/ajax-data', [InboxController::class, 'incomingAjaxData'])
    ->name('routes.incomingAjaxData');

Route::post('/document-routes/{route}/receive', [InboxController::class, 'receive'])
    ->name('routes.receive');

;

/*
|--------------------------------------------------------------------------
| Documents
|--------------------------------------------------------------------------
*/

Route::pattern('document', '[0-9]+');
Route::get('/documents/{document}/cover-sheet', [DocumentController::class, 'coverSheet'])
    ->name('documents.coverSheet');
Route::get('/documents/{document}/scan-receive', [DocumentController::class, 'scanReceive'])
    ->name('documents.scanReceive');

Route::get('/documents/ajax-data', [DocumentController::class, 'documentAjaxData'])
    ->name('documents.documentAjaxData');

Route::get('/documents/{document}/route', [DocumentRouteController::class, 'create'])
    ->name('documents.route.create');

Route::post('/documents/{document}/route', [DocumentRouteController::class, 'store'])
    ->name('documents.route.store');

Route::post('/documents/{document}/sign', [DocumentController::class, 'sign'])
    ->name('documents.sign');

Route::resource('documents', DocumentController::class);

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {

        Route::get('/', [ReportController::class, 'index'])
            ->name('index');

        Route::get('/documents', [ReportController::class, 'documents'])
            ->name('documents');

        Route::get('/tracking', [ReportController::class, 'tracking'])
            ->name('tracking');

    });

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Offices
    Route::get('/offices/ajax-data', [OfficeController::class, 'ajaxData'])
        ->name('offices.ajaxData');

    // Users
    Route::get('/users/ajax-data', [UserController::class, 'ajaxData'])
        ->name('users.ajaxData');

    // Roles
    Route::get('/roles/ajax-data', [RoleController::class, 'ajaxData'])
        ->name('roles.ajaxData');

    // Permissions
    Route::get('/permissions/ajax-data', [PermissionController::class, 'ajaxData'])
        ->name('permissions.ajaxData');

    Route::resource('offices', OfficeController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::post(
    '/permissions/store-ajax',
    [PermissionController::class, 'storeAjax']
)->name('permissions.store.ajax');

require __DIR__.'/auth.php';