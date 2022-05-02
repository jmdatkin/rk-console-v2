<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [''];

    protected $touches = ['person'];

    public function person() {
        return $this->belongsTo(Person::class);
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'driver_route')->withPivot(['weekday']);
    }

    public function routeExceptions() {
        return $this->belongsToMany(Route::class, 'driver_route_exception');
    }


    public function assignRoute($route_id, $weekday)
    {
        try {
            $this->routes()->attach($route_id, [ "weekday" => $weekday ]);
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function deassignRoute($route_id)
    {
        try {
            $this->routes()->deatch($route_id);
        } catch (Exception $e) {
            error_log($e);
        }
    }


    public function makeException($route_id, $date) {
        try {
            $this->routeExceptions()->attach($route_id, [ "date" => $date]);
        } catch (Exception $e) {
            error_log($e);
        }
    }
}
