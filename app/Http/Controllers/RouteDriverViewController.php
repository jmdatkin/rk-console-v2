<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Report\DriverExceptionReport;
use App\Repository\DriverRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteDriverViewController extends Controller
{
    //
    public function __construct(RouteRepositoryInterface $routeRepository, DriverRepositoryInterface $driverRepository)
    {
        $this->routeRepository = $routeRepository;
        $this->driverRepository = $driverRepository;
    }

    public function data(Request $request, DriverExceptionReport $report)
    {
        return $report->data($request->input('date'));
    }

    public function index()
    {
        return Inertia::render('RouteDriver/Index', [
            // "data" => 
        ]);
    }
}
