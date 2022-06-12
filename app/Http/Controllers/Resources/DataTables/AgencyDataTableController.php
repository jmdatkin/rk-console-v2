<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\AgencyDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgencyDataTableController extends Controller
{
    //
    public function __construct(AgencyDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }
}
