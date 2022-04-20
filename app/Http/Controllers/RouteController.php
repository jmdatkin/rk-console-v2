<?php

namespace App\Http\Controllers;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render(
            'Resources/RouteDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }

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
}