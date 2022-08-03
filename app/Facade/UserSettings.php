<?php

namespace App\Facade;

use App\Models\UserSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserSettings
{
    public function __construct()
    {
        $this->user = Auth::user();
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
                return UserSetting::whereIn('key', $key)->get();
            });
        } else {

            return Cache::remember($key, 2000, function () use ($key) {
                return UserSetting::where('key', $key)->get()->value;
            });
        }
        // return UserSetting::where('user_id', $this->user->id)->where('key', $key)->first()->value;
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $values = array_map(function ($k, $v) {
                return [
                    'key' => $k,
                    'value' => $v,
                    'user_id' => $this->user->id
                ];
            }, array_keys($key), array_values($key));
            UserSetting::upsert(
                // $values + ['user_id' => $this->user->id],
                $values,
                // array_merge($values, ['user_id' => $this->user->id]),
                ['key'], ['value']
            );
            return true;
        } else {

            $setting = UserSetting::where('user_id', $this->user->id)->where('key', $key)->first();

            if ($setting == null) {
                $new_setting = new UserSetting();

                $new_setting->user_id = $this->user->id;
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
}
