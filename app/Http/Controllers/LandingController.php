<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    /**
     * Display the FinTrack landing page.
     */
    public function index(): View
    {
        $totalTransactionsCount = Transaction::count();
        $totalCategoriesCount = Category::count();
        $sampleCategories = Category::query()->take(6)->get();

        return view('landing', [
            'totalTransactionsCount' => $totalTransactionsCount,
            'totalCategoriesCount' => $totalCategoriesCount,
            'sampleCategories' => $sampleCategories,
        ]);
    }
}
