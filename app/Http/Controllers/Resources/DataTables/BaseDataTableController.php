<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\EloquentDataTableInterface;
use App\Http\Controllers\Controller;

class BaseDataTableController extends Controller
{
    /**
     * BaseDataTableController constructor.
     * 
     * @param App\DataTables\EloquentDataTableInterface $dataTable
     */
    public function __construct(EloquentDataTableInterface $dataTable) {
        $this->dataTable = $dataTable;
    }

    /**
     * Retrieve the data from this class's injected DataTable class
     */
    public function data() {
        return $this->dataTable->data();
    }
}
