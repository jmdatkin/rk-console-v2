<?php

namespace App\DataTables\Eloquent;

use App\DataTables\AgencyDataTableInterface;
use App\Repository\AgencyRepositoryInterface;

class AgencyDataTable extends BaseDataTable implements AgencyDataTableInterface
{
    public function __construct(AgencyRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
