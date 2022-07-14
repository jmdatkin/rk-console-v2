<?php

namespace App\Http\Controllers\Resources;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Models\DriverException;
use App\Models\DriverExceptionRoute;
use App\Models\DriverStatus;
use App\Repository\DriverExceptionRepositoryInterface;
use App\Repository\DriverRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DriverExceptionController extends Controller
{
    //
    public function __construct(DriverExceptionRepositoryInterface $repository, DriverRepositoryInterface $driverRepository)
    {
        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
    }

    public function index(Request $request)
    {
        $driver_id = $request->input('did');
        return Inertia::render('Admin/DriverExceptions', [
            'driverData' => $this->driverRepository->find($driver_id),
            'exceptions' => DriverException::where('driver_id', $driver_id)->get()
        ]);
    }

    public function data($driver_id) {
        return $this->driverRepository->find($driver_id)->exceptions;
    }

    public function store(Request $request)
    {
        $request->whenHas(['driver_id', 'date_start', 'date_end'], function () use ($request) {
            try {
                DriverException::create($request->only(['driver_id', 'date_start', 'date_end', 'notes']));
                return back();
            } catch (Error | Exception $e) {
                error_log($e);
                return back();
            }
        });
    }

    public function makeSubstitute($exception_id, $substitute_driver_id, Request $request) {
        $input = $request->only(['date', 'route_id']);
        $driver_exception_route = DriverExceptionRoute::create([
            'e_id' => $exception_id,
            'route_id' => $input['route_id'],
            'sub_id' => $substitute_driver_id,
            'date' => RkCarbon::parseStd($input['date'])]);
    }
}
