<?php

namespace App\Http\Controllers\Resources\DataTables;

use App\DataTables\RecipientDataTableInterface;
use App\Repository\AgencyRepositoryInterface;
use App\Models\PendingJob;
use Inertia\Inertia;

class RecipientDataTableController extends BaseDataTableController
{
    /**
     * RecipientDataTableController constructor.
     * 
     * @param RecipientDataTableInterface $dataTable
     */
    public function __construct(RecipientDataTableInterface $dataTable)
    {
        parent::__construct($dataTable);
    }

    /**
     * Load the view which displays the Recipient DataTable
     * 
     * @param AgencyRepositoryInterface $agencyRepository
     */
    public function index(AgencyRepositoryInterface $agencyRepository)
    {
        return Inertia::render(
            'Resources/RecipientDataTable',
            [
                "agencies" => $agencyRepository->all(),
                "pending_jobs" => PendingJob::uncommitted()->withNameClass('recipient')->get()
            ]
        );
    }
}
