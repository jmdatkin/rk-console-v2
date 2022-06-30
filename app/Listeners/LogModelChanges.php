<?php

namespace App\Listeners;

use App\Models\DbMutation;
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
        
        $mutation = new DbMutation();
        $mutation->entity_id = $event->recipient->id;
        $mutation->entity_type = $event->recipient->getTable();
        $mutation->fields = implode(';',array_keys($dirty));
        $mutation->values = implode(';', array_values($dirty));
        $mutation->save();
        return false;
    }
}
