<?php

namespace App\Repository\Eloquent;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Illuminate\Support\Collection;

class RouteRepository extends BaseRepository implements RouteRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Route $model
    */
   public function __construct(Route $model)
   {
       parent::__construct($model);
   }
}