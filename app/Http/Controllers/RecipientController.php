<?php

namespace App\Http\Controllers;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\RecipientRepositoryInterface;
use Inertia\Inertia;

class RecipientController extends BaseResourceController
{
    public function __construct(RecipientDataTableInterface $dataTable,  RecipientRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render(
            'Resources/RecipientDataTable',
            [
                "cols" => $this->dataTable->cols(),
                "data" => $this->dataTable->data()
            ]
        );
    }

}
