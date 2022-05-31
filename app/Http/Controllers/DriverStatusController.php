<?php

namespace App\Http\Controllers;

use App\Models\DriverStatus;
use App\Repository\DriverRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DriverStatusController extends Controller
{
    //
    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $driver_id = $request->input('did');
        return Inertia::render('DriverStatus', [
            'driverData' => $this->repository->find($driver_id),
            'statuses' => DriverStatus::where('driver_id', $driver_id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->whenHas(['driver_id', 'date_start', 'date_end'], function () use ($request) {
            try {
                DriverStatus::create($request->only(['driver_id', 'date_start', 'date_end', 'notes']));
                return back();
            } catch (Error | Exception $e) {
                error_log($e);
                return back();
                // Route::redirect('/driverstatus');
            }
        });
    }
}
