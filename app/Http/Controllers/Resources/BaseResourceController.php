<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BaseResourceController extends Controller
{

    /**
     * BaseResourceController constructor.
     * 
     * @param \App\Repository\EloquentRepositoryInterface
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $this->repository->create($request->all());
            return response('Record successfully created.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not created.', 409);
        }
    }

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        //
        return $this->repository->find($id);
    }

    /**
     * Display all resources.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');
            $this->repository->update($id, $data);
            return response('Record successfully edited.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not edited.', 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->destroy($id);
            return response('Record(s) successfully deleted.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record(s) were not deleted.' . $e, 409);
        }
    }

    /**
     * Remove the specified resource(s) from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        //
        try {
            $ids = $request->input('ids');
            $this->repository->destroyMany($ids);
            return response('Record(s) successfully deleted.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record(s) were not deleted.' . $e, 409);
        }
    }

    /**
     * Import multiple records from CSV
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            $data = $request->input('data');
            $rows = explode("\n", $data);       //Split data by newline
            $csv_data = array_map(function ($row) {
                return str_getcsv($row);
            }, $rows);

            $header = $csv_data[0];
            $body = array_slice($csv_data, 1);

            if ($this->checkCsvHeaders($header))
                $this->repository->import($body);
            else
                throw new Error("Headers do not match");
        } catch (Exception | Error $e) {
            error_log($e);
        }
        return Redirect::route('datatables.recipients');
    }
}
