@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('header_title', 'Ringkasan Keuangan')
@section('header_subtitle', 'Pantauan saldo, arus kas bulanan, dan komposisi pengeluaran Anda')

@section('content')
<div class="space-y-8">
    <!-- Top Action Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm relative overflow-hidden transition-colors duration-300">
        <div class="absolute right-0 top-0 w-96 h-96 bg-[#4ABDAC]/10 rounded-full blur-3xl pointer-events-none -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#eaf7f5] dark:bg-teal-950/40 text-[#2e7e73] dark:text-[#4ABDAC] text-xs font-bold mb-2 border border-[#4ABDAC]/30">
                <span class="w-2 h-2 rounded-full bg-[#4ABDAC]"></span> CatatUang Dashboard
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white tracking-tight">Halo, Selamat Datang! 👋</h2>
            <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 font-normal">Saat ini tercatat total <span class="text-[#4ABDAC] font-bold">{{ $totalTransactionsCount }}</span> transaksi dalam sistem Anda.</p>
        </div>
        <div class="flex items-center gap-3 relative z-10 shrink-0">
            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn-catat-primary text-xs sm:text-sm py-2.5 px-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Pemasukan</span>
            </a>
            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn-catat-destructive text-xs sm:text-sm py-2.5 px-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                </svg>
                <span>+ Pengeluaran</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Saldo -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-[#4ABDAC] transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Saldo Kas</span>
                <div class="w-10 h-10 rounded-2xl bg-[#4ABDAC]/15 border border-[#4ABDAC]/30 flex items-center justify-center text-[#4ABDAC]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-bold font-heading {{ $totalBalance >= 0 ? 'text-slate-900 dark:text-white' : 'text-[#FC4A1A]' }} tracking-tight">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $totalBalance >= 0 ? 'bg-[#eaf7f5] dark:bg-teal-950/40 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30' : 'bg-[#fef0ec] dark:bg-rose-950/40 text-[#FC4A1A] border border-[#FC4A1A]/30' }}">
                        {{ $totalBalance >= 0 ? 'Surplus Aktif' : 'Defisit Saldo' }}
                    </span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Akumulasi keseluruhan</span>
                </div>
            </div>
        </div>

        <!-- Pemasukan Bulan Ini -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-[#4ABDAC] transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pemasukan Bulan Ini</span>
                <div class="w-10 h-10 rounded-2xl bg-[#4ABDAC]/15 border border-[#4ABDAC]/30 flex items-center justify-center text-[#4ABDAC]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-bold font-heading text-[#4ABDAC] tracking-tight">
                    Rp {{ number_format($thisMonthIncome, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span class="text-[#4ABDAC] font-bold">Inflow</span>
                    <span>periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-[#FC4A1A] transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pengeluaran Bulan Ini</span>
                <div class="w-10 h-10 rounded-2xl bg-[#FC4A1A]/15 border border-[#FC4A1A]/30 flex items-center justify-center text-[#FC4A1A]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-bold font-heading text-[#FC4A1A] tracking-tight">
                    Rp {{ number_format($thisMonthExpense, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span class="text-[#FC4A1A] font-bold">Outflow</span>
                    <span>periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Arus Kas Bersih Bulan Ini -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-[#F7B733] transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Arus Kas Bersih (Net)</span>
                <div class="w-10 h-10 rounded-2xl bg-[#F7B733]/20 border border-[#F7B733]/30 flex items-center justify-center text-[#b87b00] dark:text-[#F7B733]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl lg:text-3xl font-bold font-heading {{ $thisMonthNet >= 0 ? 'text-[#4ABDAC]' : 'text-[#FC4A1A]' }} tracking-tight">
                    Rp {{ number_format($thisMonthNet, 0, ',', '.') }}
                </p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $thisMonthNet >= 0 ? 'bg-[#eaf7f5] dark:bg-teal-950/40 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30' : 'bg-[#fef0ec] dark:bg-rose-950/40 text-[#FC4A1A] border border-[#FC4A1A]/30' }}">
                        {{ $thisMonthNet >= 0 ? '+ Surplus Bulan Ini' : '- Pengeluaran Lebih Besar' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Charts Grid Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Cashflow Bar Chart (2 cols) -->
        <div class="lg:col-span-2 p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm transition-colors duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Tren Arus Kas (6 Bulan Terakhir)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Perbandingan pemasukan vs pengeluaran per bulan</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-semibold">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-[#4ABDAC]"></span>
                        <span class="text-slate-600 dark:text-slate-300">Pemasukan</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-[#FC4A1A]"></span>
                        <span class="text-slate-600 dark:text-slate-300">Pengeluaran</span>
                    </div>
                </div>
            </div>
            <div class="h-72">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart Categories (1 col) -->
        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm flex flex-col justify-between transition-colors duration-300">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Pengeluaran per Kategori</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Distribusi pengeluaran bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
            </div>

            <div class="my-4 h-52 relative flex items-center justify-center">
                @if($categoryBreakdown->isEmpty())
                    <div class="text-center text-slate-400 dark:text-slate-500 text-xs font-medium">Belum ada data pengeluaran bulan ini.</div>
                @else
                    <canvas id="categoryChart"></canvas>
                @endif
            </div>

            <!-- Category Legend List -->
            <div class="space-y-2 max-h-36 overflow-y-auto pr-1">
                @forelse($categoryBreakdown as $cat)
                    <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg hover:bg-[#F8F9FB] dark:hover:bg-slate-800/60 transition">
                        <div class="flex items-center gap-2 truncate">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $cat['color'] }}"></span>
                            <span class="text-slate-700 dark:text-slate-300 font-semibold truncate">{{ $cat['name'] }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="font-bold text-slate-900 dark:text-white">{{ $cat['percentage'] }}%</span>
                            <span class="text-slate-400 dark:text-slate-500 ml-1">({{ number_format($cat['amount'] / 1000, 0) }}k)</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-2 font-medium">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm transition-colors duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Transaksi Terkini</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">5 transaksi terakhir yang dicatat dalam sistem</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-[#4ABDAC] hover:text-[#3ca092] flex items-center gap-1 group">
                <span>Lihat Semua Transaksi</span>
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="text-xs font-bold uppercase bg-[#F8F9FB] dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-[#DFDCE3] dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4 text-right">Nominal</th>
                        <th class="py-3.5 px-4 text-center">Bukti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DFDCE3]/60 dark:divide-slate-800 font-medium">
                    @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-[#F8F9FB] dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 px-4 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap font-semibold">
                                {{ $tx->transaction_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" style="background-color: {{ $tx->category?->color ?? '#64748b' }}18; color: {{ $tx->category?->color ?? '#475569' }}; border: 1px solid {{ $tx->category?->color ?? '#64748b' }}35;">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $tx->category?->color ?? '#475569' }}"></span>
                                    {{ $tx->category?->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate text-slate-800 dark:text-slate-200 font-semibold">
                                {{ $tx->description }}
                                @if($tx->notes)
                                    <span class="block text-xs text-slate-400 dark:text-slate-500 font-normal truncate">{{ $tx->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <span class="font-bold {{ $tx->type === 'income' ? 'text-[#4ABDAC]' : 'text-[#FC4A1A]' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} {{ $tx->formatted_amount }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($tx->receipt_path)
                                    <a href="{{ $tx->receipt_url }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] hover:border-[#4ABDAC] transition" title="Lihat Bukti">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600 text-xs font-semibold">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-400 dark:text-slate-500 text-xs font-medium">
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
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = () => document.documentElement.classList.contains('dark');
        const getChartTheme = () => ({
            grid: isDark() ? '#1e293b' : '#F1F0F4',
            tick: isDark() ? '#94a3b8' : '#64748b',
            tooltipBg: isDark() ? '#1e293b' : '#ffffff',
            tooltipTitle: isDark() ? '#f8fafc' : '#0f172a',
            tooltipBody: isDark() ? '#cbd5e1' : '#334155',
            tooltipBorder: isDark() ? '#334155' : '#DFDCE3',
            donutBorder: isDark() ? '#0f172a' : '#ffffff'
        });

        let themeColors = getChartTheme();

        // 1. Chart.js Monthly Cashflow Bar Chart
        const monthlyCtx = document.getElementById('monthlyChart');
        let monthlyChart = null;
        if (monthlyCtx) {
            monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyChartLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($monthlyIncomeData) !!},
                            backgroundColor: '#4ABDAC',
                            hoverBackgroundColor: '#3ca092',
                            borderRadius: 8,
                            barPercentage: 0.6,
                            categoryPercentage: 0.7,
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($monthlyExpenseData) !!},
                            backgroundColor: '#FC4A1A',
                            hoverBackgroundColor: '#e03b0d',
                            borderRadius: 8,
                            barPercentage: 0.6,
                            categoryPercentage: 0.7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: themeColors.tooltipBg,
                            titleColor: themeColors.tooltipTitle,
                            bodyColor: themeColors.tooltipBody,
                            borderColor: themeColors.tooltipBorder,
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: themeColors.tick, font: { family: 'Manrope', size: 11, weight: '600' } },
                            border: { display: false }
                        },
                        y: {
                            grid: { color: themeColors.grid },
                            ticks: {
                                color: themeColors.tick,
                                font: { family: 'Manrope', size: 11 },
                                callback: function(value) {
                                    return 'Rp ' + (value >= 1000000 ? (value / 1000000).toFixed(1) + 'M' : (value / 1000).toFixed(0) + 'k');
                                }
                            },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Chart.js Category Breakdown Doughnut Chart
        const catCtx = document.getElementById('categoryChart');
        let categoryChart = null;
        if (catCtx) {
            categoryChart = new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryBreakdown->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($categoryBreakdown->pluck('amount')) !!},
                        backgroundColor: {!! json_encode($categoryBreakdown->pluck('color')) !!},
                        borderColor: themeColors.donutBorder,
                        borderWidth: 3,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: themeColors.tooltipBg,
                            titleColor: themeColors.tooltipTitle,
                            bodyColor: themeColors.tooltipBody,
                            borderColor: themeColors.tooltipBorder,
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        // Re-render chart colors when theme changes
        window.addEventListener('themechanged', function () {
            const colors = getChartTheme();

            if (monthlyChart) {
                monthlyChart.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
                monthlyChart.options.plugins.tooltip.titleColor = colors.tooltipTitle;
                monthlyChart.options.plugins.tooltip.bodyColor = colors.tooltipBody;
                monthlyChart.options.plugins.tooltip.borderColor = colors.tooltipBorder;
                monthlyChart.options.scales.x.ticks.color = colors.tick;
                monthlyChart.options.scales.y.ticks.color = colors.tick;
                monthlyChart.options.scales.y.grid.color = colors.grid;
                monthlyChart.update();
            }

            if (categoryChart) {
                categoryChart.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
                categoryChart.options.plugins.tooltip.titleColor = colors.tooltipTitle;
                categoryChart.options.plugins.tooltip.bodyColor = colors.tooltipBody;
                categoryChart.options.plugins.tooltip.borderColor = colors.tooltipBorder;
                categoryChart.data.datasets.forEach(ds => {
                    ds.borderColor = colors.donutBorder;
                });
                categoryChart.update();
            }
        });
    });
</script>
@endpush
