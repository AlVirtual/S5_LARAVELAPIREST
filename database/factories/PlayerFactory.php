<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use App\Models\User;

class PlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model
     *
     * @return string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $winshots = rand(1,50);
        $loseshots = rand(1,50);
        $totalshots = $winshots+$loseshots;
        $percent = ($winshots*100/$totalshots);


        return [
            'name' => $this->faker->name(),
            'winshots' => $winshots,
            'loseshots' => $loseshots,
            'totalshots' => $totalshots,
            'percent' => $percent,
            'user_id' => User::all()->random()->id

            
        ];
    }
}
