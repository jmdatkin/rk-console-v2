<?php

namespace App\DataTables;

use App\Repository\RouteRepository;

class RouteDataTable extends BaseDataTable
{
    public function __construct(RouteRepository $repository)
    {
        parent::__construct($repository);
    }
}
