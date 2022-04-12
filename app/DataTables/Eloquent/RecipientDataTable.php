<?php

use App\Repository\Eloquent\RecipientRepository;

class RecipientDataTable extends BaseDataTable {
    public function __construct(RecipientRepository $repository)
    {
        parent::__construct($repository);
    }
}