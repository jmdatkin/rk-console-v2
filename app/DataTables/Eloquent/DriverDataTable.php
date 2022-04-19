<?php

namespace App\DataTables\Eloquent;

use App\DataTables\DriverDataTableInterface;
use App\Repository\Eloquent\DriverRepository;

class DriverDataTable extends BaseDataTable implements DriverDataTableInterface
{
    public function __construct(DriverRepository $repository)
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
