<?php

use App\Http\Controllers\DataTableControllers\RecipientDataTableController;
use App\Http\Controllers\RecipientController;
use App\Models\Recipient;
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

// Route::resource('recipients', RecipientController::class);
Route::prefix('recipients')->group(function() {
    Route::post('/store', [RecipientController::class, 'store']);
    Route::post('/import', [RecipientController::class, 'import']);
    Route::patch('/{id}/update', [RecipientController::class, 'update']);
    Route::post('/destroy', [RecipientController::class, 'bulkDestroy']);
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/', [RecipientController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('datatables')->middleware(['auth', 'verified'])->group(function () {
    Route::get('recipients', [RecipientController::class, 'index'])->name('datatables.recipients');
});

Route::get('/datatables/recipients/data', [RecipientDataTableController::class, 'data']);

require __DIR__ . '/auth.php';
