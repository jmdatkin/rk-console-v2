<?php

namespace App\Repository\Eloquent;

use App\Models\Recipient;
use App\Repository\RecipientRepositoryInterface;
use Illuminate\Support\Collection;

class RecipientRepository extends BaseRepository implements RecipientRepositoryInterface
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
}