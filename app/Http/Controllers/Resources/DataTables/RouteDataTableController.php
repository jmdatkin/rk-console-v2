<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RouteDataTableInterface;
use Inertia\Inertia;

class RouteDataTableController extends BaseDataTableController
{
    /**
     * RouteDataTableController constructor.
     * 
     * @param RouteDataTableInterface $dataTable
     */
    public function __construct(RouteDataTableInterface $dataTable)
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
