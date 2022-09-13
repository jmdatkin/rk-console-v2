<?php

namespace App\Jobs;

use App\Repository\RouteRepository;
use App\Services\AssignmentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignDriverToRoute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $route_id;
    public int $driver_id;
    public int $weekday;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $driver_id, int $route_id, int $weekday)
    {
        $this->driver_id = $driver_id;
        $this->route_id = $route_id;
        $this->weekday = $weekday;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AssignmentService $service)
    {
        $service->assign_driver(
            $this->route_id,
            $this->driver_id,
            $this->weekday
        );
    }
}
