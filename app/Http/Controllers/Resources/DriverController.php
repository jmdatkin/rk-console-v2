<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\DriverDataTableInterface;
use App\Repository\DriverRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DriverController extends BasePersonRoleController
{
    public function __construct( DriverRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function show($id)
    {
        return Inertia::render(
            'Resources/Drivers/Driver',
            [
                "data" => $this->get($id)
            ]
        );
    }

    public function routes($driver_id) {
        return $this->repository->find($driver_id)->routes;
    }

    public function alternates($driver_id)
    {
        return $this->repository->find($driver_id)->alternateRoutes;
    }

    public function assign(Request $request, RouteRepositoryInterface $routeRepository, $driver_id, $route_id)
    {
        try {
            $weekday = $request->input('weekday');
            // $this->repository->find($driver_id)->deassignRoute($route_id, $weekday);
            $routeRepository->find($route_id)->deassignDriver($weekday);
            $this->repository->find($driver_id)->assignRoute($route_id, $weekday);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }

    public function deassign(Request $request, RouteRepositoryInterface $routeRepository, $driver_id, $route_id)
    {
        try {
            $weekday = $request->input('weekday');
            $routeRepository->find($route_id)->deassignDriver($weekday);
            $this->repository->find($driver_id)->routes()->detach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }

    public function assignAlternate($driver_id, $route_id)
    {
        try {
            $this->repository->find($driver_id)->alternateRoutes()->attach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }

    public function deassignAlternate($driver_id, $route_id)
    {
        try {
            $this->repository->find($driver_id)->alternateRoutes()->detach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }
}
