<?php

namespace App\Http\Controllers;

use App\Repository\EloquentRepositoryInterface;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BaseResourceController extends Controller
{

    /**
     * 
     * @param \App\Repository\EloquentRepositoryInterface
     */
    public function __construct(EloquentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');
        try {
            $this->repository->update($id, $data);
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'success',
                'message' => 'Record successfully edited.'
            ]);
        } catch (Exception $e) {
            return Redirect::route('datatables.recipients')->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not edited.'
            ]);
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
        //
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