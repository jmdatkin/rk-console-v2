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

    public string $job_name;
    public array $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $job_name, array $payload)
    {
        $this->job_name = $job_name;
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

        $pending_job->job_name = $this->job_name;
        $pending_job->payload = $this->payload;

        $pending_job->save();
    }
}
