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
        $provinces = [
            'Alborz', 'Ardabil', 'Bushehr', 'Chaharmahal and Bakhtiari', 'East Azerbaijan', 'Fars', 
            'Gilan', 'Golestan', 'Hamedan', 'Hormozgan', 'Ilam', 'Isfahan', 'Kerman', 'Kermanshah', 
            'Khuzestan', 'Kohgiluyeh and Boyer-Ahmad', 'Kurdistan', 'Lorestan', 'Markazi', 'Mazandaran', 
            'North Khorasan', 'Qazvin', 'Qom', 'Razavi Khorasan', 'Semnan', 'Sistan and Baluchestan', 
            'South Khorasan', 'Tehran', 'West Azerbaijan', 'Yazd', 'Zanjan'
        ];

        return [
            'origin' => $this->faker->randomElement($provinces),  // Randomly pick an origin province
            'destination' => $this->faker->randomElement($provinces),  // Randomly pick a destination province
            'departure_date' => $this->faker->dateTimeBetween('+0 days', '+1 week'),  // Random date between now and one week
            'amount' => $this->faker->numberBetween(10000, 500000),  // Random amount between 10,000 and 500,000
            'available_count' => $this->faker->numberBetween(1, 40),  // Random number between 1 and 40
        ];
    }
}
