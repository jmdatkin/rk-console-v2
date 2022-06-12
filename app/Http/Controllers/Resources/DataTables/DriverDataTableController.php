<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\DriverDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverDataTableController extends BaseDataTableController
{
    //
    public function __construct(DriverDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }
}
