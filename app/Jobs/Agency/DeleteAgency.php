<?php

namespace App\Jobs\Agency;

use App\Repository\AgencyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteAgency implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $agency_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $agency_id)
    {
        $this->agency_id = $agency_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AgencyRepository $repository)
    {
        $repository->destroy($this->agency_id);
    }
}
