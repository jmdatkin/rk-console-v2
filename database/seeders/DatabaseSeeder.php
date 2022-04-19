<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Recipient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Recipient::factory(144)->create();
        Driver::factory(80)->create();
    }
}
