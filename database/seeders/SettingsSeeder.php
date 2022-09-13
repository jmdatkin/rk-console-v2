<?php

namespace Database\Seeders;

use App\Carbon\RkCarbon;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('app.default_settings') as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value['value'],
                'type' => $value['type']
            ]);
        }
    }
}
