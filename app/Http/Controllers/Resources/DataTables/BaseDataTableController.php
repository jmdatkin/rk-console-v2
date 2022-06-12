<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\EloquentDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseDataTableController extends Controller
{
    //
    public function __construct(EloquentDataTableInterface $dataTable) {
        $this->dataTable = $dataTable;
    }

    public function data() {
        return $this->dataTable->data();
    }
}
