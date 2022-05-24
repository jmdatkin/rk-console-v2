<?php

namespace App\Http\Controllers;

use App\Repository\PersonRepositoryInterface;
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
        return $this->repository->find($id)->load('person');
    }

    public function all() {
        return $this->repository->all()->load('person');
    }

    public function update(Request $request, $id) {
        $data = $request->except('id', 'person_id', 'user_id', 'created_at', 'updated_at', 'deleted_at');
        return $this->repository->update($id, $data);
    }

    public function store(Request $request) {
        error_log($request->collect());
        return $this->repository->store($request->collect());
    }

}
