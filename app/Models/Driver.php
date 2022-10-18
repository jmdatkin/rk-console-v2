<?php

namespace App\Models;

use App\Traits\HasArchive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Driver extends BasePersonRole implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasArchive;

    protected $fillable = [''];

    protected $touches = ['person'];

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function subs() {
        return $this->hasMany(DriverSubPeriod::class, 'driver_id');
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'driver_route')->withPivot(['weekday']);
    }

    public function routesWithSubs() {
        return $this->routes()
        ->whereNotExists(function($query) {
            $query->select('driver_id')
            ->from('driver_subs')
            ->whereColumn('driver_subs.driver_id', '=', 'driver_id')
            ;
        });
    }

    public function alternateRoutes() {
        return $this->belongsToMany(Route::class, 'driver_route_alt');
    }
}
