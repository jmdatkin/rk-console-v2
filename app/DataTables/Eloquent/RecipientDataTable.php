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

    public function cols() {
        return [
            "id" => "id",
            "firstName" => "First Name",
            "lastName" => "Last Name",
            "phoneHome" => "Home #",
            "phoneCell" => "Cell #",
            "email" => "E-mail Address",
        ];
    }
}
