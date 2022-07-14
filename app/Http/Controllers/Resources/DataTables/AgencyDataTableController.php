<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\AgencyDataTableInterface;
use Inertia\Inertia;

class AgencyDataTableController extends BaseDataTableController
{
    /**
     * AgencyDataTable constructor.
     * 
     * @param AgencyDataTableInterface $dataTable
     */
    public function __construct(AgencyDataTableInterface $dataTable)
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
