<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            // 'role' => $this->faker->randomElement(['recipient','driver']),
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phoneHome' => $this->faker->phoneNumber(),
            'phoneCell' => $this->faker->phoneNumber(),
            'notes' => ''
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Person $person) {
            $role = Role::all()->random();
            $person->roles()->attach($role);
            switch ($role->name) {
                case "recipient":
                    $recipient = Recipient::factory()->make();
                    $recipient->person_id = $person->id;
                    $recipient->save();
                    break;

                case "driver":
                    $driver = Driver::factory()->make();
                    $driver->person_id = $person->id;
                    $driver->save();
                    break;
            }
        });
    }
}
