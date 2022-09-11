<?php

namespace App\Jobs;

use App\Models\PendingJob;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SchedulePendingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $resource_type;
    public string $job_action;
    public int|null $resource_id;
    public array|null $payload;
    public string $schedule_type;
    public Carbon|null $schedule_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $resource_type,
        string $job_action,
        int|null $resource_id,
        array|null $payload,
        string $schedule_type = 'lock',
        $schedule_time = null
    ) {
        $this->resource_type = $resource_type;
        $this->job_action = $job_action;
        $this->resource_id = $resource_id;
        $this->payload = $payload;
        $this->schedule_type = $schedule_type;
        $this->schedule_time = $schedule_time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pending_job = new PendingJob();

        $pending_job->user_id = Auth::user()->id;
        $pending_job->resource_type = $this->resource_type;
        $pending_job->job_action = $this->job_action;
        $pending_job->resource_id = $this->resource_id;
        $pending_job->payload = $this->payload;
        $pending_job->schedule_type = $this->schedule_type;

        // Only pending jobs with schedule_type 'datetime' can have a schedule_time field
        if ($this->schedule_type == 'datetime')
            $pending_job->schedule_time = $this->schedule_time;
        else
            $pending_job->schedule_time = null;

        $pending_job->save();
    }
}
