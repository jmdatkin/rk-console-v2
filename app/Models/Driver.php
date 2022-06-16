<?php

namespace App\Models;

use Carbon\Carbon;
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
        if ($this->exceptions->isEmpty()) return;
        $subs = $this->exceptions()->whereHas('substituteDriver')->get();
        
        if ($subs->isEmpty()) return;
        $firstSub = $subs->sortBy('length')->first();
        
        return $firstSub->substituteDriver;
        // if ($firstSub->contains)
        // ->substituteDriver;
        // return 'E';
    }

    public function getSub($date) {
        if ($this->exceptions->isEmpty()) return;
        $exceptions = $this->exceptions()->whereHas('substituteDriver')->get();
        
        if ($exceptions->isEmpty()) return;

        $exceptionsContainingDate = $exceptions->filter(function($exception) use ($date) {
            return $exception->contains(Carbon::parse($date));
        });

        if ($exceptionsContainingDate->isEmpty()) return;

        $firstException = $exceptionsContainingDate->sortBy('length')->first();
        
        return $firstException->substituteDriver;
        
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
