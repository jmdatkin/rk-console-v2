<?php

namespace Database\Seeders;

use App\Carbon\RkCarbon;
use App\Models\Agency;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\RecipientRoute;
use App\Models\Role;
use App\Models\Route;
use App\Models\User;
use Illuminate\Support\Str;
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

        Agency::factory(10)->create();
        // \App\Models\User::factory(10)->create();
        Person::factory(144)->create();
        // Recipient::factory(144)->create();
        // Driver::factory(80)->create();
        Route::factory(32)->create();

        $me = Person::create([
            'email' => 'jatkindev@gmail.com',
            'firstName' => 'Julian',
        ]);
        $me->assignRole(Role::ADMIN);

        User::create([
            'person_id' => $me->id,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $me_driver = Person::create([
            'email' => 'jmd.atkin@gmail.com',
            'firstName' => 'Julian',
            'lastName' => 'Driver'
        ]);
        $me_driver->assignRole(Role::DRIVER);

        User::create([
            'person_id' => $me_driver->id,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        Driver::create([
            'person_id' => $me_driver->id
        ]);

        RecipientRoute::create([
            'recipient_id' => 1,
            'route_id' => 1,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 2,
            'route_id' => 1,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 3,
            'route_id' => 1,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 4,
            'route_id' => 1,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 5,
            'route_id' => 2,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 6,
            'route_id' => 2,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 7,
            'route_id' => 3,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);

        RecipientRoute::create([
            'recipient_id' => 8,
            'route_id' => 4,
            'weekday' => RkCarbon::today()->dayOfWeek
        ]);
    }
}
