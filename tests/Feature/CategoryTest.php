<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_index_page_is_accessible(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->get(route('categories.index'));

        $response->assertOk();
        $response->assertViewIs('categories.index');
    }

    public function test_user_can_create_a_category(): void
    {
        $payload = [
            'name' => 'Investasi Saham',
            'type' => 'income',
            'color' => '#10b981',
            'icon' => 'trending-up',
        ];

        $response = $this->post(route('categories.store'), $payload);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Investasi Saham',
            'type' => 'income',
        ]);
    }

    public function test_category_validation_fails_for_invalid_data(): void
    {
        $response = $this->post(route('categories.store'), [
            'name' => '',
            'type' => 'invalid_type',
            'color' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'type', 'color']);
    }

    public function test_user_can_update_a_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Makan',
            'type' => 'expense',
        ]);

        $response = $this->put(route('categories.update', $category), [
            'name' => 'Makanan & Kuliner',
            'type' => 'expense',
            'color' => '#ef4444',
            'icon' => 'utensils',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Makanan & Kuliner',
        ]);
    }

    public function test_user_can_delete_unused_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_category_with_transactions(): void
    {
        $category = Category::factory()->create();
        Transaction::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
