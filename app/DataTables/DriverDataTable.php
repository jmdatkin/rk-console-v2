<?php

namespace App\DataTables;

use App\Repository\DriverRepository;

class DriverDataTable extends BaseDataTable
{
    public function __construct(DriverRepository $repository)
    {
        parent::__construct($repository);
    }
}
