<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\AgencyDataTable;
use Inertia\Inertia;

class AgencyDataTableController extends BaseDataTableController
{
    /**
     * AgencyDataTable constructor.
     * 
     * @param AgencyDataTable $dataTable
     */
    public function __construct(AgencyDataTable $dataTable)
    {
        parent::__construct($dataTable);        
    }

    /**
     * Load the view which displays the Agency DataTable
     */
    public function index()
    {
        return Inertia::render(
            'Admin/Resources/AgencyDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }
}
