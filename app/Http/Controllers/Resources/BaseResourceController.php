<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessJobRequest;
use App\Jobs\SchedulePendingJob;
use App\Services\CSVProcessorService;
use Error;
use Exception;
use Facades\App\Facade\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BaseResourceController extends Controller
{

    /**
     * BaseResourceController constructor.
     * 
     * @param
     */
    public function __construct($repository, $resource_type)
    {
        $this->repository = $repository;
        $this->resource_type = $resource_type;
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
            if (Settings::appIsLocked()) {
                SchedulePendingJob::dispatchSync(
                    $this->resource_type,
                    'create',
                    null,
                    [$request->all()]
                );
                return response('Resource created as job.', 200);
            } else {
                $this->repository->create($request->all());
                return response('Record successfully created.', 200);
            }
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
    public function update(Request $request, int $id)
    {
        //
        try {
            $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');
            if (Settings::appIsLocked()) {
                SchedulePendingJob::dispatchSync(
                    $this->resource_type,
                    'update',
                    $id,
                    [$data]
                );
                return response('Resource created as job.', 200);
            } else {
                $this->repository->update($id, $data);
                return response('Record successfully edited.', 200);
            }
        } catch (Error | Exception $e) {
            Log::error($e);
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
            if (Settings::appIsLocked()) {
                SchedulePendingJob::dispatchSync(
                    $this->resource_type,
                    'delete',
                    $id
                );
                return response('Resource created as job.', 200);
            } else {
                $this->repository->destroy($id);
                return response('Record(s) successfully deleted.', 200);
            }
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
    public function import(Request $request, CSVProcessorService $csvService)
    {
        $data = $request->input('data');
        try {
            $csv = $csvService->parse($data);
            $this->repository->import($csv);
            return response('Success', 201);
        } catch (Error | Exception $e) {
            Log::error($e);
            return response('An error occurred.', 500);
        }
    }
}
