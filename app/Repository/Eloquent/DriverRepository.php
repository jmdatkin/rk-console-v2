<?php

namespace App\Repository\Eloquent;

use App\Models\Driver;
use App\Models\Recipient;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Support\Collection;

class DriverRepository extends BasePersonRoleRepository implements DriverRepositoryInterface
{

   /**
    * DriverRepository constructor.
    *
    * @param Driver $model
    */
   public function __construct(Driver $model)
   {
       parent::__construct($model);
   }
}