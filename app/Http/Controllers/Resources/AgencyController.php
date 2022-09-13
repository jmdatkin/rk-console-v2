<?php

namespace App\Http\Controllers\Resources;

use App\Repository\AgencyRepository;

class AgencyController extends BaseResourceController
{
    public function __construct( AgencyRepository $repository)
    {
        parent::__construct($repository, 'agency');
    }
}
