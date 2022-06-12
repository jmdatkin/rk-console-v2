<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RouteDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteDataTableController extends BaseDataTableController
{
    //
    public function __construct(RouteDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

    public function index()
    {
        //
        return Inertia::render(
            'Resources/RouteDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }
}
