<?php

namespace App\DataTables\Eloquent;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\Eloquent\RecipientRepository;
use App\Repository\RecipientRepositoryInterface;

class RecipientDataTable extends BasePersonRoleDataTable implements RecipientDataTableInterface
{
    public function __construct(RecipientRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function data() {
        return parent::data()->load('routes');
    }
}
