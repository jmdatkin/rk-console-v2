<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Repository\DriverRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
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

    public function data(Request $request)
    {
        try {
            $weekday = $request->input('weekday');
            return Route::with(['drivers' => function ($query) use ($weekday) {
                $query->where('weekday', $weekday);
            }])->get();
        } catch (Error | Exception $e) {
            error_log($e);
        }
    }

    public function index()
    {
        return Inertia::render('RouteDriver/Index', [
            // "data" => 
        ]);
    }
}
