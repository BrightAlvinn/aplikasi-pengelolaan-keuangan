<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => fake()->randomElement(['income', 'expense']),
            'color' => fake()->hexColor(),
            'icon' => 'tag',
        ];
    }

    /**
     * Indicate that the category is for income.
     */
    public function income(): static
    {
        return $this->state(fn () => [
            'type' => 'income',
            'color' => '#10b981',
        ]);
    }

    /**
     * Indicate that the category is for expense.
     */
    public function expense(): static
    {
        return $this->state(fn () => [
            'type' => 'expense',
            'color' => '#ef4444',
        ]);
    }
}
