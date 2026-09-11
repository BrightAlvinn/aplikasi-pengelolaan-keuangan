<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard with financial metrics.
     */
    public function index(): View
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        // All-time totals
        $allIncome = (float) Transaction::income()->sum('amount');
        $allExpense = (float) Transaction::expense()->sum('amount');
        $totalBalance = $allIncome - $allExpense;

        // Current month totals
        $thisMonthIncome = (float) Transaction::income()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $thisMonthExpense = (float) Transaction::expense()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $thisMonthNet = $thisMonthIncome - $thisMonthExpense;

        // Last 6 months cash flow data for chart
        $monthlyChartLabels = [];
        $monthlyIncomeData = [];
        $monthlyExpenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth()->toDateString();
            $monthEnd = $date->copy()->endOfMonth()->toDateString();

            $monthlyChartLabels[] = $date->translatedFormat('M Y');
            $monthlyIncomeData[] = (float) Transaction::income()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
            $monthlyExpenseData[] = (float) Transaction::expense()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
        }

        // Category breakdown for current month (expenses)
        $categoryBreakdown = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($thisMonthExpense) {
                $percentage = $thisMonthExpense > 0 ? round(($item->total_amount / $thisMonthExpense) * 100, 1) : 0;

                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#94a3b8',
                    'amount' => (float) $item->total_amount,
                    'percentage' => $percentage,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // Recent 5 transactions with eager loaded category
        $recentTransactions = Transaction::with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();

        // Quick count of transactions
        $totalTransactionsCount = Transaction::count();

        return view('dashboard', [
            'totalBalance' => $totalBalance,
            'thisMonthIncome' => $thisMonthIncome,
            'thisMonthExpense' => $thisMonthExpense,
            'thisMonthNet' => $thisMonthNet,
            'monthlyChartLabels' => $monthlyChartLabels,
            'monthlyIncomeData' => $monthlyIncomeData,
            'monthlyExpenseData' => $monthlyExpenseData,
            'categoryBreakdown' => $categoryBreakdown,
            'recentTransactions' => $recentTransactions,
            'totalTransactionsCount' => $totalTransactionsCount,
        ]);
    }
}
