<?php

namespace App\Jobs\Agency;

use App\Repository\AgencyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAgency implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $agency_id;
    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $agency_id, array $attr)
    {
        $this->agency_id = $agency_id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AgencyRepository $repository)
    {
        $repository->update($this->agency_id, $this->attr);
    }
}
