<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\PersonDataTableInterface;
use App\Repository\PersonRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    //
    public function __construct( PersonRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
