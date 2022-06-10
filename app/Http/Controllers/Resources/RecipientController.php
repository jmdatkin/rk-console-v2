<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\AgencyRepositoryInterface;
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
    public function index(AgencyRepositoryInterface $agencyRepository)
    {
        //
        return Inertia::render(
            'Resources/RecipientDataTable',
            [
                "agencies" => $agencyRepository->all()
            ]
        );
    }

    public function show($id)
    {
        return Inertia::render(
            'Resources/Recipient',
            [
                "data" => $this->get($id)
            ]
        );
    }

    public function data()
    {
        return $this->dataTable->data();
    }
}
