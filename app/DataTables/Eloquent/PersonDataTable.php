<?php

namespace App\DataTables\Eloquent;

use App\DataTables\PersonDataTableInterface;
use App\Models\Role;
use App\Repository\PersonRepositoryInterface;

class PersonDataTable extends BaseDataTable implements PersonDataTableInterface
{
    public function __construct(PersonRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function data() {
        return $this->repository->withRoles()->map(function($item) {
            $newItem = $item;
            $newItem->roles->transform(function($role) { return $role->name; });
            return $newItem; 
            // return 3;
        });
        // return $this->repository->all()->join(Role::class);
    }
}
