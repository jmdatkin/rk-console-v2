<?php

namespace App\Jobs\Driver;

use App\Repository\DriverRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $driver_id;
    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $driver_id, array $attr)
    {
        $this->driver_id = $driver_id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DriverRepository $repository)
    {
        $repository->update($this->driver_id, $this->attr);
    }
}
