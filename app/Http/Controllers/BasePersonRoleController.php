<?php

namespace App\Http\Controllers;

use App\Repository\PersonRepositoryInterface;
use App\Repository\PersonRoleRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;

class BasePersonRoleController extends BaseResourceController
{
    //
    public function __construct(PersonRoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function show($id)
    {
        return $this->repository->find($id)->load('person');
    }

    public function all()
    {
        return $this->repository->all()->load('person');
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->except('id', 'person_id', 'user_id', 'created_at', 'updated_at', 'deleted_at');
            $this->repository->update($id, $data);
            return response('Record successfully edited.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not edited.', 409);
        }
    }

    public function store(Request $request)
    {
        try {
            throw new Exception();
            $this->repository->store($request->collect());
            return response('Record successfully created.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not created.', 409);
        }
    }
}
