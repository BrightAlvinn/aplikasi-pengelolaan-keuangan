@extends('layouts.app')

@section('title', 'Laporan & Analisis Keuangan')
@section('header_title', 'Laporan & Analisis Keuangan')
@section('header_subtitle', 'Analisis arus kas mendalam, rasio tabungan, dan alokasi anggaran')

@section('content')
<div class="space-y-6">
    <!-- Filter Period Bar & Print Action (Hidden on print) -->
    <div class="print:hidden p-5 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-center gap-3">
            <div>
                <label class="sr-only">Bulan</label>
                <select name="month" class="px-3.5 py-2 bg-slate-800 border border-slate-700 rounded-xl text-xs font-semibold text-white focus:outline-none focus:border-emerald-500 transition">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="sr-only">Tahun</label>
                <select name="year" class="px-3.5 py-2 bg-slate-800 border border-slate-700 rounded-xl text-xs font-semibold text-white focus:outline-none focus:border-emerald-500 transition">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-md shadow-emerald-600/30 transition">
                Tampilkan Laporan
            </button>
        </form>

        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Printable Report Title Header -->
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl print:bg-transparent print:border-0 print:p-0">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-800 gap-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">FinTrack Executive Summary</span>
                <h2 class="text-xl font-extrabold text-white mt-0.5">Laporan Keuangan Periode {{ $selectedDate->translatedFormat('F Y') }}</h2>
            </div>
            <div class="text-xs text-slate-400">
                Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        <!-- 4 Metrics Cards for the Month -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/60">
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-medium">Pemasukan Periode Ini</span>
                <p class="text-xl font-black text-emerald-400 mt-1">Rp {{ number_format($periodIncome, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/60">
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-medium">Pengeluaran Periode Ini</span>
                <p class="text-xl font-black text-rose-400 mt-1">Rp {{ number_format($periodExpense, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/60">
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-medium">Arus Kas Bersih (Net)</span>
                <p class="text-xl font-black {{ $periodNet >= 0 ? 'text-cyan-400' : 'text-amber-400' }} mt-1">Rp {{ number_format($periodNet, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/60">
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-medium">Tingkat Tabungan (Savings Rate)</span>
                <p class="text-xl font-black {{ $savingsRate >= 20 ? 'text-emerald-400' : ($savingsRate >= 0 ? 'text-cyan-400' : 'text-rose-400') }} mt-1">{{ $savingsRate }}%</p>
            </div>
        </div>
    </div>

    <!-- Daily Trajectory Chart (Hidden on small print or nicely fitted) -->
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl print:hidden">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-bold text-white">Grafik Alur Kas Harian (Hari 1 s/d {{ $selectedDate->daysInMonth }})</h3>
                <p class="text-xs text-slate-400">Aktivitas arus masuk dan keluar harian selama bulan {{ $selectedDate->translatedFormat('F Y') }}</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5 text-emerald-400"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Pemasukan</span>
                <span class="flex items-center gap-1.5 text-rose-400"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Pengeluaran</span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <!-- Breakdown Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Expense Breakdown Table with Progress Bars -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <span>Rincian Pengeluaran per Kategori</span>
                </h3>
                <span class="text-xs font-semibold text-rose-400">Total: Rp {{ number_format($periodExpense, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3">
                @forelse($expenseCategories as $cat)
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-200">{{ $cat['name'] }} <span class="text-slate-500 font-normal">({{ $cat['count'] }}x)</span></span>
                            <span class="font-bold text-white">Rp {{ number_format($cat['amount'], 0, ',', '.') }} <span class="text-slate-400 font-normal ml-1">({{ $cat['percentage'] }}%)</span></span>
                        </div>
                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ min($cat['percentage'], 100) }}%; background-color: {{ $cat['color'] }}"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Tidak ada transaksi pengeluaran pada bulan ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Income Breakdown Table with Progress Bars -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>Rincian Pemasukan per Kategori</span>
                </h3>
                <span class="text-xs font-semibold text-emerald-400">Total: Rp {{ number_format($periodIncome, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3">
                @forelse($incomeCategories as $cat)
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-200">{{ $cat['name'] }} <span class="text-slate-500 font-normal">({{ $cat['count'] }}x)</span></span>
                            <span class="font-bold text-white">Rp {{ number_format($cat['amount'], 0, ',', '.') }} <span class="text-slate-400 font-normal ml-1">({{ $cat['percentage'] }}%)</span></span>
                        </div>
                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ min($cat['percentage'], 100) }}%; background-color: {{ $cat['color'] }}"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Tidak ada transaksi pemasukan pada bulan ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctxDaily = document.getElementById('dailyChart');
        if (ctxDaily) {
            new Chart(ctxDaily, {
                type: 'line',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: @json($dailyIncome),
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2,
                            pointRadius: 2,
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($dailyExpense),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.15)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2,
                            pointRadius: 2,
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
                            ticks: { color: '#94a3b8', font: { size: 10 } }
                        },
                        y: {
                            grid: { color: '#1e293b' },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 10 },
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
    });
</script>
@endpush
