<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incomeCategories = Category::income()->get()->keyBy('name');
        $expenseCategories = Category::expense()->get()->keyBy('name');

        if ($incomeCategories->isEmpty() || $expenseCategories->isEmpty()) {
            return;
        }

        $now = Carbon::now();

        // Generate data for past 3 months
        for ($m = 2; $m >= 0; $m--) {
            $monthDate = $now->copy()->subMonths($m);

            // 1. Monthly Salary (around day 25 or 1)
            Transaction::create([
                'category_id' => $incomeCategories['Gaji & Upah']->id ?? $incomeCategories->first()->id,
                'type' => 'income',
                'amount' => 12500000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(24)->toDateString(),
                'description' => 'Gaji Pokok & Tunjangan Bulanan',
                'notes' => 'Transfer payroll kantor pusat',
            ]);

            // 2. Freelance / Side income
            Transaction::create([
                'category_id' => $incomeCategories['Freelance & Side Project']->id ?? $incomeCategories->first()->id,
                'type' => 'income',
                'amount' => 3500000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(12)->toDateString(),
                'description' => 'Pembayaran Projek Web Landing Page',
                'notes' => 'Pelunasan invoice termin 2',
            ]);

            // 3. Investment dividend
            Transaction::create([
                'category_id' => $incomeCategories['Investasi & Dividen']->id ?? $incomeCategories->first()->id,
                'type' => 'income',
                'amount' => 450000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(5)->toDateString(),
                'description' => 'Dividen Reksadana Pasar Uang',
                'notes' => 'Auto-reinvest',
            ]);

            // Expenses:
            // Electricity & Internet bill
            Transaction::create([
                'category_id' => $expenseCategories['Tagihan, Listrik & Air']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 780000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(4)->toDateString(),
                'description' => 'Token Listrik PLN & Internet Wi-Fi Rumah',
                'notes' => 'Paket 50 Mbps + token 500rb',
            ]);

            // Groceries / Supermarket
            Transaction::create([
                'category_id' => $expenseCategories['Belanja & Kebutuhan Rumah']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 1250000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(2)->toDateString(),
                'description' => 'Belanja Bulanan Supermarket',
                'notes' => 'Beras, minyak, sabun, dan kebutuhan dapur',
            ]);

            // Food & Drinks spread throughout the month
            $foodSamples = [
                ['Makan Siang Resto Bebek', 65000, 3],
                ['Kopi & Snack Meeting Kafe', 48000, 7],
                ['Belanja Sayur & Buah Segar', 120000, 9],
                ['Makan Malam Seafood Keluarga', 320000, 14],
                ['Kopi Susu Mingguan', 35000, 18],
                ['Order Makanan Online (Gojek/Grab)', 95000, 21],
            ];

            foreach ($foodSamples as [$desc, $amount, $dayOffset]) {
                Transaction::create([
                    'category_id' => $expenseCategories['Makanan & Minuman']->id ?? $expenseCategories->first()->id,
                    'type' => 'expense',
                    'amount' => $amount,
                    'transaction_date' => $monthDate->copy()->startOfMonth()->addDays($dayOffset)->toDateString(),
                    'description' => $desc,
                    'notes' => null,
                ]);
            }

            // Transport & Fuel
            Transaction::create([
                'category_id' => $expenseCategories['Transportasi & Bensin']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 300000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(6)->toDateString(),
                'description' => 'Isi Bensin Pertamax & Saldo E-Toll',
                'notes' => 'Bensin 250rb, Toll 50rb',
            ]);

            Transaction::create([
                'category_id' => $expenseCategories['Transportasi & Bensin']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 250000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(19)->toDateString(),
                'description' => 'Isi Bensin Motor & Mobil',
                'notes' => null,
            ]);

            // Entertainment
            Transaction::create([
                'category_id' => $expenseCategories['Hiburan & Liburan']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 180000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(15)->toDateString(),
                'description' => 'Tiket Bioskop & Langganan Streaming',
                'notes' => 'Cinema XXI 2 tiket + Netflix',
            ]);

            // Charity / Donation
            Transaction::create([
                'category_id' => $expenseCategories['Sedekah & Donasi']->id ?? $expenseCategories->first()->id,
                'type' => 'expense',
                'amount' => 500000,
                'transaction_date' => $monthDate->copy()->startOfMonth()->addDays(10)->toDateString(),
                'description' => 'Sedekah Subuh & Donasi Panti Asuhan',
                'notes' => 'Transfer via KitaBisa',
            ]);
        }
    }
}
