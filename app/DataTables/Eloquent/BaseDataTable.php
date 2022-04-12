<?php

use App\Repository\EloquentRepositoryInterface;

class BaseDataTable implements EloquentDataTableInterface {
    public function __construct(EloquentRepositoryInterface $repository)
    {
        $this->repository = $repository;   
    }

    public function data() {
        return $this->repository->all();
    }   
}