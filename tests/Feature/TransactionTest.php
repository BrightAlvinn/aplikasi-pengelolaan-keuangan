<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_is_accessible_and_shows_metrics(): void
    {
        $incomeCat = Category::factory()->income()->create();
        $expenseCat = Category::factory()->expense()->create();

        Transaction::factory()->create([
            'category_id' => $incomeCat->id,
            'type' => 'income',
            'amount' => 10000000,
            'transaction_date' => now()->toDateString(),
        ]);

        Transaction::factory()->create([
            'category_id' => $expenseCat->id,
            'type' => 'expense',
            'amount' => 3000000,
            'transaction_date' => now()->toDateString(),
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertViewHas('totalBalance', 7000000);
        $response->assertViewHas('thisMonthIncome', 10000000);
        $response->assertViewHas('thisMonthExpense', 3000000);
    }

    public function test_transactions_index_page_displays_list(): void
    {
        $cat = Category::factory()->income()->create(['name' => 'Gaji Pokok']);
        $tx = Transaction::factory()->create([
            'category_id' => $cat->id,
            'description' => 'Transfer Gaji Kantor',
        ]);

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertViewIs('transactions.index');
        $response->assertSee('Transfer Gaji Kantor');
    }

    public function test_transactions_filter_by_type(): void
    {
        $catIncome = Category::factory()->income()->create();
        $catExpense = Category::factory()->expense()->create();

        Transaction::factory()->create([
            'category_id' => $catIncome->id,
            'type' => 'income',
            'description' => 'Pendapatan Bonus',
        ]);

        Transaction::factory()->create([
            'category_id' => $catExpense->id,
            'type' => 'expense',
            'description' => 'Bayar Tagihan Listrik',
        ]);

        $response = $this->get(route('transactions.index', ['type' => 'income']));

        $response->assertOk();
        $response->assertSee('Pendapatan Bonus');
        $response->assertDontSee('Bayar Tagihan Listrik');
    }

    public function test_user_can_create_a_transaction_with_receipt_upload(): void
    {
        Storage::fake('public');

        $category = Category::factory()->expense()->create();
        $file = UploadedFile::fake()->image('struk_belanja.jpg');

        $payload = [
            'type' => 'expense',
            'category_id' => $category->id,
            'amount' => 250000,
            'transaction_date' => '2026-09-10',
            'description' => 'Belanja Supermarket',
            'notes' => 'Beli sabun dan deterjen',
            'receipt' => $file,
        ];

        $response = $this->post(route('transactions.store'), $payload);

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseHas('transactions', [
            'description' => 'Belanja Supermarket',
            'amount' => 250000,
        ]);

        $transaction = Transaction::where('description', 'Belanja Supermarket')->first();
        $this->assertNotNull($transaction->receipt_path);
        Storage::disk('public')->assertExists($transaction->receipt_path);
    }

    public function test_transaction_validation_rules(): void
    {
        $response = $this->post(route('transactions.store'), [
            'type' => 'invalid_type',
            'category_id' => 99999,
            'amount' => -100,
            'transaction_date' => 'not-a-date',
            'description' => '',
        ]);

        $response->assertSessionHasErrors([
            'type',
            'category_id',
            'amount',
            'transaction_date',
            'description',
        ]);
    }

    public function test_user_can_update_a_transaction_and_remove_receipt(): void
    {
        Storage::fake('public');

        $category = Category::factory()->expense()->create();
        $fakePath = 'receipts/test_struk.jpg';
        Storage::disk('public')->put($fakePath, 'dummy content');

        $transaction = Transaction::factory()->create([
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 150000,
            'receipt_path' => $fakePath,
        ]);

        $response = $this->put(route('transactions.update', $transaction), [
            'type' => 'expense',
            'category_id' => $category->id,
            'amount' => 200000,
            'transaction_date' => '2026-09-10',
            'description' => 'Belanja Supermarket Revisi',
            'remove_receipt' => 1,
        ]);

        $response->assertRedirect(route('transactions.index'));
        $transaction->refresh();

        $this->assertEquals(200000, (float) $transaction->amount);
        $this->assertEquals('Belanja Supermarket Revisi', $transaction->description);
        $this->assertNull($transaction->receipt_path);
        Storage::disk('public')->assertMissing($fakePath);
    }

    public function test_user_can_delete_a_transaction(): void
    {
        Storage::fake('public');

        $category = Category::factory()->expense()->create();
        $fakePath = 'receipts/delete_me.jpg';
        Storage::disk('public')->put($fakePath, 'dummy file');

        $transaction = Transaction::factory()->create([
            'category_id' => $category->id,
            'receipt_path' => $fakePath,
        ]);

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
        Storage::disk('public')->assertMissing($fakePath);
    }

    public function test_user_can_export_transactions_csv(): void
    {
        $category = Category::factory()->income()->create(['name' => 'Bonus Kantor']);
        Transaction::factory()->create([
            'category_id' => $category->id,
            'description' => 'Bonus Tahunan 2026',
            'amount' => 5000000,
        ]);

        $response = $this->get(route('transactions.export'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Bonus Tahunan 2026', $response->streamedContent());
    }

    public function test_reports_page_is_accessible(): void
    {
        $response = $this->get(route('reports.index'));

        $response->assertOk();
        $response->assertViewIs('reports.index');
        $response->assertViewHas(['periodIncome', 'periodExpense', 'savingsRate']);
    }
}
