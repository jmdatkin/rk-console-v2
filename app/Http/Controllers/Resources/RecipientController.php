<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\RecipientDataTableInterface;
use App\Jobs\SchedulePendingJob;
use App\Repository\AgencyRepositoryInterface;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Error;
use Exception;
use Illuminate\Database\QueryException;
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

    public function show($id)
    {
        return Inertia::render(
            'Resources/Recipients/Recipient',
            [
                "data" => $this->get($id)
            ]
        );
    }

    public function assign($recipient_id, $route_id, Request $request)
    {
        $weekday = $request->input('weekday');
        try {
            $this->repository->find($recipient_id)->setRoute($route_id, $weekday);
        } catch (QueryException $e) {
            error_log($e);
            return response($e, 409);
        }
    }

    public function deassign(Request $request, RouteRepositoryInterface $routeRepository, $recipient_id, $route_id)
    {
        try {
            $weekday = $request->input('weekday');
            $routeRepository->find($route_id)->deassignRecipient($weekday);
            $this->repository->find($recipient_id)->routes()->detach($route_id);
            return response()->json([], 200);
        } catch (Error | Exception $e) {
            return response()->json([], 500);
        }
    }
    public function routes($recipient_id) {
        return $this->repository->find($recipient_id)->routes;
    }

    // public function update(Request $request, $id) {
    //     SchedulePendingJob::dispatchSync('recipient:update', [$id, $request->except([
    //         'id','person_id','user_id','created_at', 'updated_at', 'deleted_at'
    //     ])]);
    // }
}
