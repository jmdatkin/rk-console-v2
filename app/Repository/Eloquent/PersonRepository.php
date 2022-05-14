<?php

namespace App\Repository\Eloquent;

use App\Models\Person;
use App\Repository\PersonRepositoryInterface;
use Error;

class PersonRepository extends BaseRepository implements PersonRepositoryInterface
{

   /**
    * PersonRepository constructor.
    *
    * @param Person $model
    */
   public function __construct(Person $model)
   {
       parent::__construct($model);
   }

   public function withRoles() {
       return $this->model->with('roles')->get();
   }
}