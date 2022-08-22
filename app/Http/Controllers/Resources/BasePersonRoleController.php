<?php

namespace App\Http\Controllers\Resources;

use App\Repository\PersonRoleRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;

class BasePersonRoleController extends BaseResourceController
{
    /**
     * BasePersonRoleController constructor.
     * 
     * @param PersonRoleRepositoryInterface $repository
     */
    public function __construct(PersonRoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        try {
            return $this->repository->find($id)->load('person');
        } catch (Error $e) {
            abort(404);
        }
    }

    /**
     * Display all resources.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repository->all()->load('person');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->repository->store($request->collect());
            return response('Record successfully created.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not created.', 409);
        }
    }
}
