<?php

namespace App\Jobs;

use App\Repository\RouteRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignDriverToRoute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $driver_id;
    public int $route_id;
    public string $weekday;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $driver_id, int $route_id, string $weekday)
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
    public function handle(RouteRepository $repository)
    {
        $repository->find($this->route_id)->assignDriver($this->recipient_id, $this->weekday);
    }
}
