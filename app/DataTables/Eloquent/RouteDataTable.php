<?php

namespace App\DataTables\Eloquent;

use App\DataTables\RouteDataTableInterface;
use App\Repository\Eloquent\RouteRepository;

class RouteDataTable extends BaseDataTable implements RouteDataTableInterface
{
    public function __construct(RouteRepository $repository)
    {
        parent::__construct($repository);
    }
}
