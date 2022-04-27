<?php

namespace App\Http\Controllers;

use App\Repository\PersonRoleRepositoryInterface;
use Illuminate\Http\Request;

class BasePersonRoleController extends BaseResourceController
{
    //
    public function __construct(PersonRoleRepositoryInterface $repository)
    {
        parent::__construct($repository);   
    }

    public function show($id) {
        return $this->repository->findPerson($id);
    }
}
