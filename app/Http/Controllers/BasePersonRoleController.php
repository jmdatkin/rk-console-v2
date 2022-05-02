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

    public function showWithPerson($id) {
        return $this->repository->findWithPerson($id);
    }

    public function allWithPerson() {
        return $this->repository->allWithPerson();
    }

    public function updateWithPerson($id, $attr) {
        return $this->repository->updateWithPerson($id, $attr);
    }

    public function storeWithPerson(Request $request) {
        $data = $request->all();
        return $this->repository->storeWithPerson($data);
    }

    //Override default methods
    public function show($id) {
        return $this->showWithPerson($id);
    }

    public function all() {
        return $this->allWithPerson();
    }

    public function update(Request $request, $id) {
        $attr = $request->except('id', 'person_id', 'user_id', 'created_at', 'updated_at', 'deleted_at');
        return $this->updateWithPerson($id, $attr);
    }

    public function store(Request $request) {
        return $this->storeWithPerson($request);
    }

}
