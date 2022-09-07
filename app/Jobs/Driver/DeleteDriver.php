<?php

namespace App\Jobs\Driver;

use App\Repository\DriverRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $driver_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $driver_id)
    {
        $this->driver_id = $driver_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DriverRepository $repository)
    {
        $repository->destroy($this->driver_id);
    }
}
