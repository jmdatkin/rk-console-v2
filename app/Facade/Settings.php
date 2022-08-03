<?php

namespace App\Facade;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Facades\App\Facade\UserSettings;

class Settings
{
    public function __construct(UserSettings $userSettings)
    {
        $this->userSettings = $userSettings;
    }

    public function get($key)
    {
        if (is_array($key)) {

            // array_map(function ($k) {
            //     return Cache::remember($k, 2000, function () use ($k) {
            //         return Setting::where('key', $k)->get();
            //     });
            // }, $key);
            return Cache::remember($key, 2000, function () use ($key) {
                return Setting::whereIn('key', $key)->get();
            });
        } else {

            return Cache::remember($key, 2000, function () use ($key) {
                return Setting::where('key', $key)->get()->value;
            });
        }
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $values = array_map(function ($k, $v) {
                return [
                    'key' => $k,
                    'value' => $v
                ];
            }, array_keys($key), array_values($key));
            Setting::upsert($values, ['id'], ['value']);
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

    public function user()
    {
        return $this->userSettings;
    }
}
