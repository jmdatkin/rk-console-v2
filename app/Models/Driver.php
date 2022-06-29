<?php

namespace App\Models;

use App\Carbon\RkCarbon;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends BasePersonRole
{
    use HasFactory;

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
        $exceptions = $this->exceptions()->with(['substitutes' => function($query) {
            $query->whereDate('');
        }]);
    }

    /**
     * All drivers currently replacing this driver
     */
    // public function driverExceptionsSubbedBy() {
    //     return $this->hasManyThrough(DriverExceptionRoute::class, DriverException::class, 'driver_id', 'exception_id', 'id', 'id');
    //     // return $this->belongsToMany(DriverExceptionRoute::class, 'driver_exceptions', '')
    //     // ->as('exception');
    // }

    // public function getSubbedByAttribute() {
    //     return $this->driverExceptionsSubbedBy->load('substituteDriver');
    // }

    // /**
    //  * All drivers currently replaced by this driver
    //  */
    // public function driverExceptionsSubbing() {
    //     // return $this->belongsToMany(DriverException::class, 'driver_exception_route', 'driver_exception_id', 'substitute_driver_id')
    //     return $this->belongsToMany(DriverException::class, 'driver_exception_route', 'sub_id', 'e_id')
    //     ->using(DriverExceptionRoute::class)
    //     ->withPivot('route_id')
    //     ->as('exception');
    // }

    // public function getSubbingAttribute() {
    //     return $this->driverExceptionsSubbing;//->map(fn($row) => $row->exception->exception->load('driver'));
    // }

    // public function scopeWithSubbedBy($query, $date) {
    //     $carbon_date = Carbon::parse($date);
    //     $query->with([
    //         'subbedBy' => function($q) use ($carbon_date) {
    //             $q->contains($carbon_date);
    //         }
    //     ]);
    // }

    // public function scopeWithSubbing($query, $date) {
    //     $carbon_date = Carbon::parse($date);
    //     $query->with([
    //         'subbing' => function($q) use ($carbon_date) {
    //             $q->contains($carbon_date);
    //         }
    //     ]);
    // }

    // public function scopeWithSubs($query, $date) {
    //     $query->withSubbedBy($date)->withSubbing($date);
    // }

    // public function scopeContains($query, $date) {
    //     $query
    //     ->where('driver_exceptions.date_start', '<=', $date)
    //     ->where('driver_exceptions.date_end', '>', $date);
    // }

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
