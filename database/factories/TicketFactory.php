<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'origin' => fake()->city(),
            'destination' => fake()->city(),
            'departure_date' => fake()->dateTimeBetween('+0 days', '+1 week'),
            'amount' => fake()->numberBetween(10000, 500000),
            'available_count' => fake()->numberBetween(1, 40),
        ];
    }
}
