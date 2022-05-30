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
        // try {
        //     throw new Error();
        //     parent::update($request, $id);
        //     return Redirect::route('datatables.recipients', null, 200)->with([
        //         'message-class' => 'success',
        //         'message' => 'Record successfully edited.'
        //     ]);
        // } catch (Exception | Error $e) {
        //     error_log($e);
        //     return Redirect::route('datatables.recipients', null, 500)->with([
        //         'message-class' => 'error',
        //         'message' => 'An error occurred. Record was not edited.'
        //     ]);
        // }
        try {
            parent::update($request, $id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }

    public function destroyMany(Request $request)
    {
        try {
            parent::destroyMany($request);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
        // try {
        //     parent::destroyMany($request);
        //     return Redirect::route('datatables.recipients')->with([
        //         'message-class' => 'success',
        //         'message' => 'Record(s) successfully deleted.'
        //     ]);
        // } catch (Exception | Error $e) {
        //     error_log($e);
        //     return Redirect::route('datatables.recipients')->with([
        //         'message-class' => 'error',
        //         'message' => 'An error occurred. One or more record(s) were not deleted.'
        //     ]);
        // }
    }
}
