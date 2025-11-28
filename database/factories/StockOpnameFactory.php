<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockOpname>
 */
class StockOpnameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-2 months', 'now');
        $end   = (clone $start)->modify('+1 week');

        $endDate = $this->faker->optional()->dateTimeBetween($start, $end);

        return [
            'stock_take_name'       => $this->faker->sentence(3),
            'start_date'            => $start->format('Y-m-d H:i:s'),
            'end_date'              => $endDate ? $endDate->format('Y-m-d H:i:s') : null,
            'init_user'             => $this->faker->name(),
            'total_item_stocktaked' => $this->faker->numberBetween(0, 1000),
            'total_item_lost'       => $this->faker->numberBetween(0, 100),
            'total_item_exists'     => $this->faker->numberBetween(0, 1000),
            'total_item_loan'       => $this->faker->numberBetween(0, 500),
            'stock_take_users'      => $this->faker->words(5, true),
            'is_active'             => $this->faker->boolean(),
        ];
    }
}
