<?php

namespace App\Models;

use App\Carbon\RkCarbon;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Driver extends BasePersonRole implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [''];

    protected $touches = ['person'];

    public function person() {
        return $this->belongsTo(Person::class);
    }


    public function exceptions() {
        return $this->hasMany(DriverException::class, 'driver_id');
    }

    public function subbed($date) {
        $carbon_date = RkCarbon::parse($date);
        // $exceptions = $this->exceptions()->has('substitutes')->with(['substitutes' => function($query) use ($date) {
        $exceptions = $this->exceptions()->whereHas('substitutes', function($query) use ($date) {
            $query->whereDate('date', $date);
        });
        if ($exceptions->exists())
            return $exceptions->first()->substitutes;
        return $this;
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'driver_route')->withPivot(['weekday']);
    }

    public function routesWithSubs() {

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

    public function deassignRoute($route_id, $weekday)
    {
        try {
            $this->routes()->wherePivot('weekday',$weekday)->detach($route_id);
        } catch (Exception $e) {
            error_log($e);
        }
    }
}
