<?php

namespace App\DataTables;

use App\Repository\PersonRepository;

class PersonDataTable extends BaseDataTable
{
    public function __construct(PersonRepository $repository)
    {
        parent::__construct($repository);
    }

    public function data() {
        return $this->repository->withRoles()->map(function($item) {
            $newItem = $item;
            $newItem->roles->transform(function($role) { return $role->name; });
            return $newItem; 
        });
    }
}
