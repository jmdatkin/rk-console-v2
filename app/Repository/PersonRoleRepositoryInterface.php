<?php

namespace App\Repository;

use App\Repository\EloquentRepositoryInterface;

interface PersonRoleRepositoryInterface extends EloquentRepositoryInterface {
    public function findPerson($id);
}