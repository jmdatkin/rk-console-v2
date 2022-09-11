<?php

namespace App\Jobs;

use App\Models\PendingJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulePendingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $resource_type;
    public string $job_action;
    public int|null $resource_id;
    public array|null $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $resource_type, string $job_action, int|null $resource_id, array|null $payload)
    {
        $this->resource_type = $resource_type;
        $this->job_action = $job_action;
        $this->resource_id = $resource_id;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pending_job = new PendingJob();

        $pending_job->resource_type = $this->resource_type;
        $pending_job->job_action = $this->job_action;
        $pending_job->resource_id = $this->resource_id;
        $pending_job->payload = $this->payload;

        $pending_job->save();
    }
}
