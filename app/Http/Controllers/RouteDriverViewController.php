<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Repository\DriverRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
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

    public function data($weekday) {
        return Route::with(['drivers' => function($query) use ($weekday) {
            $query->where('weekday', $weekday);
        }])->get();
    }

    public function driverAlternatesForRoute($route) {

    }

    public function index() {
        return Inertia::render('RouteDriverView', [
            "data" => $this->routeRepository->all()->load('drivers')
        ]);
    }
}
