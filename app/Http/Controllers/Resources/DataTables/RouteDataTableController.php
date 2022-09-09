<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RouteDataTable;
use Inertia\Inertia;

class RouteDataTableController extends BaseDataTableController
{
    /**
     * RouteDataTableController constructor.
     * 
     * @param RouteDataTable $dataTable
     */
    public function __construct(RouteDataTable $dataTable)
    {
        parent::__construct($dataTable);        
    }

    /**
     * Load the view which displays the Route DataTable
     */
    public function index()
    {
        return Inertia::render(
            'Admin/Resources/RouteDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }
}
