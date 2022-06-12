<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\AgencyDataTableInterface;
use App\Repository\AgencyRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AgencyController extends BaseResourceController
{
    public function __construct(AgencyDataTableInterface $dataTable,  AgencyRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
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
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            parent::update($request, $id);
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'success',
                'message' => 'Record successfully edited.'
            ]);
        } catch (Exception $e) {
            error_log($e);
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not edited.'
            ]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        try {
            parent::bulkDestroy($request);
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'success',
                'message' => 'Record(s) successfully deleted.'
            ]);
        } catch (Exception $e) {
            return Redirect::route('datatables.agencies')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. One or more record(s) were not deleted.'
            ]);
        }
    }
}
