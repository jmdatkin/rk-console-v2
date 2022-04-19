<?php

namespace App\DataTables\Eloquent;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\Eloquent\RecipientRepository;
use App\Repository\RecipientRepositoryInterface;

class RecipientDataTable extends BaseDataTable implements RecipientDataTableInterface
{
    public function __construct(RecipientRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
