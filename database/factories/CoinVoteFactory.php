<?php

namespace Database\Factories;

use App\Models\CoinVote;
use App\Models\Coin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class CoinVoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CoinVote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'coin_id' => Coin::all()->random()->id,
			'user_id' => User::all()->random()->id,
			'ip_address' => $this->faker->ipv4(),
			'user_agent' => $this->faker->userAgent(),
        ];
    }
}
