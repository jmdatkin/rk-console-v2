<?php

namespace App\Http\Controllers;

use App\DataTables\PersonDataTableInterface;
use App\Repository\PersonRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    //
    public function __construct(PersonDataTableInterface $dataTable, PersonRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }

    public function index()
    {
        return Inertia::render(
            'Resources/PersonDataTable',
        );
    }

    public function data() {
        return $this->dataTable->data();
    }

    public function store(Request $request)
    {
        try {
            parent::store($request);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            parent::update($request, $id);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'success',
                'message' => 'Record successfully edited.'
            ]);
        } catch (Exception | Error $e) {
            error_log($e);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not edited.'
            ]);
        }
    }

    public function destroyMany(Request $request)
    {
        try {
            parent::destroyMany($request);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'success',
                'message' => 'Record(s) successfully deleted.'
            ]);
        } catch (Exception | Error $e) {
            error_log($e);
            return Redirect::route('datatables.personnel')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. One or more record(s) were not deleted.'
            ]);
        }
    }

}
