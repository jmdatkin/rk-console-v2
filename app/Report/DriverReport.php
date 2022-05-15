<?php

namespace App\Report;

use App\Repository\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DriverReport extends BaseReport
{

    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function driver($driver_id)
    {
        try {
            return $this->repository->find($driver_id)->routes->map(function ($route) {
                return [
                    'routeName' => $route->name,
                    'recipients' => $route->recipients->load(['person'])
                ];
            });
        } catch (ModelNotFoundException $e) {
            return collect();
        }
    }
}
