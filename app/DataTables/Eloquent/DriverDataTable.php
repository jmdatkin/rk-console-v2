<?php

namespace App\DataTables\Eloquent;

use App\DataTables\DriverDataTableInterface;
use App\Repository\Eloquent\DriverRepository;

class DriverDataTable extends BaseDataTable implements DriverDataTableInterface
{
    public function __construct(DriverRepository $repository)
    {
        parent::__construct($repository);
    }
}
