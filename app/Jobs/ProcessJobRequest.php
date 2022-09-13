<?php

namespace App\Jobs;

use Facades\App\Facade\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessJobRequest implements ShouldQueue
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
    // public function __construct(string $resource_type, string $job_action, ?int $resource_id, ?array $payload)
    public function __construct(string $resource_type, string $job_action, int|null $resource_id = null, array|null $payload = null)
    {
        $this->resource_type = $resource_type;
        $this->job_action = $job_action;
        $this->resource_id = $resource_id;
        $this->payload = $payload;
        $this->job_key = $resource_type . ':' . $job_action;
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
                $this->resource_type,
                $this->job_action,
                $this->resource_id,
                $this->payload
            );
        } else {
            // $jobClass = config('app.job_key_names')[$this->job_key];
            $jobClass = config('app.job_classes')[$this->resource_type][$this->job_action];

            // No id, e.g. create
            if (is_null($this->resource_id))
                $jobClass::dispatchSync(...$this->payload);

            // No payload, e.g. destroy
            else if (is_null($this->payload))
                $jobClass::dispatchSync($this->resource_id);

            else
                $jobClass::dispatchSync($this->resource_id, ...$this->payload);
        }
    }
}
