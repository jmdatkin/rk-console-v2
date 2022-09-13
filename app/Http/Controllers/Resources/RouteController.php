<?php

namespace App\Http\Controllers\Resources;

use App\Jobs\Route\CreateRoute;
use App\Repository\RouteRepository;
use Error;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteController extends BaseResourceController
{
    public function __construct( RouteRepository $repository)
    {
        parent::__construct($repository, 'route');
    }

    public function show($id)
    {
        $route = $this->repository->find($id);
        $drivers = $route->drivers;
        $recipients = $route->recipients;
        return Inertia::render('Resources/Route', [
            "data" => $route,
            "drivers" => $drivers,
            "recipients" => $recipients
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            // parent::store($request);
            CreateRoute::dispatchSync($request->all());
            return response('Record successfully created.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not created.', 409);
        }
    }

    public function alternateDrivers($id)
    {
        return $this->repository->find($id)->driverAlternates;
    }
}
