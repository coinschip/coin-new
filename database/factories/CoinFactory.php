<?php

namespace Database\Factories;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class CoinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'name' => $this->faker->word(),
			'symbol'=> $this->faker->lexify(),
			'price' => $this->faker->randomFloat(),
			'yesterday' => $this->faker->randomFloat(),
			'capital' => $this->faker->randomNumber(5, false),
			'launched_at' => $this->faker->dateTimeThisYear('+6 months'),
			'user_id' => User::all()->random()->id,
        ];
    }
}
