<?php

namespace App\DataTables\Eloquent;

use App\DataTables\EloquentDataTableInterface;
use App\DataTables\PersonRoleDataTableInterface;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\PersonRoleRepositoryInterface;

class BasePersonRoleDataTable implements PersonRoleDataTableInterface
{
    public function __construct(PersonRoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function data()
    {
        return $this->repository->allWithPerson();
    }
}
