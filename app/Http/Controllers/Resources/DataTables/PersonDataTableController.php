<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\PersonDataTableInterface;
use Inertia\Inertia;

class PersonDataTableController extends BaseDataTableController
{
    /**
     * PersonDataTableController constructor.
     * 
     * @param PersonDataTableInterface $dataTable
     */
    public function __construct(PersonDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

    /**
     * Load the view which displays the Person DataTable
     */
    public function index()
    {
        return Inertia::render(
            'Resources/PersonDataTable',
        );
    }
}
