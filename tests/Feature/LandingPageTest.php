<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test landing page is accessible at the root URL.
     */
    public function test_landing_page_is_accessible_at_root_url(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('landing');
        $response->assertSee('FinTrack');
        $response->assertSee('Kalkulator Aturan Anggaran 50 / 30 / 20');
        $response->assertSee('Buka Dashboard');
    }

    /**
     * Test landing page is accessible via /landing route.
     */
    public function test_landing_page_is_accessible_at_landing_url(): void
    {
        $response = $this->get('/landing');

        $response->assertOk();
        $response->assertViewIs('landing');
    }

    /**
     * Test landing page displays dynamic counts when records exist.
     */
    public function test_landing_page_displays_counts_with_data(): void
    {
        $category = Category::factory()->create();
        Transaction::factory()->count(5)->create([
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('landing'));

        $response->assertOk();
        $response->assertViewHas('totalTransactionsCount', 5);
        $response->assertViewHas('totalCategoriesCount', 1);
    }

    /**
     * Test dashboard route is accessible and returns dashboard view.
     */
    public function test_dashboard_route_is_accessible(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}
