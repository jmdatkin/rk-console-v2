<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes'
    ];

    public function recipients()
    {
        return $this->belongsToMany(Recipient::class)->withPivot('weekday');
    }

    public function recipientsOnDay($weekday)
    {
        return $this->belongsToMany(Recipient::class)->wherePivot('weekday', $weekday);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class)->withPivot('weekday');
    }

    public function driversWithSubs()
    {
        $drivers = $this->drivers;
        $merged_drivers = $drivers->map(function ($driver) {
            $carbon_day = Carbon::parse($driver->pivot->weekday . ' this week');
            $subs = DriverRouteSub::covers($carbon_day)->replacesDriver($driver->id)->get();
            if ($subs->isNotEmpty())
                return $subs;
            return $driver;
        });

        return $merged_drivers;
    }

    public function driverHistory()
    {
        return $this->belongsToMany(Driver::class, 'driver_route_history');
    }

    public function assignDriver($driver_id, $weekday)
    {
        $this->drivers()->attach($driver_id, ['weekday' => $weekday]);
    }

    public function deassignDriver($weekday)
    {
        $this->drivers()->wherePivot('weekday', $weekday)->detach();
    }

    // public function driversOnDay($date)
    // {
    //     $carbon_date = Carbon::parse($date);
    //     if ($carbon_date->isBefore(Carbon::today()->startOfWeek())) {
    //         return $this->belongsToMany(Driver::class, 'driver_route_history')->wherePivot('date', $carbon_date);
    //     } else {
    //         return $this->belongsToMany(Driver::class, 'driver_route')->wherePivot('weekday', strtolower($carbon_date->shortDayName));
    //     }
    // }

    public function driverAlternates()
    {
        return $this->belongsToMany(Driver::class, 'driver_route_alt');
    }


    public function driversOnDay()
    {
        return $this->belongsToMany(Driver::class, 'driver_route');
    }

    public function driversOnDayHistory()
    {
        return $this->belongsToMany(Driver::class, 'driver_route_history');
    }

    public function scopeWithDrivers($query, $date)
    {
        $carbon_date = Carbon::parse($date);
        return $query
            ->when(
                $carbon_date->isBefore(Carbon::today()->startOfWeek()),
                function ($query) use ($carbon_date) {
                    $query->with([
                        'driversOnDayHistory' => function ($query) use ($carbon_date) {
                            $query->wherePivot('date', $carbon_date);
                        }
                    ]);
                },
                function ($query) use ($carbon_date) {
                    $query->with([
                        'driversOnDay' => function ($query) use ($carbon_date) {
                            $query->wherePivot('weekday', strtolower($carbon_date->shortDayName));
                        }
                    ]);
                }
            );
    }
}
