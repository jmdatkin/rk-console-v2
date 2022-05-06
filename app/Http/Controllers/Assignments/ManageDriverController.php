<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Repository\DriverRepositoryInterface;
use Error;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ManageDriverController extends Controller
{
    //
    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($id)
    {
        return Inertia::render('Assignments/ManageDriver', [
            "driver_id" => $id,
            "assignment_data" => $this->getAssignments($id)
        ]);
    }

    public function makeAssignment($driver_id, $route_id, $weekday)
    {
        try {
            $this->repository->find($driver_id)->setRoute($route_id, $weekday);
            return Redirect::route('manage.driver', ["id" => $driver_id])->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);;
        } catch (Exception | Error $e) {
            return Redirect::route('manage.driver', ["id" => $driver_id])->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);;
        }
    }

    public function getAssignments($driver_id)
    {
        return $this->repository->find($driver_id)->routes;
    }
}
