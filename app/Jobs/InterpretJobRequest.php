<?php

namespace App\Jobs;

use Facades\App\Facade\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InterpretJobRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $job_name;
    public int $resource_id;
    public array $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($job_name, $resource_id, $payload)
    {
        $this->job_name = $job_name;
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
        if (Settings::appIsLocked()) {
            SchedulePendingJob::dispatchSync(
                $this->job_name,
                $this->resource_id,
                $this->payload
            );
        } else {
            $job_class = config('app.job_key_names')[$this->job_name];
            $job_class::dispatchSync(...$this->payload);
        }
    }
}
