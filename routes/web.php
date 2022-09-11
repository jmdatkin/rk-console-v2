<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuditViewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DriverSubController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Report\DashboardController;
use App\Http\Controllers\Report\DriversByRouteViewController;
use App\Http\Controllers\Report\RecipientsByRouteViewController;
use App\Http\Controllers\Report\DriverReportController;
use App\Http\Controllers\Report\MealReportController;
use App\Http\Controllers\Report\OutreachReportController;
use App\Http\Controllers\Report\TexterReportController;
use App\Http\Controllers\Report\TotalsReportController;
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
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserProfileController;
use App\Mail\DriverReportEmail;
use App\Mail\DriverReportEmailMdTest;
use App\Models\Driver;
use App\Models\PendingJob;
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

Route::prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings');
    Route::get('/data', [SettingsController::class, 'get'])->name('settings.data');
    Route::post('/save', [SettingsController::class, 'save'])->name('settings.save');
    Route::get('/user', [SettingsController::class, 'index_user'])->name('settings.user');
    Route::get('/user/data', [SettingsController::class, 'get_user'])->name('settings.user.data');
    Route::post('/user/save', [SettingsController::class, 'save_user'])->name('settings.user.save');
});

Route::get('test', fn () => Inertia::render('Test'));

// Must be signed in
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [HomeController::class, 'handle']);
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');


    Route::get('usersettings', function () {
        return Inertia::render('UserSettings');
    });

    Route::post('/recipient/reorder', [AssignmentController::class, 'reorder_recipient'])->name('assignment.recipient.reorder');

    // Signed-in user must have admin role
    Route::middleware(['admin'])->group(function () {

        Route::get('committest', function () {
            PendingJob::uncommitted()->get()->each(function ($job) {
                $job->commit();
            });
        });

        Route::get('adminsettings', function () {
            return Inertia::render('AdminSettings');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        Route::prefix('driversbyroute')->group(function () {
            Route::get('/{date}', [DriversByRouteViewController::class, 'report'])->name('driversbyroute.report');
            Route::get('/', [DriversByRouteViewController::class, 'index'])->name('driversbyroute');
            Route::get('/data', [DriversByRouteViewController::class, 'data'])->name('driversbyroute.data');
        });

        Route::prefix('recipientsbyroute')->group(function () {
            Route::get('/', [RecipientsByRouteViewController::class, 'index'])->name('recipientsbyroute');
            Route::get('/data', [RecipientsByRouteViewController::class, 'data'])->name('recipientsbyroute.data');
        });

        Route::get('audits', [AuditViewController::class, 'index'])->name('audits');

        Route::prefix('jobs')->group(function() {
            Route::get('/', [JobController::class, 'index'])->name('jobs');
            Route::post('/{id}/commit', [JobController::class, 'commit'])->name('jobs.commit');
            Route::post('/{id}/destroy', [JobController::class, 'destroy'])->name('jobs.destroy');
        });

        Route::prefix('recipient')->group(function () {
            Route::get('/', [RecipientController::class, 'all'])->name('recipient.all');
            Route::get('/data', [RecipientController::class, 'data']);
            Route::get('/{id}', [RecipientController::class, 'show'])->name('recipient.show');
            Route::get('/{id}/data', [RecipientController::class, 'get']);
            Route::post('/store', [RecipientController::class, 'store']);
            Route::post('/import', [RecipientController::class, 'import']);
            Route::patch('/{id}/update', [RecipientController::class, 'update']);
            Route::post('/destroy', [RecipientController::class, 'destroyMany']);
            Route::get('/{id}/routes', [RecipientController::class, 'routes'])->name('recipient.routes');
            Route::post('/{id}/pause', [RecipientController::class, 'pause'])->name('recipient.pause');
            Route::post('/{id}/unpause', [RecipientController::class, 'unpause'])->name('recipient.unpause');
        });

        Route::prefix('driver')->group(function () {
            Route::get('/', [DriverController::class, 'all'])->name('driver.all');
            Route::get('/data', [DriverController::class, 'data']);
            Route::get('/{id}', [DriverController::class, 'show'])->name('driver.show');
            Route::get('/{id}/data', [DriverController::class, 'get']);
            Route::post('/store', [DriverController::class, 'store']);
            Route::post('/import', [DriverController::class, 'import']);
            Route::patch('/{id}/update', [DriverController::class, 'update']);
            Route::post('/destroy', [DriverController::class, 'destroyMany']);
            Route::get('/{id}/routes', [DriverController::class, 'routes'])->name('driver.routes');

            Route::get('/{id}/alternates', [DriverController::class, 'alternates']);
            Route::get('/{id}/alternates/attach/{route_id}', [DriverController::class, 'assignAlternate']);
            Route::get('/{id}/alternates/detach/{route_id}', [DriverController::class, 'deassignAlternate']);
        });

        Route::prefix('assignments')->group(function() {
            Route::post('/recipient/assign', [AssignmentController::class, 'assign_recipient'])->name('assignment.recipient.assign');
            Route::post('/recipient/deassign', [AssignmentController::class, 'deassign_recipient'])->name('assignment.recipient.deassign');

            Route::post('/driver/assign', [AssignmentController::class, 'assign_driver'])->name('assignment.driver.assign');
            Route::post('/driver/deassign', [AssignmentController::class, 'deassign_driver'])->name('assignment.driver.deassign');
        });

        Route::prefix('substitute')->group(function() {
            Route::post('/store', [DriverSubController::class, 'store'])->name('substitute.store');
        });

        Route::prefix('personnel')->group(function () {
            Route::get('/', [PersonController::class, 'all'])->name('person.all');
            Route::get('/{id}', [PersonController::class, 'show']);
            Route::get('/data', [PersonController::class, 'data']);
            Route::post('/store', [PersonController::class, 'store']);
            Route::post('/import', [PersonController::class, 'import']);
            Route::patch('/{id}/update', [PersonController::class, 'update']);
            Route::patch('/{id}/role', [PersonController::class, 'assignRole']);
            Route::post('/destroy', [PersonController::class, 'destroyMany']);
        });

        Route::prefix('route')->group(function () {
            Route::get('/', [RouteController::class, 'all']);
            Route::get('/{id}', [RouteController::class, 'show']);
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

            Route::get('meals/{date}', [MealReportController::class, 'report'])->name('report.meals.report');
            Route::get('meals', [MealReportController::class, 'index'])->name('report.meals');
            Route::get('meals/data', [MealReportController::class, 'data'])->name('report.meals.data');

            Route::get('outreach/{date}', [OutreachReportController::class, 'report'])->name('report.outreach.report');
            Route::get('outreach', [OutreachReportController::class, 'index'])->name('report.outreach');
            Route::get('outreach/data', [OutreachReportController::class, 'data'])->name('report.outreach.data');

            Route::get('totals/{date}', [TotalsReportController::class, 'report'])->name('report.totals.report');
            Route::get('totals', [TotalsReportController::class, 'index'])->name('report.totals');
            Route::get('totals/data', [TotalsReportController::class, 'data'])->name('report.totals.data');
        });
    });
});

Route::get('/drivermailtest/{id}', function ($id) {
    return new DriverReportEmailMdTest(Driver::find($id));
});

Route::get('/calendar/events', function (Request $request) {
});


require __DIR__ . '/auth.php';
