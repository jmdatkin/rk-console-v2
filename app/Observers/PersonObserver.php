<?php

namespace App\Observers;

use App\Jobs\SchedulePendingJob;
use App\Models\Person;
use Facades\App\Facade\Settings;
use Illuminate\Support\Facades\Log;

class PersonObserver
{
    /**
     * Handle the Person "created" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function created(Person $person)
    {
        //
    }

    /**
     * Handle the Person "updated" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function updated(Person $person)
    {
        //
    }

    /**
     * Handle the Person "updating" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function updating(Person $person)
    {
        //
        if (!Settings::appIsLocked())
            return true;

        SchedulePendingJob::dispatchSync('person:update', [$person->id, $person->getDirty()]);
    }

    /**
     * Handle the Person "deleted" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function deleted(Person $person)
    {
        //
    }

    /**
     * Handle the Person "restored" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function restored(Person $person)
    {
        //
    }

    /**
     * Handle the Person "force deleted" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function forceDeleted(Person $person)
    {
        //
    }
}
