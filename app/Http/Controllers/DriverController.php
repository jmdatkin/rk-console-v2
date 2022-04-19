<?php

namespace App\Http\Controllers;

use App\DataTables\DriverDataTableInterface;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverController extends BaseResourceController
{
    public function __construct(DriverDataTableInterface $dataTable, DriverRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }

    public function index()
    {
        return Inertia::render(
            'Resources/DriverDataTable',
            [
                "data" => $this->dataTable->data()
            ]
        );
    }
}
