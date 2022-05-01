<?php

namespace App\Repository\Eloquent;

use App\Repository\PersonRoleRepositoryInterface;
use Error;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BasePersonRoleRepository extends BaseRepository implements PersonRoleRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Model $model
    */
   public function __construct(Model $model)
   {
       parent::__construct($model);
   }

   public function findPerson($id) {
    //    return $this->find($id)->join('people', 'person_id', '=', 'people.id')->get();
    return $this->model->with('person')->find($id);
   }

   public function withPeople() {
       return $this->model->with('person')->get();
   }
}