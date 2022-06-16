<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\DriverException;
use App\Models\DriverStatus;
use App\Repository\DriverExceptionRepositoryInterface;
use App\Repository\DriverRepositoryInterface;
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
        return Inertia::render('DriverExceptions/Index', [
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

    public function makeSubstitute($exception_id, $substitute_driver_id) {
        $exception = $this->repository->find($exception_id);
        $exception->update(['substitute_driver_id' => $substitute_driver_id]);
        // $substitute_driver = $this->driverRepository->find($substitute_driver_id);
        // $exception->substituteDriver()->associate($substitute_driver);
        // $this->repository->find($exception_id)->substituteDriver()->associate($substitute_driver_id);
    }
}
