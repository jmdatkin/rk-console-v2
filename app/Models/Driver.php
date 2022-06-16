<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends BasePersonRole
{
    use HasFactory;

    protected $fillable = [''];

    protected $touches = ['person'];

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function getSubAttribute() {
        return $this->exceptions()->whereHas('substituteDriver')->get()->sortBy('length')->first()->substituteDriver;
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'driver_route')->withPivot(['weekday']);
    }

    public function alternateRoutes() {
        return $this->belongsToMany(Route::class, 'driver_route_alt');
    }

    public function assignRoute($route_id, $weekday)
    {
        try {
            $this->routes()->attach($route_id, [ "weekday" => $weekday ]);
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function exceptions() {
        return $this->hasMany(DriverException::class, 'driver_id');
    }

    public function deassignRoute($route_id, $weekday)
    {
        try {
            $this->routes()->wherePivot('weekday',$weekday)->detach($route_id);
        } catch (Exception $e) {
            error_log($e);
        }
    }
}
