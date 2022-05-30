<?php

namespace App\Http\Controllers;

use App\DataTables\DriverDataTableInterface;
use App\Repository\DriverRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DriverController extends BasePersonRoleController
{
    public function __construct(DriverDataTableInterface $dataTable, DriverRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }

    public function index()
    {
        return Inertia::render(
            'Resources/DriverDataTable',
        );
    }

    public function data() {
        return $this->dataTable->data();
    }

    public function alternates($driver_id) {
        return $this->repository->find($driver_id)->alternateRoutes;
    }

    public function assignAlternate($driver_id, $route_id) {
        try {
            $this->repository->find($driver_id)->alternateRoutes()->attach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }

    public function deassignAlternate($driver_id, $route_id) {
        try {
            $this->repository->find($driver_id)->alternateRoutes()->detach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }
}
