<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipientRoute extends Pivot
{
    //
    public $table = 'recipient_route';

    public static function getNextOrderingIndex($route_id, $weekday) {
        $records = self::where(['route_id' => $route_id, 'weekday' => $weekday]);
        //         ->max('driver_custom_order') + 1;
        if (!$records->exists())
            return 0;
        return $records->max('driver_custom_order') + 1;
    }
}
