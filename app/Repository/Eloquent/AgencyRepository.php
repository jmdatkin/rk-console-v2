<?php

namespace App\Repository\Eloquent;

use App\Models\Agency;
use App\Repository\AgencyRepositoryInterface;

class AgencyRepository extends BaseRepository implements AgencyRepositoryInterface
{

   /**
    * DriverRepository constructor.
    *
    * @param Agency $model
    */
   public function __construct(Agency $model)
   {
       parent::__construct($model);
   }
}