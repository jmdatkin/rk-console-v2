<?php

namespace App\Jobs\Person;

use App\Repository\PersonRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeletePerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $person_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $person_id)
    {
        $this->person_id = $person_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepositoryInterface $repository)
    {
        $repository->destroy($this->person_id);
    }
}