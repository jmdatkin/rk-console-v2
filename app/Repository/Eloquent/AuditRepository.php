<?php

namespace App\Repository\Eloquent;

use App\Models\Agency;
use App\Repository\AgencyRepositoryInterface;
use App\Repository\AuditRepositoryInterface;
use OwenIt\Auditing\Models\Audit;

class AuditRepository extends BaseRepository implements AuditRepositoryInterface
{

   /**
    * DriverRepository constructor.
    *
    * @param Audit $model
    */
   public function __construct(Audit $model)
   {
       parent::__construct($model);
   }
}