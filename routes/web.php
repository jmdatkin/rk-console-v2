<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Assignments\ManageDriverController;
use App\Http\Controllers\Assignments\ManageRecipientController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\Reports\DriverReportController;
use App\Http\Controllers\Reports\TexterReportController;
use App\Http\Controllers\RouteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('recipient')->group(function() {
    Route::get('/', [RecipientController::class, 'all']);
    Route::get('/data', [RecipientController::class, 'data']);
    Route::get('/{id}', [RecipientController::class, 'show']);
    Route::post('/store', [RecipientController::class, 'store']);
    Route::post('/import', [RecipientController::class, 'import']);
    Route::patch('/{id}/update', [RecipientController::class, 'update']);
    Route::post('/destroy', [RecipientController::class, 'destroyMany']);
});

Route::prefix('driver')->group(function() {
    Route::get('/', [DriverController::class, 'all']);
    Route::get('/data', [DriverController::class, 'data']);
    Route::get('/{id}', [DriverController::class, 'show']);
    Route::post('/store', [DriverController::class, 'store']);
    Route::post('/import', [DriverController::class, 'import']);
    Route::patch('/{id}/update', [DriverController::class, 'update']);
    Route::post('/destroy', [DriverController::class, 'destroyMany']);
});

Route::prefix('person')->group(function() {
    Route::get('/', [PersonController::class, 'all']);
    Route::get('/data', [PersonController::class, 'data']);
    Route::post('/store', [PersonController::class, 'store']);
    Route::post('/import', [PersonController::class, 'import']);
    Route::patch('/{id}/update', [PersonController::class, 'update']);
    Route::post('/destroy', [PersonController::class, 'destroyMany']);
});

Route::prefix('route')->group(function() {
    Route::get('/', [RouteController::class, 'all']);
    Route::post('/store', [RouteController::class, 'store']);
    Route::post('/import', [RouteController::class, 'import']);
    Route::patch('/{id}/update', [RouteController::class, 'update']);
    Route::post('/destroy', [RouteController::class, 'destroyMany']);
});

Route::prefix('agency')->group(function() {
    Route::post('/store', [AgencyController::class, 'store']);
    Route::post('/import', [AgencyController::class, 'import']);
    Route::patch('/{id}/update', [AgencyController::class, 'update']);
    Route::post('/destroy', [AgencyController::class, 'destroyMany']);
});

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

Route::prefix('datatables')->middleware(['auth', 'verified'])->group(function () {
    Route::get('personnel', [PersonController::class, 'index'])->name('datatables.personnel');
    Route::get('recipients', [RecipientController::class, 'index'])->name('datatables.recipients');
    Route::get('drivers', [DriverController::class, 'index'])->name('datatables.drivers');
    Route::get('routes', [RouteController::class, 'index'])->name('datatables.routes');
    Route::get('agencies', [AgencyController::class, 'index'])->name('datatables.agencies');
});

Route::prefix('reports')->middleware(['auth', 'verified'])->group(function() {
    Route::get('driver', [DriverReportController::class, 'index']);
    Route::get('texter', [TexterReportController::class, 'index']);
});

Route::prefix('manage')->middleware(['auth', 'verified'])->group(function() {
    Route::get('recipient/{id}/assignments', [ManageRecipientController::class, 'getAssignments']);
    Route::post('recipient/{recipient_id}/assign/{route_id}/{weekday}', [ManageRecipientController::class, 'makeAssignment']);
    Route::get('recipient/{id}', [ManageRecipientController::class, 'index'])->name('manage.recipient');

    Route::get('driver/{id}/assignments', [ManageDriverController::class, 'getAssignments']);
    Route::post('driver/{driver_id}/assign/{route_id}/{weekday}', [ManageDriverController::class, 'makeAssignment']);
    Route::get('driver/{id}', [ManageDriverController::class, 'index'])->name('manage.driver');
});

Route::get('calendar', function() {
    return Inertia::render('CalendarPage');
});

require __DIR__ . '/auth.php';
