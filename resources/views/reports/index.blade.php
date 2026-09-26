@extends('layouts.app')

@section('title', 'Laporan & Analisis Keuangan')
@section('header_title', 'Laporan & Analisis Keuangan')
@section('header_subtitle', 'Analisis arus kas mendalam, rasio tabungan, dan alokasi anggaran')

@section('content')
<div class="space-y-6">
    <!-- Filter Period Bar & Print Action (Hidden on print) -->
    <div class="print:hidden p-5 sm:p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors duration-300">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-center gap-3">
            <div>
                <label class="sr-only">Bulan</label>
                <select name="month" class="px-3.5 py-2.5 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="sr-only">Tahun</label>
                <select name="year" class="px-3.5 py-2.5 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-catat-primary text-xs py-2 px-4 shadow-sm">
                Tampilkan Laporan
            </button>
        </form>

        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="btn-catat-outline text-xs py-2 px-4 shadow-xs">
                <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Printable Report Title Header -->
    <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm print:bg-transparent print:border-0 print:p-0 transition-colors duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#DFDCE3] dark:border-slate-800 gap-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#4ABDAC]">CatatUang Financial Summary</span>
                <h2 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white mt-0.5">Laporan Keuangan Periode {{ $selectedDate->translatedFormat('F Y') }}</h2>
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        <!-- 4 Metrics Cards for the Month -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            <div class="p-4 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800">
                <span class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Pemasukan Periode Ini</span>
                <p class="text-xl font-bold font-heading text-[#4ABDAC] mt-1">Rp {{ number_format($periodIncome, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800">
                <span class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Pengeluaran Periode Ini</span>
                <p class="text-xl font-bold font-heading text-[#FC4A1A] mt-1">Rp {{ number_format($periodExpense, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800">
                <span class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Arus Kas Bersih (Net)</span>
                <p class="text-xl font-bold font-heading {{ $periodNet >= 0 ? 'text-[#4ABDAC]' : 'text-[#FC4A1A]' }} mt-1">Rp {{ number_format($periodNet, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800">
                <span class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Tingkat Tabungan (Savings Rate)</span>
                <p class="text-xl font-bold font-heading {{ $savingsRate >= 20 ? 'text-[#4ABDAC]' : ($savingsRate >= 0 ? 'text-[#d89300]' : 'text-[#FC4A1A]') }} mt-1">{{ $savingsRate }}%</p>
            </div>
        </div>
    </div>

    <!-- Daily Trajectory Chart (Hidden on print) -->
    <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm print:hidden transition-colors duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Grafik Alur Kas Harian (Hari 1 s/d {{ $selectedDate->daysInMonth }})</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Aktivitas arus masuk dan keluar harian selama bulan {{ $selectedDate->translatedFormat('F Y') }}</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-[#4ABDAC]"><span class="w-2.5 h-2.5 rounded-full bg-[#4ABDAC]"></span> Pemasukan</span>
                <span class="flex items-center gap-1.5 text-[#FC4A1A]"><span class="w-2.5 h-2.5 rounded-full bg-[#FC4A1A]"></span> Pengeluaran</span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <!-- Breakdown Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Expense Breakdown Table with Progress Bars -->
        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm space-y-4 transition-colors duration-300">
            <div class="flex items-center justify-between pb-3 border-b border-[#DFDCE3] dark:border-slate-800">
                <h3 class="text-sm font-bold font-heading text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FC4A1A]"></span>
                    <span>Rincian Pengeluaran per Kategori</span>
                </h3>
                <span class="text-xs font-bold text-[#FC4A1A]">Total: Rp {{ number_format($periodExpense, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3.5">
                @forelse($expenseCategories as $cat)
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $cat['name'] }} <span class="text-slate-400 dark:text-slate-500 font-normal">({{ $cat['count'] }}x)</span></span>
                            <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($cat['amount'], 0, ',', '.') }} <span class="text-slate-500 dark:text-slate-400 font-normal ml-1">({{ $cat['percentage'] }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 bg-[#F1F0F4] dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ min($cat['percentage'], 100) }}%; background-color: {{ $cat['color'] }}"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-6 font-medium">Tidak ada transaksi pengeluaran pada bulan ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Income Breakdown Table with Progress Bars -->
        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm space-y-4 transition-colors duration-300">
            <div class="flex items-center justify-between pb-3 border-b border-[#DFDCE3] dark:border-slate-800">
                <h3 class="text-sm font-bold font-heading text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#4ABDAC]"></span>
                    <span>Rincian Pemasukan per Kategori</span>
                </h3>
                <span class="text-xs font-bold text-[#4ABDAC]">Total: Rp {{ number_format($periodIncome, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3.5">
                @forelse($incomeCategories as $cat)
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $cat['name'] }} <span class="text-slate-400 dark:text-slate-500 font-normal">({{ $cat['count'] }}x)</span></span>
                            <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($cat['amount'], 0, ',', '.') }} <span class="text-slate-500 dark:text-slate-400 font-normal ml-1">({{ $cat['percentage'] }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 bg-[#F1F0F4] dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ min($cat['percentage'], 100) }}%; background-color: {{ $cat['color'] }}"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-6 font-medium">Tidak ada transaksi pemasukan pada bulan ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const isDark = () => document.documentElement.classList.contains('dark');
        const getChartTheme = () => ({
            grid: isDark() ? '#1e293b' : '#F1F0F4',
            tick: isDark() ? '#94a3b8' : '#64748b',
            tooltipBg: isDark() ? '#1e293b' : '#ffffff',
            tooltipTitle: isDark() ? '#f8fafc' : '#0f172a',
            tooltipBody: isDark() ? '#cbd5e1' : '#334155',
            tooltipBorder: isDark() ? '#334155' : '#DFDCE3'
        });

        let themeColors = getChartTheme();

        const ctxDaily = document.getElementById('dailyChart');
        let dailyChart = null;
        if (ctxDaily) {
            dailyChart = new Chart(ctxDaily, {
                type: 'line',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: @json($dailyIncome),
                            borderColor: '#4ABDAC',
                            backgroundColor: 'rgba(74, 189, 172, 0.15)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2.5,
                            pointRadius: 2,
                            pointHoverRadius: 5,
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($dailyExpense),
                            borderColor: '#FC4A1A',
                            backgroundColor: 'rgba(252, 74, 26, 0.12)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2.5,
                            pointRadius: 2,
                            pointHoverRadius: 5,
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
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: themeColors.tick, font: { family: 'Manrope', size: 10, weight: '600' } },
                            border: { display: false }
                        },
                        y: {
                            grid: { color: themeColors.grid },
                            ticks: {
                                color: themeColors.tick,
                                font: { family: 'Manrope', size: 10 },
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + 'k';
                                    return value;
                                }
                            },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        window.addEventListener('themechanged', function () {
            const colors = getChartTheme();
            if (dailyChart) {
                dailyChart.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
                dailyChart.options.plugins.tooltip.titleColor = colors.tooltipTitle;
                dailyChart.options.plugins.tooltip.bodyColor = colors.tooltipBody;
                dailyChart.options.plugins.tooltip.borderColor = colors.tooltipBorder;
                dailyChart.options.scales.x.ticks.color = colors.tick;
                dailyChart.options.scales.y.ticks.color = colors.tick;
                dailyChart.options.scales.y.grid.color = colors.grid;
                dailyChart.update();
            }
        });
    });
</script>
@endpush
