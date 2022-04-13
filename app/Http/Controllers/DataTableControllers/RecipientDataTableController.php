<?php

namespace App\Http\Controllers\DataTableControllers;

use App\DataTables\RecipientDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecipientDataTableController extends Controller
{
    public function __construct(RecipientDataTableInterface $dataTable)
    {
        $this->dataTable = $dataTable;   
    }

    //
    public function data() {
        return $this->dataTable->data();
    }
}
