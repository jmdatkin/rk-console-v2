<?php

namespace App\Repository\Eloquent;

use App\Models\DriverException;
use App\Repository\DriverExceptionRepositoryInterface;

class DriverExceptionRepository extends BaseRepository implements DriverExceptionRepositoryInterface
{

   /**
    * DriverRepository constructor.
    *
    * @param DriverException $model
    */
   public function __construct(DriverException $model)
   {
       parent::__construct($model);
   }
}