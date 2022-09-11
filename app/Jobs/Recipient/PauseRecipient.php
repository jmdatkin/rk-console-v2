<?php

namespace App\Jobs\Recipient;

use App\Repository\RecipientRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PauseRecipient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $recipient_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $recipient_id)
    {
        $this->recipient_id = $recipient_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RecipientRepository $repository)
    {
        $repository->find($this->recipient_id)->pause(); 
    }
}
