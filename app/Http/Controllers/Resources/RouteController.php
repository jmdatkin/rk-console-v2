<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\RouteDataTableInterface;
use App\Repository\RouteRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RouteController extends BaseResourceController
{
    public function __construct(RouteDataTableInterface $dataTable,  RouteRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }

    public function show($id) {
        $route = $this->repository->find($id);
        $drivers = $route->drivers;
        $recipients = $route->recipients;
        return Inertia::render('Resources/Routes/Route', [
            "data" => $route,
            "drivers" => $drivers,
            "recipients" => $recipients
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            parent::store($request);
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            parent::update($request, $id);
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'success',
                'message' => 'Record successfully edited.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not edited.'
            ]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        try {
            parent::bulkDestroy($request);
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'success',
                'message' => 'Record(s) successfully deleted.'
            ]);
        } catch (Exception $e) {
            return Redirect::route('datatables.routes')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. One or more record(s) were not deleted.'
            ]);
        }
    }

    public function alternateDrivers($id)
    {
        return $this->repository->find($id)->driverAlternates;
    }
}
