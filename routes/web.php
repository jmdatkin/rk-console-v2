<?php

use App\Http\Controllers\Assignments\ManageDriverController;
use App\Http\Controllers\Assignments\ManageRecipientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DriverExceptionController;
use App\Http\Controllers\Report\DashboardController;
use App\Http\Controllers\Report\DriversByRouteViewController;
use App\Http\Controllers\Report\RecipientsByRouteViewController;
use App\Http\Controllers\Report\DriverReportController;
use App\Http\Controllers\Report\MealReportController;
use App\Http\Controllers\Report\TexterReportController;
use App\Http\Controllers\Resources\AgencyController;
use App\Http\Controllers\Resources\DataTables\AgencyDataTableController;
use App\Http\Controllers\Resources\DataTables\DriverDataTableController;
use App\Http\Controllers\Resources\DataTables\PersonDataTableController;
use App\Http\Controllers\Resources\DataTables\RecipientDataTableController;
use App\Http\Controllers\Resources\DataTables\RouteDataTableController;
use App\Http\Controllers\Resources\DriverController;
use App\Http\Controllers\Resources\PersonController;
use App\Http\Controllers\Resources\RecipientController;
use App\Http\Controllers\Resources\RouteController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Client\Request;
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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');

    Route::prefix('recipient')->group(function () {
        Route::get('/', [RecipientController::class, 'all']);
        Route::get('/data', [RecipientController::class, 'data']);
        Route::get('/{id}', [RecipientController::class, 'show']);
        Route::get('/{id}/data', [RecipientController::class, 'get']);
        Route::post('/store', [RecipientController::class, 'store']);
        Route::post('/import', [RecipientController::class, 'import']);
        Route::patch('/{id}/update', [RecipientController::class, 'update']);
        Route::post('/destroy', [RecipientController::class, 'destroyMany']);
    });

    Route::prefix('driver')->group(function () {
        Route::get('/', [DriverController::class, 'all']);
        Route::get('/data', [DriverController::class, 'data']);
        Route::get('/{id}', [DriverController::class, 'show']);
        Route::get('/{id}/data', [DriverController::class, 'get']);
        Route::post('/store', [DriverController::class, 'store']);
        Route::post('/import', [DriverController::class, 'import']);
        Route::patch('/{id}/update', [DriverController::class, 'update']);
        Route::post('/destroy', [DriverController::class, 'destroyMany']);

        Route::post('/{driver_id}/assign/{route_id}', [DriverController::class, 'assign']);

        Route::get('/{id}/alternates', [DriverController::class, 'alternates']);
        Route::get('/{id}/alternates/attach/{route_id}', [DriverController::class, 'assignAlternate']);
        Route::get('/{id}/alternates/detach/{route_id}', [DriverController::class, 'deassignAlternate']);
    });

    Route::prefix('exceptions')->group(function () {
        Route::get('/', [DriverExceptionController::class, 'index']);
        Route::get('/{driver_id}/data', [DriverExceptionController::class, 'data']);
        Route::post('/store', [DriverExceptionController::class, 'store']);
    });

    Route::prefix('person')->group(function () {
        Route::get('/', [PersonController::class, 'all']);
        Route::get('/data', [PersonController::class, 'data']);
        Route::post('/store', [PersonController::class, 'store']);
        Route::post('/import', [PersonController::class, 'import']);
        Route::patch('/{id}/update', [PersonController::class, 'update']);
        Route::patch('/{id}/role', [PersonController::class, 'assignRole']);
        Route::post('/destroy', [PersonController::class, 'destroyMany']);
    });

    Route::prefix('route')->group(function () {
        Route::get('/', [RouteController::class, 'all']);
        Route::post('/store', [RouteController::class, 'store']);
        Route::post('/import', [RouteController::class, 'import']);
        Route::patch('/{id}/update', [RouteController::class, 'update']);
        Route::post('/destroy', [RouteController::class, 'destroyMany']);
        Route::get('/{id}/alternates', [RouteController::class, 'alternateDrivers']);
    });

    Route::prefix('agency')->group(function () {
        Route::post('/store', [AgencyController::class, 'store']);
        Route::post('/import', [AgencyController::class, 'import']);
        Route::patch('/{id}/update', [AgencyController::class, 'update']);
        Route::post('/destroy', [AgencyController::class, 'destroyMany']);
    });

    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'all']);
        Route::get('/{id}', [CommentController::class, 'show']);
        Route::get('/recipient/{recipient_id}', [CommentController::class, 'show_recipient']);
        Route::post('/store', [CommentController::class, 'store']);
    });

    Route::prefix('datatables')->group(function () {
        Route::get('/personnel', [PersonDataTableController::class, 'index'])->name('datatables.personnel');
        Route::get('/personnel/data', [PersonDataTableController::class, 'data'])->name('datatables.personnel.data');

        Route::get('/recipients', [RecipientDataTableController::class, 'index'])->name('datatables.recipients');
        Route::get('/recipients/data', [RecipientDataTableController::class, 'data'])->name('datatables.recipients.data');

        Route::get('/drivers', [DriverDataTableController::class, 'index'])->name('datatables.drivers');
        Route::get('/drivers/data', [DriverDataTableController::class, 'data'])->name('datatables.drivers.data');

        Route::get('/routes', [RouteDataTableController::class, 'index'])->name('datatables.routes');
        Route::get('/routes/data', [RouteDataTableController::class, 'data'])->name('datatables.routes.data');

        Route::get('/agencies', [AgencyDataTableController::class, 'index'])->name('datatables.agencies');
        Route::get('/agencies/data', [AgencyDataTableController::class, 'data'])->name('datatables.agencies.data');

        Route::get('/routedrivers', [DriversByRouteViewController::class, 'index']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('driver', [DriverReportController::class, 'index']);
        Route::get('driver/data', [DriverReportController::class, 'data']);
        Route::get('texter', [TexterReportController::class, 'index']);
        Route::get('texter/data', [TexterReportController::class, 'data']);
        Route::get('meals', [MealReportController::class, 'index']);
        Route::get('meals/data', [MealReportController::class, 'data']);
    });
});

Route::prefix('manage')->middleware(['auth', 'verified'])->group(function () {
    Route::get('recipient/{id}/assignments', [ManageRecipientController::class, 'getAssignments']);
    Route::post('recipient/{recipient_id}/assign/{route_id}/{weekday}', [ManageRecipientController::class, 'makeAssignment']);
    Route::get('recipient/{id}', [ManageRecipientController::class, 'index'])->name('manage.recipient');

    Route::get('driver/{id}/assignments', [ManageDriverController::class, 'getAssignments']);
    Route::post('driver/{driver_id}/assign/{route_id}/{weekday}', [ManageDriverController::class, 'makeAssignment']);
    Route::get('driver/{id}', [ManageDriverController::class, 'index'])->name('manage.driver');
});

Route::prefix('routedriver')->group(function () {
    Route::get('/', [DriversByRouteViewController::class, 'index']);
    Route::get('/data', [DriversByRouteViewController::class, 'data']);
});

Route::prefix('routerecipients')->group(function () {
    Route::get('/', [RecipientsByRouteViewController::class, 'index']);
    Route::get('/data', [RecipientsByRouteViewController::class, 'data']);
});

Route::get('/calendar/events', function (Request $request) {
});


require __DIR__ . '/auth.php';
