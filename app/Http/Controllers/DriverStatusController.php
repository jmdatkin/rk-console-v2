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

    public function index()
    {
        return Inertia::render('DriverStatus', [
            'driverData' => $this->repository->find(1),
            'statuses' => DriverStatus::where('driver_id', 1)->get()
        ]);
    }

    public function store(Request $request)
    {
        error_log("hi owo");
        error_log($request->collect());
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
