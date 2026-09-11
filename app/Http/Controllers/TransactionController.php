<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'type', 'category_id', 'start_date', 'end_date']);

        $query = Transaction::with('category')->filter($filters);

        // Calculate totals for currently filtered dataset
        $filteredIncome = (clone $query)->income()->sum('amount');
        $filteredExpense = (clone $query)->expense()->sum('amount');
        $filteredNet = $filteredIncome - $filteredExpense;

        $transactions = $query
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('transactions.index', [
            'transactions' => $transactions,
            'categories' => $categories,
            'filters' => $filters,
            'filteredIncome' => $filteredIncome,
            'filteredExpense' => $filteredExpense,
            'filteredNet' => $filteredNet,
        ]);
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create(): View
    {
        $incomeCategories = Category::income()->orderBy('name')->get();
        $expenseCategories = Category::expense()->orderBy('name')->get();

        return view('transactions.create', [
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['receipt']);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $data['receipt_path'] = $path;
        }

        Transaction::create($data);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction): View
    {
        $incomeCategories = Category::income()->orderBy('name')->get();
        $expenseCategories = Category::expense()->orderBy('name')->get();

        return view('transactions.edit', [
            'transaction' => $transaction,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $data = $request->safe()->except(['receipt', 'remove_receipt']);

        if ($request->boolean('remove_receipt')) {
            if ($transaction->receipt_path && Storage::disk('public')->exists($transaction->receipt_path)) {
                Storage::disk('public')->delete($transaction->receipt_path);
            }
            $data['receipt_path'] = null;
        }

        if ($request->hasFile('receipt')) {
            if ($transaction->receipt_path && Storage::disk('public')->exists($transaction->receipt_path)) {
                Storage::disk('public')->delete($transaction->receipt_path);
            }
            $path = $request->file('receipt')->store('receipts', 'public');
            $data['receipt_path'] = $path;
        }

        $transaction->update($data);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        if ($transaction->receipt_path && Storage::disk('public')->exists($transaction->receipt_path)) {
            Storage::disk('public')->delete($transaction->receipt_path);
        }

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Export transactions to a CSV file.
     */
    public function export(Request $request): StreamedResponse
    {
        $filters = $request->only(['search', 'type', 'category_id', 'start_date', 'end_date']);

        $transactions = Transaction::with('category')
            ->filter($filters)
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        $filename = 'transaksi_'.now()->format('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($handle, [
                'ID',
                'Tanggal',
                'Tipe',
                'Kategori',
                'Keterangan',
                'Catatan',
                'Nominal (IDR)',
                'Ada Bukti Struk',
            ]);

            foreach ($transactions as $tx) {
                fputcsv($handle, [
                    $tx->id,
                    $tx->transaction_date->format('Y-m-d'),
                    $tx->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $tx->category?->name ?? '-',
                    $tx->description,
                    $tx->notes ?? '-',
                    $tx->amount,
                    $tx->receipt_path ? 'Ya' : 'Tidak',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
