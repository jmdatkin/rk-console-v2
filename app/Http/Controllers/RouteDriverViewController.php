<?php

namespace App\Http\Controllers;

use App\Models\Route;
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

    // public function data(Request $request)
    // {
    //     try {
    //         $date = Carbon::createFromFormat("mdY", $request->input('date'));
    //         $weekday = strtolower($date->shortDayName);
    //         error_log($weekday);
    //         return Route::with(['drivers' => function ($query) use ($weekday) {
    //             $query->where('weekday', $weekday);
    //         }])->get()->load('drivers.exceptions');
    //     } catch (Error | Exception $e) {
    //         error_log($e);
    //     }
    // }

    public function data(Request $request)
    {
        try {
            $date = Carbon::createFromFormat("mdY", $request->input('date'));
            $weekday = strtolower($date->shortDayName);
            error_log($weekday);
            return Route::with(
                [
                    'drivers' => function ($query) use ($weekday) {
                        return $query->where('weekday', $weekday)->with('exceptions');
                    }
                    // 'drivers.exceptions' => function ($query) use ($weekday) {
                    //     // $query->where('weekday', $weekday);
                    // }
                ]
            )->get();//->load('drivers.exceptions');
            // return Route::whereHas('drivers.exceptions', function($query) use ($weekday) {
            // return Route::has('drivers.exceptions')->get();
            // return $query->where()
            // });
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
