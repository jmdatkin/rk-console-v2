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
    public function __construct(UserSettings $userSettings)
    {
        $this->userSettings = $userSettings;
    }

    public function get($key = null)
    {
        if (is_null($key)) {
            return Setting::all();
        }
        else if (is_array($key)) {

            // array_map(function ($k) {
            //     return Cache::remember($k, 2000, function () use ($k) {
            //         return Setting::where('key', $k)->get();
            //     });
            // }, $key);
            // return Cache::remember($key, 2000, function () use ($key) {
                return Setting::whereIn('key', $key)->get();
            // });
        } else {
            // return Cache::remember($key, 2000, function () use ($key) {
                return Setting::where('key', $key)->first()->value;
            // });
        }
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $values = array_values(array_map(function ($k, $v) {
                return [
                    'key' => $k,
                    'value' => $v
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
                $new_setting->value = $value;

                $new_setting->save();
                return true;
            }

            $setting->value = $value;
            $setting->save();
            return true;
        }
    }

    public function appIsLocked($now = null) {

        if (is_null($now))
            $now = RkCarbon::now();

        $lockIn = RkCarbon::parse($this->get('lock_in_time'));
        $lockOut = RkCarbon::parse($this->get('lock_out_time'));

        $lockInDay = $lockIn->dayOfWeek;
        $lockInHour = $lockIn->hour;
        $lockInMinute = $lockIn->minute;

        $lockInThisWeek = RkCarbon::now()
        ->weekday($lockInDay)
        ->hour($lockInHour)
        ->minute($lockInMinute);

        $lockOutDay = $lockOut->dayOfWeek;
        $lockOutHour = $lockOut->hour;
        $lockOutMinute = $lockOut->minute;

        $lockOutThisWeek = RkCarbon::now()
        ->weekday($lockOutDay)
        ->hour($lockOutHour)
        ->minute($lockOutMinute);

        return $now->greaterThan($lockInThisWeek) && $now->lessThan($lockOutThisWeek);
        // return true;
    }

    public function user()
    {
        return $this->userSettings;
    }
}
