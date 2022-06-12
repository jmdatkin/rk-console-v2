<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RecipientDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecipientDataTableController extends BaseDataTableController
{
    //
    public function __construct(RecipientDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }
}
