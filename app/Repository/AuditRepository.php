<?php

namespace App\Repository;

use OwenIt\Auditing\Models\Audit;

class AuditRepository extends BaseRepository
{

   /**
    * AuditRepository constructor.
    *
    * @param Audit $model
    */
   public function __construct(Audit $model)
   {
       parent::__construct($model);
   }
}