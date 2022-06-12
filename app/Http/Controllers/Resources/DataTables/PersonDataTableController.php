<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\PersonDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonDataTableController extends BaseDataTableController
{
    //
    public function __construct(PersonDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

    public function index()
    {
        return Inertia::render(
            'Resources/PersonDataTable',
        );
    }
}
