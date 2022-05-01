<?php

namespace App\Repository;

use App\Repository\EloquentRepositoryInterface;

interface PersonRoleRepositoryInterface extends EloquentRepositoryInterface {
    public function findWithPerson($id);
    public function allWithPerson();
    public function updateWithPerson($id, $attr);
}