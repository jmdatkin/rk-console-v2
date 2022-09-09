<?php

namespace App\DataTables;

class BaseDataTable
{
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function data()
    {
        return $this->repository->all();
    }
}
