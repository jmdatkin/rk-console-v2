<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogModelChanges
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $dirty = $event->recipient->getDirty();
        DB::table('db_mutations')->insert([
            'entity_id' => $event->recipient->id,
            'entity_type' => $event->recipient->getTable(),
            'fields' => implode(';',array_keys($dirty)),
            'values' => implode(';', array_values($dirty))
        ]);
        return false;
        // dd($event);
    }
}
