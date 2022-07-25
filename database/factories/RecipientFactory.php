<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipient>
 */
class RecipientFactory extends Factory
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
            'agency_id' => Agency::all()->random()->id,
            'numMeals' => $this->faker->numberBetween(2,52),
            'address' => $this->faker->address(),
            'paused' => false//(bool)(rand(0,1) == 1)
        ];
    }
}
