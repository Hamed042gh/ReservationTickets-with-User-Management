<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'track_id' => $this->faker->unique()->word,
            'amount' => fake()->numberBetween(10000, 500000),
            'payer_name' => $this->faker->name,
            'payer_identity' => $this->faker->email,
            'status' => 'pending',
            'user_id' => User::factory(),
        ];
    }
}
