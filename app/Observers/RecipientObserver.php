<?php

namespace App\Observers;

use App\Jobs\SchedulePendingJob;
use App\Models\Recipient;
use Facades\App\Facade\Settings;

class RecipientObserver
{
    /**
     * Handle the Recipient "created" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function created(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "updated" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function updated(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "updating" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function updating(Recipient $recipient)
    {
        if (!Settings::appIsLocked())
            return true;

        SchedulePendingJob::dispatchSync('recipient:update', [$recipient->id, $recipient->getDirty()]);
        return false;
    }

    /**
     * Handle the Recipient "deleted" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function deleted(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "restored" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function restored(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "force deleted" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function forceDeleted(Recipient $recipient)
    {
        //
    }
}
