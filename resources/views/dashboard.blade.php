@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('header_title', 'Ringkasan Keuangan')
@section('header_subtitle', 'Pantauan saldo, arus kas bulanan, dan komposisi pengeluaran Anda')

@section('content')
<div class="space-y-8">
    <!-- Top Action Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-gradient-to-r from-slate-900 via-slate-900/90 to-emerald-950/40 border border-slate-800/80 shadow-2xl relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <h2 class="text-xl md:text-2xl font-extrabold text-white tracking-tight">Halo, Selamat Datang! 👋</h2>
            <p class="text-sm text-slate-400 mt-1">Saat ini tercatat total <span class="text-emerald-400 font-semibold">{{ $totalTransactionsCount }}</span> transaksi dalam sistem Anda.</p>
        </div>
        <div class="flex items-center gap-3 relative z-10 shrink-0">
            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="px-4 py-2.5 rounded-xl font-medium text-sm text-emerald-300 bg-emerald-950/60 hover:bg-emerald-900/60 border border-emerald-500/30 transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Pemasukan</span>
            </a>
            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="px-4 py-2.5 rounded-xl font-medium text-sm text-rose-300 bg-rose-950/60 hover:bg-rose-900/60 border border-rose-500/30 transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                </svg>
                <span>+ Pengeluaran</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Saldo -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Saldo Kas</span>
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-black {{ $totalBalance >= 0 ? 'text-white' : 'text-rose-400' }} tracking-tight">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[11px] font-medium px-2 py-0.5 rounded-full {{ $totalBalance >= 0 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                        {{ $totalBalance >= 0 ? 'Surplus Aktif' : 'Defisit Saldo' }}
                    </span>
                    <span class="text-xs text-slate-400">Akumulasi keseluruhan</span>
                </div>
            </div>
        </div>

        <!-- Pemasukan Bulan Ini -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pemasukan Bulan Ini</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-black text-emerald-400 tracking-tight">
                    Rp {{ number_format($thisMonthIncome, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                    <span class="text-emerald-400 font-semibold">Inflow</span>
                    <span>periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl relative overflow-hidden group hover:border-rose-500/40 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengeluaran Bulan Ini</span>
                <div class="w-10 h-10 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-black text-rose-400 tracking-tight">
                    Rp {{ number_format($thisMonthExpense, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                    <span class="text-rose-400 font-semibold">Outflow</span>
                    <span>periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Arus Kas Bersih Bulan Ini -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Arus Kas Bersih (Net)</span>
                <div class="w-10 h-10 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-black {{ $thisMonthNet >= 0 ? 'text-cyan-400' : 'text-amber-400' }} tracking-tight">
                    Rp {{ number_format($thisMonthNet, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[11px] font-medium px-2 py-0.5 rounded-full {{ $thisMonthNet >= 0 ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                        {{ $thisMonthNet >= 0 ? '+ Surplus Bulan Ini' : '- Pengeluaran Lebih Besar' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Charts Grid Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Cashflow Bar Chart (2 cols) -->
        <div class="lg:col-span-2 p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-white">Tren Arus Kas (6 Bulan Terakhir)</h3>
                    <p class="text-xs text-slate-400">Perbandingan pemasukan vs pengeluaran per bulan</p>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-emerald-500"></span>
                        <span class="text-slate-300">Pemasukan</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-rose-500"></span>
                        <span class="text-slate-300">Pengeluaran</span>
                    </div>
                </div>
            </div>
            <div class="h-72">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart Categories (1 col) -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Pengeluaran per Kategori</h3>
                <p class="text-xs text-slate-400">Distribusi pengeluaran bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
            </div>

            <div class="my-4 h-52 relative flex items-center justify-center">
                @if($categoryBreakdown->isEmpty())
                    <div class="text-center text-slate-500 text-xs">Belum ada data pengeluaran bulan ini.</div>
                @else
                    <canvas id="categoryChart"></canvas>
                @endif
            </div>

            <!-- Category Legend List -->
            <div class="space-y-2 max-h-36 overflow-y-auto pr-1">
                @forelse($categoryBreakdown as $cat)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 truncate">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $cat['color'] }}"></span>
                            <span class="text-slate-300 truncate">{{ $cat['name'] }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="font-semibold text-white">{{ $cat['percentage'] }}%</span>
                            <span class="text-slate-400 ml-1">({{ number_format($cat['amount'] / 1000, 0) }}k)</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-2">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-white">Transaksi Terkini</h3>
                <p class="text-xs text-slate-400">5 transaksi terakhir yang dicatat dalam sistem</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 flex items-center gap-1 group">
                <span>Lihat Semua Transaksi</span>
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-800/40 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4 font-semibold">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold">Kategori</th>
                        <th class="py-3.5 px-4 font-semibold">Keterangan</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Nominal</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Bukti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="py-3.5 px-4 text-xs text-slate-400 whitespace-nowrap">
                                {{ $tx->transaction_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $tx->category?->color ?? '#64748b' }}22; color: {{ $tx->category?->color ?? '#94a3b8' }}; border: 1px solid {{ $tx->category?->color ?? '#64748b' }}44;">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $tx->category?->color ?? '#94a3b8' }}"></span>
                                    {{ $tx->category?->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate text-white">
                                {{ $tx->description }}
                                @if($tx->notes)
                                    <span class="block text-xs text-slate-400 truncate">{{ $tx->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <span class="font-bold {{ $tx->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} {{ $tx->formatted_amount }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($tx->receipt_path)
                                    <a href="{{ $tx->receipt_url }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-800 text-slate-300 hover:text-emerald-400 hover:bg-slate-700 transition" title="Lihat Bukti">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-slate-600 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-500 text-xs">
                                Belum ada transaksi yang tercatat. Silakan tambah transaksi baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Monthly Bar Chart
        const ctxMonthly = document.getElementById('monthlyChart');
        if (ctxMonthly) {
            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: @json($monthlyChartLabels),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: @json($monthlyIncomeData),
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            barPercentage: 0.6,
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($monthlyExpenseData),
                            backgroundColor: '#ef4444',
                            borderRadius: 6,
                            barPercentage: 0.6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: '#1e293b' },
                            ticks: { color: '#94a3b8', font: { size: 11 } }
                        },
                        y: {
                            grid: { color: '#1e293b' },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + ' Jt';
                                    if (value >= 1000) return (value / 1000) + ' Rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Category Breakdown Donut Chart
        const ctxCategory = document.getElementById('categoryChart');
        if (ctxCategory) {
            const catData = @json($categoryBreakdown);
            if (catData && catData.length > 0) {
                new Chart(ctxCategory, {
                    type: 'doughnut',
                    data: {
                        labels: catData.map(c => c.name),
                        datasets: [{
                            data: catData.map(c => c.amount),
                            backgroundColor: catData.map(c => c.color),
                            borderWidth: 2,
                            borderColor: '#0f172a',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endpush
