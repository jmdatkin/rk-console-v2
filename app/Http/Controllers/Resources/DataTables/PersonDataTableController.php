<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\PersonDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonDataTableController extends Controller
{
    //
    public function __construct(PersonDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }
}
