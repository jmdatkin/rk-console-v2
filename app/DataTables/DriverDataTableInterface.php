<?php

namespace App\DataTables;

interface DriverDataTableInterface extends EloquentDataTableInterface {
    public function cols();
}