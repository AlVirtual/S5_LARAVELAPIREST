<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Shot;
use App\Models\Player;

class ShotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model
     *
     * @return string
     */
    protected $model = Shot::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $result = (($dice1 + $dice2) == 7) ? true : false;
        $total = $dice1 + $dice2;
        return [
            'dice1' => $dice1,
            'dice2' => $dice2,
            'result' => $result,
            'total' => $total,
            'player_id' => Player::all()->random()->id
        ];
    }
}
