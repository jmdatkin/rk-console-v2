<?php

namespace App\DataTables\Eloquent;

use App\DataTables\DriverDataTableInterface;
use App\Repository\DriverRepositoryInterface;
use App\Repository\Eloquent\DriverRepository;

class DriverDataTable extends BasePersonRoleDataTable implements DriverDataTableInterface
{
    public function __construct(DriverRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
