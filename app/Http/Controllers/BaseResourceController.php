<?php

namespace App\Http\Controllers;

use App\Repository\EloquentRepositoryInterface;
use Error;
use Exception;
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

    public function flashMessages($function, $success_msg, $error_msg)
    {
        try {
            $function();
            return redirect()->back()->with([
                'message-class' => 'success',
                'message' => $success_msg
            ]);
        } catch (Exception | Error $e) {
            return redirect()->back()->with([
                'message-class' => 'error',
                'message' => $error_msg.$e
            ]);
        }
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
        $this->repository->create($request->all());
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
        $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');
        $this->repository->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        //
        $ids = $request->input('ids');
        $this->repository->destroyMany($ids);
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
