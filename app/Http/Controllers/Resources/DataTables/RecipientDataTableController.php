<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RecipientDataTableInterface;
use App\Http\Controllers\Controller;
use App\Repository\AgencyRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipientDataTableController extends BaseDataTableController
{
    //
    public function __construct(RecipientDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

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
}
