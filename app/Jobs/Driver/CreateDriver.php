<?php

namespace App\Jobs\Driver;

use App\Repository\DriverRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $attr)
    {
        //
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DriverRepositoryInterface $repository)
    {
        $repository->create($this->attr);
    }
}
