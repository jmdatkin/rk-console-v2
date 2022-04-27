<?php

namespace App\Repository\Eloquent;

use App\Models\Recipient;
use App\Repository\RecipientRepositoryInterface;
use Illuminate\Support\Collection;

class RecipientRepository extends BasePersonRoleRepository implements RecipientRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Recipient $model
    */
   public function __construct(Recipient $model)
   {
       parent::__construct($model);
   }

//    public function findPerson($id) {
//        return $this->find($id)->join('people', 'person_id', 'people.id')->get();
//    }
}