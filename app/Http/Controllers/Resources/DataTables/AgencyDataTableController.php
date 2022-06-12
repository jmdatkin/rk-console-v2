<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\AgencyDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgencyDataTableController extends BaseDataTableController
{
    //
    public function __construct(AgencyDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

    public function index()
    {
        //
        return Inertia::render(
            'Resources/AgencyDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }
}
