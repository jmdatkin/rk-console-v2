<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\Role;
use App\Models\Route;
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
        Role::factory()->create([
            'name' => 'admin'
        ]);
        Role::factory()->create([
            'name' => 'driver'
        ]);
        Role::factory()->create([
            'name' => 'recipient'
        ]);
        // \App\Models\User::factory(10)->create();
        Person::factory(144)->create();
        // Recipient::factory(144)->create();
        // Driver::factory(80)->create();
        Route::factory(32)->create();
    }
}
