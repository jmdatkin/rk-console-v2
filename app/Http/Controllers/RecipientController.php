<?php

namespace App\Http\Controllers;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\RecipientRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecipientController extends BaseResourceController
{
    public function __construct(RecipientDataTableInterface $dataTable,  RecipientRepositoryInterface $repository)
    {
        $this->dataTable = $dataTable;
        parent::__construct($repository);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render(
            'Resources/RecipientDataTable',
            [
                "cols" => $this->dataTable->cols(),
                "data" => $this->dataTable->data()
            ]
        );
    }

    public function checkCsvHeaders($headers)
    {
        $cols = array_values($this->dataTable->cols());
        var_dump($cols);
        foreach ($headers as $header) {
            error_log($header);
            if (!in_array($header, $cols))
                return false;
        }
        return true;
    }
}
