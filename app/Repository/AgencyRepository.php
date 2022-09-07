<?php

namespace App\Repository;

use App\Models\Agency;

class AgencyRepository extends BaseRepository
{

   /**
    * AgencyRepository constructor.
    *
    * @param Agency $model
    */
   public function __construct(Agency $model)
   {
       parent::__construct($model);
   }
}