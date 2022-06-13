<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRouteSub extends Model
{
    use HasFactory;

    protected $table = "driver_route_subs";

    protected $fillable = [
        'driver_id',
        'route_id',
        'date_start',
        'date_end',
    ];

    public function scopeCovers($query, $date) {
        return $query
        ->where('date_start', '<=', $date)
        ->where('date_end', '>', $date);
    }
}
