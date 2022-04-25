<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\Reports\DriverReportController;
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

Route::prefix('recipients')->group(function() {
    Route::post('/store', [RecipientController::class, 'store']);
    Route::post('/import', [RecipientController::class, 'import']);
    Route::patch('/{id}/update', [RecipientController::class, 'update']);
    Route::post('/destroy', [RecipientController::class, 'bulkDestroy']);
});

Route::prefix('drivers')->group(function() {
    Route::post('/store', [DriverController::class, 'store']);
    Route::post('/import', [DriverController::class, 'import']);
    Route::patch('/{id}/update', [DriverController::class, 'update']);
    Route::post('/destroy', [DriverController::class, 'bulkDestroy']);
});

Route::prefix('routes')->group(function() {
    Route::post('/store', [RouteController::class, 'store']);
    Route::post('/import', [RouteController::class, 'import']);
    Route::patch('/{id}/update', [RouteController::class, 'update']);
    Route::post('/destroy', [RouteController::class, 'bulkDestroy']);
});

Route::prefix('agencies')->group(function() {
    Route::post('/store', [AgencyController::class, 'store']);
    Route::post('/import', [AgencyController::class, 'import']);
    Route::patch('/{id}/update', [AgencyController::class, 'update']);
    Route::post('/destroy', [AgencyController::class, 'bulkDestroy']);
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
    Route::get('people', [PersonController::class, 'index'])->name('datatables.people');
    Route::get('recipients', [RecipientController::class, 'index'])->name('datatables.recipients');
    Route::get('drivers', [DriverController::class, 'index'])->name('datatables.drivers');
    Route::get('routes', [RouteController::class, 'index'])->name('datatables.routes');
    Route::get('agencies', [AgencyController::class, 'index'])->name('datatables.agencies');
});

Route::prefix('reports')->middleware(['auth', 'verified'])->group(function() {
    Route::get('driver', [DriverReportController::class, 'index']);
});

require __DIR__ . '/auth.php';
