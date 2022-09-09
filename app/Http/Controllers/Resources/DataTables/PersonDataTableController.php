<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\PersonDataTable;
use Inertia\Inertia;

class PersonDataTableController extends BaseDataTableController
{
    /**
     * PersonDataTableController constructor.
     * 
     * @param PersonDataTable $dataTable
     */
    public function __construct(PersonDataTable $dataTable)
    {
        parent::__construct($dataTable);        
    }

    /**
     * Load the view which displays the Person DataTable
     */
    public function index()
    {
        return Inertia::render(
            'Admin/Resources/PersonDataTable',
        );
    }
}
