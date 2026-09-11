<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);

        return [
            'category_id' => Category::factory()->state(['type' => $type]),
            'type' => $type,
            'amount' => fake()->randomFloat(2, 10000, 2500000),
            'transaction_date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'description' => fake()->sentence(3),
            'notes' => fake()->boolean(60) ? fake()->paragraph(1) : null,
            'receipt_path' => null,
        ];
    }

    /**
     * Indicate that the transaction is income.
     */
    public function income(): static
    {
        return $this->state(fn () => [
            'type' => 'income',
            'category_id' => Category::factory()->income(),
            'amount' => fake()->randomFloat(2, 500000, 10000000),
        ]);
    }

    /**
     * Indicate that the transaction is expense.
     */
    public function expense(): static
    {
        return $this->state(fn () => [
            'type' => 'expense',
            'category_id' => Category::factory()->expense(),
            'amount' => fake()->randomFloat(2, 15000, 750000),
        ]);
    }
}
