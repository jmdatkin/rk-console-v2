<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RecipientDataTable;
use App\DataTables\RecipientDataTableInterface;
use App\Repository\AgencyRepository;
use App\Models\PendingJob;
use Inertia\Inertia;

class RecipientDataTableController extends BaseDataTableController
{
    /**
     * RecipientDataTableController constructor.
     * 
     * @param RecipientDataTableInterface $dataTable
     */
    public function __construct(RecipientDataTable $dataTable)
    {
        parent::__construct($dataTable);
    }

    /**
     * Load the view which displays the Recipient DataTable
     * 
     * @param AgencyRepository $agencyRepository
     */
    public function index(AgencyRepository $agencyRepository)
    {
        return Inertia::render(
            'Admin/Resources/RecipientDataTable',
            [
                "agencies" => $agencyRepository->all(),
                "pending_jobs" => PendingJob::uncommitted()->withNameClass('recipient')->get()
            ]
        );
    }
}
