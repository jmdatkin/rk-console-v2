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
        return $this->repository->findWithPerson($id);
    }

    public function all() {
        return $this->repository->allWithPerson();
    }

    public function update(Request $request, $id) {
        $data = $request->except('id', 'person_id', 'user_id', 'created_at', 'updated_at', 'deleted_at');
        return $this->repository->updateWithPerson($id, $data);
    }

    public function store(Request $request) {
        $data = $request->all();
        return $this->repository->storeWithPerson($data);
    }

}
