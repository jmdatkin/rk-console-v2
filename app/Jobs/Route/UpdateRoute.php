<?php

namespace App\Jobs\Route;

use App\Repository\RouteRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRoute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $route_id;
    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $route_id, array $attr)
    {
        $this->route_id = $route_id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RouteRepository $repository)
    {
        $repository->update($this->route_id, $this->attr);
    }
}
