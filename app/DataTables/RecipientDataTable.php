<?php

namespace App\DataTables;

use App\Repository\RecipientRepository;

class RecipientDataTable extends BaseDataTable
{
    public function __construct(RecipientRepository $repository)
    {
        parent::__construct($repository);
    }

    // public function data() {
    //     return parent::data()->load('routes');
    // }
}
