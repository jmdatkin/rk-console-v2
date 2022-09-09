<?php

namespace App\DataTables;

use App\Repository\AgencyRepository;

class AgencyDataTable extends BaseDataTable
{
    public function __construct(AgencyRepository $repository)
    {
        parent::__construct($repository);
    }
}
