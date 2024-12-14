<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'status' => 0,
            'user_id' => User::factory(),
            'ticket_id' => Ticket::factory(),
            'reservation_date' => fake()->dateTimeBetween('+0 days', '+1 week')
        ];
    }
}
