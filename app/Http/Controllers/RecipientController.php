<?php

namespace App\Http\Controllers;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\RecipientRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecipientController extends BasePersonRoleController
{
    public function __construct(RecipientDataTableInterface $dataTable,  RecipientRepositoryInterface $repository)
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
            'Resources/RecipientDataTable',
        );
    }

    public function data() {
        return $this->dataTable->data();
    }

    public function store(Request $request)
    {
        try {
            parent::store($request);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            parent::update($request, $id);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'success',
                'message' => 'Record successfully edited.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not edited.'
            ]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        try {
            parent::bulkDestroy($request);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'success',
                'message' => 'Record(s) successfully deleted.'
            ]);
        } catch (Exception | Error $e) {
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. One or more record(s) were not deleted.'
            ]);
        }
    }

    public function checkCsvHeaders($headers)
    {
        $cols = array_values($this->dataTable->cols());
        var_dump($cols);
        foreach ($headers as $header) {
            error_log($header);
            if (!in_array($header, $cols))
                return false;
        }
        return true;
    }
}
