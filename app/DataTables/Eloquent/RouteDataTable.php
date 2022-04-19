<?php

namespace App\DataTables\Eloquent;

use App\DataTables\RouteDataTableInterface;
use App\Repository\RouteRepositoryInterface;

class RouteDataTable extends BaseDataTable implements RouteDataTableInterface
{
    public function __construct(RouteRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
