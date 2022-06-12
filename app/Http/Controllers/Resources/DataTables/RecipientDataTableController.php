<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RecipientDataTableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipientDataTableController extends BaseDataTableController
{
    //
    public function __construct(RecipientDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);        
    }

    public function index()
    {
        //
        return Inertia::render(
            'Resources/RecipientDataTable',
        );
    }
}
