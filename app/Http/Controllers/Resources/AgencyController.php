<?php

namespace App\Http\Controllers\Resources;

use App\DataTables\AgencyDataTableInterface;
use App\Repository\AgencyRepositoryInterface;

class AgencyController extends BaseResourceController
{
    public function __construct(AgencyDataTableInterface $dataTable,  AgencyRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }
}
