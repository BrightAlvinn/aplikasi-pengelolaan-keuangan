<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Income Categories
            [
                'name' => 'Gaji & Upah',
                'type' => 'income',
                'color' => '#10b981',
                'icon' => 'briefcase',
            ],
            [
                'name' => 'Bisnis & Penjualan',
                'type' => 'income',
                'color' => '#06b6d4',
                'icon' => 'shopping-cart',
            ],
            [
                'name' => 'Investasi & Dividen',
                'type' => 'income',
                'color' => '#3b82f6',
                'icon' => 'trending-up',
            ],
            [
                'name' => 'Freelance & Side Project',
                'type' => 'income',
                'color' => '#8b5cf6',
                'icon' => 'laptop',
            ],
            [
                'name' => 'Bonus & Hadiah',
                'type' => 'income',
                'color' => '#f59e0b',
                'icon' => 'award',
            ],

            // Expense Categories
            [
                'name' => 'Makanan & Minuman',
                'type' => 'expense',
                'color' => '#ef4444',
                'icon' => 'utensils',
            ],
            [
                'name' => 'Transportasi & Bensin',
                'type' => 'expense',
                'color' => '#f97316',
                'icon' => 'car',
            ],
            [
                'name' => 'Belanja & Kebutuhan Rumah',
                'type' => 'expense',
                'color' => '#ec4899',
                'icon' => 'shopping-bag',
            ],
            [
                'name' => 'Tagihan, Listrik & Air',
                'type' => 'expense',
                'color' => '#6366f1',
                'icon' => 'zap',
            ],
            [
                'name' => 'Hiburan & Liburan',
                'type' => 'expense',
                'color' => '#a855f7',
                'icon' => 'tv',
            ],
            [
                'name' => 'Kesehatan & Obat',
                'type' => 'expense',
                'color' => '#14b8a6',
                'icon' => 'activity',
            ],
            [
                'name' => 'Pendidikan & Buku',
                'type' => 'expense',
                'color' => '#0284c7',
                'icon' => 'book-open',
            ],
            [
                'name' => 'Sedekah & Donasi',
                'type' => 'expense',
                'color' => '#84cc16',
                'icon' => 'heart',
            ],
            [
                'name' => 'Lain-lain',
                'type' => 'expense',
                'color' => '#64748b',
                'icon' => 'more-horizontal',
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => $cat['type']],
                $cat
            );
        }
    }
}
