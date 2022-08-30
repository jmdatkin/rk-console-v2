<?php

namespace App\Models;

use App\Traits\HasArchive;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipientRoute extends Pivot
{
    use HasArchive;
    //
    public $table = 'recipient_route';

    public static function getNextOrderingIndex($route_id, $weekday) {
        return (int)self::where(['route_id' => $route_id, 'weekday' => $weekday])
        ->max('order_in_route') + 1;
    }
}
