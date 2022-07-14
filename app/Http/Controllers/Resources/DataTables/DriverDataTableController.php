<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\DriverDataTableInterface;
use App\Models\PendingJob;
use Inertia\Inertia;

class DriverDataTableController extends BaseDataTableController
{
    /**
     * DriverDataTableController constructor.
     * 
     * @param DriverDataTableInterface $dataTable
     */
    public function __construct(DriverDataTableInterface $dataTable)
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
