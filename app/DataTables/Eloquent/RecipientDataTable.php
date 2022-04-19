<?php

namespace App\DataTables\Eloquent;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\Eloquent\RecipientRepository;

class RecipientDataTable extends BaseDataTable implements RecipientDataTableInterface
{
    public function __construct(RecipientRepository $repository)
    {
        parent::__construct($repository);
    }
}
