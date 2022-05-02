<?php

namespace App\Http\Controllers;

use App\DataTables\PersonDataTableInterface;
use App\Repository\PersonRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    //
    public function __construct(PersonDataTableInterface $dataTable, PersonRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }

    public function index()
    {
        return Inertia::render(
            'Resources/PersonDataTable',
        );
    }

    public function data() {
        return $this->dataTable->data();
    }
}
