<?php

namespace App\Http\Controllers\Resources;

use App\Repository\DriverRepository;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Error;
use Exception;

class DriverController extends BaseResourceController
{
    /**
     * DriverController constructor.
     */
    public function __construct(DriverRepository $repository)
    {
        parent::__construct($repository, 'driver');
    }


    /**
     * Load the view which displays a single Driver resource.
     * 
     * @param int $id
     */
    public function show($id)
    {
        return Inertia::render(
            'Admin/Resources/Driver',
            [
                "data" => $this->get($id)
            ]
        );
    }


    /**
     * Get routes associated with a driver.
     * 
     * @param int $driver_id
     * @return Collection
     */
    public function routes($driver_id): Collection
    {
        return $this->repository->find($driver_id)->routes;
    }


    /**
     * Get alternate routes associated with a driver.
     * 
     * @param int $driver_id
     * @return Collection
     */
    public function alternates($driver_id): Collection
    {
        return $this->repository->find($driver_id)->alternateRoutes;
    }

    /**
     * Create an alternate Driver-Route association.
     * 
     * @param int $driver_id
     * @param int $route_id
     */
    public function assignAlternate($driver_id, $route_id)
    {
        try {
            $this->repository->find($driver_id)->alternateRoutes()->attach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }


    /**
     * Release an existing alternate Driver-Route association.
     * 
     * @param int $driver_id
     * @param int $route_id
     */
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
