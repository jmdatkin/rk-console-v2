<?php

namespace App\Repository\Eloquent;

use App\Models\Recipient;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Support\Collection;

class DriverRepository extends BaseRepository implements DriverRepositoryInterface
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