<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RouteDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteDataTableController extends Controller
{
    //
    public function __construct(RouteDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }
}
