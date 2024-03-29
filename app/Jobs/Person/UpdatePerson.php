<?php

namespace App\Jobs\Person;

use App\Repository\PersonRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $person_id;
    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $person_id, array $attr)
    {
        $this->person_id = $person_id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepository $repository)
    {
        $repository->update($this->person_id, $this->attr);
    }
}
