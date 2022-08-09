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
        //
        Setting::create([
            'key' => 'lock_in_time',
            'value' => RkCarbon::parse('5pm friday')
        ]);

        Setting::create([
            'key' => 'lock_out_time',
            'value' => RkCarbon::parse('8am monday')
        ]);
    }
}
