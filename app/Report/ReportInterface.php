<?php

namespace App\Report;

use Illuminate\Http\Request;

interface ReportInterface {
    public function data(array $input);
}