<?php

namespace App\Jobs\Recipient;

use App\Repository\RecipientRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRecipient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $recipient_id;
    public array $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $recipient_id, array $attr)
    {
        $this->recipient_id = $recipient_id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RecipientRepositoryInterface $repository)
    {
        $repository->update($this->recipient_id, $this->attr);
    }
}
