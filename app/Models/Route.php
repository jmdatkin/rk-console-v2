<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Route extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

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

    public function driver($weekday) {
        return $this->drivers()->wherePivot('weekday', $weekday)->first();
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class)->withPivot('weekday');
    }

    public function substituteDrivers()
    {
        return $this->belongsToMany(Driver::class, 'driver_subs', 'route_id', 'sub_driver_id')->withPivot('date');
    }

    /**
     * Returns drivers linked to this route, with 
     */
    public function getDriversWithSubsAttribute() {
        return $this->drivers->map(function($driver) {
            if (is_null($driver->sub)) {
                return collect($driver)->merge([
                    'isSub' => false
                ]);
            } else {
                return collect($driver->sub)->merge([
                    'pivot' => $driver->pivot,  //Retain original route relation, only replace driver info
                    //Note: 'driver_id' in pivot will refer to original driver id
                    'isSub' => true
                ]);
            }
        });
    }

    public function getDriversWithSubs($date) {
        return $this->drivers->map(function($driver) use ($date) {
            if (is_null($driver->getSub($date))) {
                return collect($driver)->merge([
                    'isSub' => false
                ]);
            } else {
                return collect($driver->getSub($date))->merge([
                    'pivot' => $driver->pivot,  //Retain original route relation, only replace driver info
                    //Note: 'driver_id' in pivot will refer to original driver id
                    'isSub' => true
                ]);
            }
        });
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

    public function assignRecipient($recipient_id, $weekday)
    {
        $this->recipients()->attach($recipient_id, ['weekday' => $weekday]);
    }

    public function deassignRecipient($recipient_id, $weekday)
    {
        $this->recipients()->wherePivot('weekday', $weekday)->wherePivot('recipient_id', $recipient_id)->detach();
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
