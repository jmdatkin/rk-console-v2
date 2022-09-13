<?php

namespace App\Facade;

use App\Carbon\RkCarbon;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Facades\App\Facade\UserSettings;

class Settings
{

    // protected $mutators = [
    //     'lock_in_time' => function ($value) {
    //         $date_value = RkCarbon::parse('value');

    //         $day = $date_value->weekday();
    //         $hour = $date_value->hour();
    //         $minute = $date_value->minute();

    //         return RkCarbon::today()->weekday($day)
    //             ->hour($hour)
    //             ->minute($minute);
    //     },
    //     'lock_in_time' => function ($value) {
    //         $date_value = RkCarbon::parse('value');

    //         $day = $date_value->weekday();
    //         $hour = $date_value->hour();
    //         $minute = $date_value->minute();

    //         return RkCarbon::today()->weekday($day)
    //             ->hour($hour)
    //             ->minute($minute);
    //     },
    // ];

    public function __construct(UserSettings $userSettings)
    {
        $this->userSettings = $userSettings;
    }

    private function cast($value, $type)
    {
        switch ($type) {
            case 'number':
                return (int)$value;
            case 'string':
                return (string)$value;
            case 'date':
                return RkCarbon::parse($value);
            default:
                return $value;
        }
    }

    private function getTypeForKey($key)
    {
        return Setting::where('key', $key)->first()->type;
    }

    public function get($key = null)
    {
        if (is_null($key)) {
            return Setting::all()->map(function ($setting) {
                return [
                    'key' => $setting->key,
                    'value' => $this->cast($setting->value, $setting->type)
                ];
            });
        } else if (is_array($key)) {
            return Setting::whereIn('key', $key)->get()->map(function ($setting) {
                return [
                    'key' => $setting->key,
                    'value' => $this->cast($setting->value, $setting->type)
                ];
            });
        } else {
            $setting = Setting::where('key', $key)->first();
            return $this->cast($setting->value, $setting->type);
        }
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $values = array_values(array_map(function ($k, $v) {
                return [
                    'key' => $k,
                    'value' => $this->cast($v, $this->getTypeForKey($k))
                ];
            }, array_keys($key), array_values($key)));
            try {
                Setting::upsert($values, ['key'], ['value']);
            } catch (QueryException $e) {
            }
            return true;
        } else {

            $setting = Setting::where('key', $key)->first();

            if ($setting == null) {
                $new_setting = new Setting();

                $new_setting->key = $key;
                $new_setting->value = $this->cast($value, $this->getTypeForKey($key));

                $new_setting->save();
                return true;
            }

            $setting->value = $this->cast($value, $setting->type);
            $setting->save();
            return true;
        }
    }

    public function appIsLocked($now = null)
    {

        if (is_null($now))
            $now = RkCarbon::now();

        $lockInTime = $this->get('lock_in_time');
        $lockInTimeValues = explode(':',$lockInTime);

        $lockInDay = $this->get('lock_in_day');
        $lockInHour = $lockInTimeValues[0];
        $lockInMinute = $lockInTimeValues[1];

        $lockIn = RkCarbon::today()
            ->weekday($lockInDay)
            ->hour($lockInHour)
            ->minute($lockInMinute);

        $lockOutTime = $this->get('lock_out_time');
        $lockOutTimeValues = explode(':',$lockOutTime);

        $lockOutDay = $this->get('lock_out_day');
        $lockOutHour = $lockOutTimeValues[0];
        $lockOutMinute = $lockOutTimeValues[1];

        $lockOut = RkCarbon::today()
            ->weekday($lockOutDay)
            ->hour($lockOutHour)
            ->minute($lockOutMinute);
 
        // If lock out day before lock in day, set to following week
        if ($lockInDay >= $lockOutDay)
            $lockOut->addWeek(1);

        // dd($lockIn, $lockOut);

        return $now->greaterThan($lockIn) && $now->lessThan($lockOut);
        // return true;
    }

    public function user()
    {
        return $this->userSettings;
    }
}
