<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\Http\Controllers\Controller;

class BaseDataTableController extends Controller
{
    /**
     * BaseDataTableController constructor.
     * 
     * @param $dataTable
     */
    public function __construct($dataTable) {
        $this->dataTable = $dataTable;
    }

    /**
     * Retrieve the data from this class's injected DataTable class
     */
    public function data() {
        return $this->dataTable->data();
    }
}
