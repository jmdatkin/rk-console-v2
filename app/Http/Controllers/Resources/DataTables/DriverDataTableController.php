<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\DriverDataTable;
use App\Models\PendingJob;
use Inertia\Inertia;

class DriverDataTableController extends BaseDataTableController
{
    /**
     * DriverDataTableController constructor.
     * 
     * @param DriverDataTable $dataTable
     */
    public function __construct(DriverDataTable $dataTable)
    {
        parent::__construct($dataTable);
    }

    /**
     * Load the view which displays the Driver DataTable
     */
    public function index()
    {
        return Inertia::render(
            'Admin/Resources/DriverDataTable', [
                'pending_jobs' => PendingJob::uncommitted()->withNameClass('driver')->get()
            ]
        );
    }
}
