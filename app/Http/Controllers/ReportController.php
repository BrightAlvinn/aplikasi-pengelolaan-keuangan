<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display financial reports and analytics for a selected period.
     */
    public function index(Request $request): View
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $month = (int) $request->input('month', Carbon::now()->month);

        $selectedDate = Carbon::createFromDate($year, $month, 1);
        $startOfMonth = $selectedDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $selectedDate->copy()->endOfMonth()->toDateString();

        // Period totals
        $periodIncome = (float) Transaction::income()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $periodExpense = (float) Transaction::expense()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $periodNet = $periodIncome - $periodExpense;
        $savingsRate = $periodIncome > 0 ? round(($periodNet / $periodIncome) * 100, 1) : 0;

        // Breakdown expenses by category
        $expenseCategories = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(id) as transaction_count'))
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($periodExpense) {
                $percentage = $periodExpense > 0 ? round(($item->total_amount / $periodExpense) * 100, 1) : 0;

                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#ef4444',
                    'count' => $item->transaction_count,
                    'amount' => (float) $item->total_amount,
                    'percentage' => $percentage,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // Breakdown income by category
        $incomeCategories = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(id) as transaction_count'))
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($periodIncome) {
                $percentage = $periodIncome > 0 ? round(($item->total_amount / $periodIncome) * 100, 1) : 0;

                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#10b981',
                    'count' => $item->transaction_count,
                    'amount' => (float) $item->total_amount,
                    'percentage' => $percentage,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // Daily breakdown for line chart
        $daysInMonth = $selectedDate->daysInMonth;
        $dailyLabels = [];
        $dailyIncome = [];
        $dailyExpense = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDayDate = Carbon::createFromDate($year, $month, $day)->toDateString();
            $dailyLabels[] = (string) $day;

            $dailyIncome[] = (float) Transaction::income()
                ->whereDate('transaction_date', $currentDayDate)
                ->sum('amount');

            $dailyExpense[] = (float) Transaction::expense()
                ->whereDate('transaction_date', $currentDayDate)
                ->sum('amount');
        }

        // Available years for dropdown
        $earliestYear = Transaction::min('transaction_date');
        $minYear = $earliestYear ? Carbon::parse($earliestYear)->year : Carbon::now()->year;
        $maxYear = Carbon::now()->year;
        $availableYears = range(max($minYear, $maxYear - 5), $maxYear);

        return view('reports.index', [
            'year' => $year,
            'month' => $month,
            'selectedDate' => $selectedDate,
            'periodIncome' => $periodIncome,
            'periodExpense' => $periodExpense,
            'periodNet' => $periodNet,
            'savingsRate' => $savingsRate,
            'expenseCategories' => $expenseCategories,
            'incomeCategories' => $incomeCategories,
            'dailyLabels' => $dailyLabels,
            'dailyIncome' => $dailyIncome,
            'dailyExpense' => $dailyExpense,
            'availableYears' => $availableYears,
        ]);
    }
}
