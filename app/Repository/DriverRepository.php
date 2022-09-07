<?php

namespace App\Repository;

use App\Models\Driver;
use App\Models\Recipient;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Support\Collection;

class DriverRepository extends BaseRepository
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

   public function destroy($id) {
       $model = $this->find($id);
       $model->routes()->detach();
       $model->alternateRoutes()->detach();
       parent::destroy($id);
   }
}