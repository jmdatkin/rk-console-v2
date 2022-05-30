<?php

namespace App\Http\Controllers;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\RecipientRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecipientController extends BasePersonRoleController
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
        );
    }

    public function data() {
        return $this->dataTable->data();
    }
}
