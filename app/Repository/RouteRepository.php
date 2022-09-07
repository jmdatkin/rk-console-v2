<?php

namespace App\Repository;

use App\Models\Route;

class RouteRepository extends BaseRepository
{

   /**
    * RouteRepository constructor.
    *
    * @param Route $model
    */
   public function __construct(Route $model)
   {
       parent::__construct($model);
   }
}