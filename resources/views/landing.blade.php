<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FinTrack - Aplikasi Pengelolaan Keuangan Pribadi dan Arus Kas Modern, Cepat, dan Cerdas.">
    <title>FinTrack - Kelola Keuangan Pribadi Cerdas & Terarah</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js CDN for Live Interactive Demo -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        /* Glassmorphism helpers */
        .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }
        .glass-glow {
            box-shadow: 0 0 50px -10px rgba(16, 185, 129, 0.15);
        }
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 50%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-emerald {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="h-full bg-slate-950 font-sans antialiased text-slate-200 selection:bg-emerald-500/30 selection:text-emerald-300 relative overflow-x-hidden">

    <!-- Ambient Glow Backgrounds -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-gradient-to-b from-emerald-500/15 via-teal-500/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-[35%] -left-48 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-3xl"></div>
        <div class="absolute top-[60%] -right-48 w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-1/3 w-[600px] h-[400px] bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Sticky Navigation Bar -->
    <header class="sticky top-0 z-50 w-full glass-panel border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 p-[2px] shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-extrabold tracking-tight text-white">FinTrack</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-500/20 text-emerald-400 rounded-md border border-emerald-500/30">APP</span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-medium">Finance & Expense Tracker</p>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Fitur Unggulan</a>
                <a href="#preview" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Tampilan Live</a>
                <a href="#kalkulator" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Kalkulator 50/30/20</a>
                <a href="#cara-kerja" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Cara Kerja</a>
                <a href="#faq" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">FAQ</a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden sm:flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-500 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-600/30 hover:shadow-emerald-500/40 active:scale-[0.98] transition-all duration-200">
                    <span>Buka Dashboard</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <div class="flex md:hidden items-center">
                <button id="mobile-toggle-btn" type="button" class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-nav" class="hidden md:hidden border-t border-slate-800/80 bg-slate-950/95 backdrop-blur-xl px-6 py-6 space-y-4">
            <nav class="flex flex-col space-y-3">
                <a href="#fitur" class="mobile-link text-base font-medium text-slate-300 hover:text-emerald-400 py-1">Fitur Unggulan</a>
                <a href="#preview" class="mobile-link text-base font-medium text-slate-300 hover:text-emerald-400 py-1">Tampilan Live</a>
                <a href="#kalkulator" class="mobile-link text-base font-medium text-slate-300 hover:text-emerald-400 py-1">Kalkulator 50/30/20</a>
                <a href="#cara-kerja" class="mobile-link text-base font-medium text-slate-300 hover:text-emerald-400 py-1">Cara Kerja</a>
                <a href="#faq" class="mobile-link text-base font-medium text-slate-300 hover:text-emerald-400 py-1">FAQ</a>
            </nav>
            <div class="pt-4 border-t border-slate-800 flex flex-col gap-3">
                <a href="{{ route('dashboard') }}" class="w-full text-center py-3 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg shadow-emerald-600/30">
                    Buka Dashboard Sekarang →
                </a>
                <a href="{{ route('transactions.create') }}" class="w-full text-center py-2.5 rounded-xl font-medium text-sm text-slate-300 bg-slate-900 border border-slate-800">
                    + Catat Transaksi Baru
                </a>
            </div>
        </div>
    </header>

    <main class="relative z-10">
        <!-- Hero Section -->
        <section class="pt-16 pb-20 md:pt-24 md:pb-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badge Announcement -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel border border-emerald-500/30 text-xs sm:text-sm font-medium text-emerald-400 mb-8 shadow-inner animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>FinTrack v1.0 • Aplikasi Manajemen Keuangan Pintar & Cepat</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight max-w-5xl mx-auto leading-[1.15] mb-6">
                Kelola Keuangan Lebih Cerdas, <br class="hidden sm:inline">
                <span class="text-gradient-emerald">Bebas Finansial & Terarah.</span>
            </h1>

            <!-- Subtitle -->
            <p class="max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-slate-400 mb-10 leading-relaxed">
                Pantau setiap rupiah pemasukan dan pengeluaran harian Anda secara real-time. Lengkap dengan visualisasi grafik interaktif, analisis kategori cerdas, dan ekspor laporan instan.
            </p>

            <!-- Hero CTAs -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto mb-14">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl font-bold text-base text-white bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-500 hover:from-emerald-500 hover:to-teal-500 shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-3">
                    <span>Mulai Buka Dashboard</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('transactions.create') }}" class="w-full sm:w-auto px-7 py-4 rounded-xl font-semibold text-base text-slate-300 hover:text-white glass-panel border border-slate-700/80 hover:border-slate-600 hover:bg-slate-800/80 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Catat Transaksi</span>
                </a>
            </div>

            <!-- Trust Pills -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto pt-6 border-t border-slate-800/60 text-slate-400 text-xs sm:text-sm font-medium">
                <div class="flex items-center justify-center gap-2 py-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Tanpa Registrasi Rumit</span>
                </div>
                <div class="flex items-center justify-center gap-2 py-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>100% Data Pribadi Aman</span>
                </div>
                <div class="flex items-center justify-center gap-2 py-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Grafik Arus Kas 6 Bulan</span>
                </div>
                <div class="flex items-center justify-center gap-2 py-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Ekspor CSV Spreadsheet</span>
                </div>
            </div>
        </section>

        <!-- Live Dashboard Showcase / Mockup Preview -->
        <section id="preview" class="py-12 md:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <p class="text-xs uppercase tracking-widest font-bold text-emerald-400 mb-2">Live Interface Preview</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Visualisasi Modern Arus Kas Anda</h2>
                <p class="text-slate-400 text-sm sm:text-base mt-2 max-w-xl mx-auto">
                    Rasakan sensasi mengontrol neraca keuangan Anda dengan antarmuka yang bersih, intuitif, dan responsif di semua perangkat.
                </p>
            </div>

            <!-- Mockup Window Container -->
            <div class="relative max-w-5xl mx-auto rounded-2xl p-1 bg-gradient-to-b from-slate-700/60 via-slate-800/40 to-slate-900/80 shadow-2xl glass-glow">
                <div class="bg-slate-900/90 rounded-xl overflow-hidden border border-slate-800">
                    <!-- Window Topbar -->
                    <div class="px-4 py-3 bg-slate-950/80 border-b border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                            <span class="ml-4 text-xs font-medium text-slate-400 hidden sm:inline-block">fintrack-app.test/dashboard</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 text-xs font-semibold border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Live Sync
                            </span>
                            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                                Masuk Asli
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Inner Mockup Body -->
                    <div class="p-4 sm:p-6 md:p-8 space-y-6">
                        <!-- Metric Cards in Mockup -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Saldo Bersih Card -->
                            <div class="p-5 rounded-xl bg-gradient-to-br from-slate-800/80 to-slate-900/80 border border-slate-700/60 shadow-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Saldo Bersih</span>
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                                <p class="text-2xl font-extrabold text-white">Rp 24.850.000</p>
                                <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-400 font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    <span>+14.2% dari bulan lalu</span>
                                </div>
                            </div>

                            <!-- Pemasukan Card -->
                            <div class="p-5 rounded-xl bg-gradient-to-br from-slate-800/80 to-slate-900/80 border border-slate-700/60 shadow-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pemasukan Bulan Ini</span>
                                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 flex items-center justify-center text-teal-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                    </div>
                                </div>
                                <p class="text-2xl font-extrabold text-teal-400">Rp 32.500.000</p>
                                <p class="mt-2 text-xs text-slate-400">Gaji, Dividen & Freelance</p>
                            </div>

                            <!-- Pengeluaran Card -->
                            <div class="p-5 rounded-xl bg-gradient-to-br from-slate-800/80 to-slate-900/80 border border-slate-700/60 shadow-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengeluaran Bulan Ini</span>
                                    <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center text-rose-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                    </div>
                                </div>
                                <p class="text-2xl font-extrabold text-rose-400">Rp 7.650.000</p>
                                <p class="mt-2 text-xs text-slate-400">Terkendali (23.5% dari Income)</p>
                            </div>
                        </div>

                        <!-- Chart & Breakdown Mockup -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Simulated Chart Area -->
                            <div class="lg:col-span-2 p-5 rounded-xl bg-slate-950/60 border border-slate-800">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                                        Tren Arus Kas (6 Bulan Terakhir)
                                    </h3>
                                    <div class="flex items-center gap-4 text-xs font-medium">
                                        <span class="flex items-center gap-1.5 text-teal-400">
                                            <span class="w-2.5 h-2.5 rounded-full bg-teal-400"></span> Pemasukan
                                        </span>
                                        <span class="flex items-center gap-1.5 text-rose-400">
                                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span> Pengeluaran
                                        </span>
                                    </div>
                                </div>
                                <div class="h-56 relative w-full">
                                    <canvas id="heroPreviewChart"></canvas>
                                </div>
                            </div>

                            <!-- Category breakdown mini widget -->
                            <div class="p-5 rounded-xl bg-slate-950/60 border border-slate-800 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-sm font-bold text-white mb-4 flex items-center justify-between">
                                        <span>Alokasi Pengeluaran</span>
                                        <span class="text-xs font-medium text-slate-400">Bulan Ini</span>
                                    </h3>
                                    <div class="space-y-3">
                                        <div>
                                            <div class="flex justify-between text-xs font-medium mb-1">
                                                <span class="text-slate-300">🍽️ Makanan & Minuman</span>
                                                <span class="text-slate-400">Rp 3.200.000 (41%)</span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                                                <div class="h-full bg-rose-500 rounded-full" style="width: 41%"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between text-xs font-medium mb-1">
                                                <span class="text-slate-300">🚗 Transportasi</span>
                                                <span class="text-slate-400">Rp 1.450.000 (19%)</span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                                                <div class="h-full bg-amber-500 rounded-full" style="width: 19%"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between text-xs font-medium mb-1">
                                                <span class="text-slate-300">💡 Tagihan & Utilitas</span>
                                                <span class="text-slate-400">Rp 1.800.000 (24%)</span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                                                <div class="h-full bg-cyan-500 rounded-full" style="width: 24%"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between text-xs font-medium mb-1">
                                                <span class="text-slate-300">🛍️ Belanja & Hiburan</span>
                                                <span class="text-slate-400">Rp 1.200.000 (16%)</span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                                                <div class="h-full bg-purple-500 rounded-full" style="width: 16%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs">
                                    <span class="text-emerald-400 font-semibold">Tersimpan: 76.5%</span>
                                    <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Lihat detail →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Features Section -->
        <section id="fitur" class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/20">
                    Fitur Lengkap FinTrack
                </span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mt-4 tracking-tight">
                    Segala Kebutuhan Finansial, <br class="hidden sm:inline">
                    Dalam Satu Dasbor Terpadu.
                </h2>
                <p class="text-slate-400 text-base md:text-lg mt-4">
                    Dirancang dengan teliti untuk kenyamanan mencatat, ketajaman analisis, dan kecepatan pengambilan keputusan anggaran Anda.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Feature 1 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-emerald-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-300 transition-colors">Pencatatan Instan 5 Detik</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Input pemasukan atau pengeluaran tanpa hambatan. Lengkap dengan nominal rupiah, tanggal transaksi, kategori, dan catatan opsional.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-teal-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-teal-300 transition-colors">Grafik Arus Kas 6 Bulan</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Pantau perbandingan cash flow historis dengan visualisasi interaktif Chart.js. Ketahui apakah pola belanja Anda membaik dari waktu ke waktu.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-cyan-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-300 transition-colors">Kategori Kustom Dinamis</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Atur pos anggaran sesuai kepribadian Anda. Tambahkan kategori baru dengan pilihan warna kustom dan tipe (pemasukan / pengeluaran).
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-amber-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-amber-300 transition-colors">Laporan & Evaluasi Neraca</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Filter transaksi berdasarkan kategori, tanggal mulai, dan tanggal selesai. Dapatkan ringkasan total debit, kredit, dan net balance secara akurat.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-emerald-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-300 transition-colors">Ekspor Data Sekali Klik</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Unduh seluruh rekap transaksi ke dalam format CSV yang siap dibuka langsung di Microsoft Excel, Google Sheets, atau software akuntansi.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="p-7 rounded-2xl glass-panel hover:border-purple-500/40 hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-purple-300 transition-colors">100% Privasi & Data Lokal</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Data keuangan sensitif Anda tersimpan aman di database lokal Anda. Tidak ada iklan pihak ketiga, tanpa tracker invasif, bebas sepenuhnya.
                    </p>
                </div>
            </div>
        </section>

        <!-- Interactive Budget Calculator Section (50/30/20 Rule) -->
        <section id="kalkulator" class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-8 sm:p-12 md:p-16 rounded-3xl glass-panel border border-emerald-500/30 relative overflow-hidden shadow-2xl">
                <!-- Background decoration -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="max-w-3xl mx-auto text-center mb-10">
                    <span class="px-3.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/30">
                        Interactive Tool
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                        Kalkulator Aturan Anggaran 50 / 30 / 20
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base mt-2">
                        Hitung proporsi ideal pembagian gaji Anda sebelum mencatatnya di FinTrack: 50% Kebutuhan, 30% Keinginan, dan 20% Tabungan/Investasi.
                    </p>
                </div>

                <!-- Calculator Input & Preset Buttons -->
                <div class="max-w-xl mx-auto space-y-6">
                    <div>
                        <label for="incomeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Masukkan Estimasi Pemasukan Bulanan (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-400 font-bold text-base">
                                Rp
                            </span>
                            <input 
                                type="number" 
                                id="incomeInput" 
                                value="10000000" 
                                step="500000"
                                min="100000"
                                class="w-full pl-14 pr-4 py-3.5 rounded-xl bg-slate-900 border border-slate-700 text-white font-bold text-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all"
                                placeholder="Contoh: 10000000"
                            >
                        </div>
                    </div>

                    <!-- Preset Pills -->
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <span class="text-xs text-slate-400 font-medium">Contoh Cepat:</span>
                        <button type="button" class="preset-btn px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 text-xs font-semibold transition" data-amount="5000000">Rp 5 Juta</button>
                        <button type="button" class="preset-btn px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold transition" data-amount="10000000">Rp 10 Juta</button>
                        <button type="button" class="preset-btn px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 text-xs font-semibold transition" data-amount="20000000">Rp 20 Juta</button>
                        <button type="button" class="preset-btn px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 text-xs font-semibold transition" data-amount="35000000">Rp 35 Juta</button>
                    </div>

                    <!-- Live Calculation Result Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        <!-- 50% Needs -->
                        <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800 text-left">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-emerald-400">50% Kebutuhan</span>
                                <span class="text-[10px] text-slate-400 font-semibold">Pokok</span>
                            </div>
                            <p id="needsResult" class="text-lg font-black text-white">Rp 5.000.000</p>
                            <p class="text-[11px] text-slate-400 mt-1">Sewa, makan harian, listrik, cicilan wajib.</p>
                        </div>

                        <!-- 30% Wants -->
                        <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800 text-left">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-amber-400">30% Keinginan</span>
                                <span class="text-[10px] text-slate-400 font-semibold">Gaya Hidup</span>
                            </div>
                            <p id="wantsResult" class="text-lg font-black text-white">Rp 3.000.000</p>
                            <p class="text-[11px] text-slate-400 mt-1">Nongkrong, hobi, langganan streaming, liburan.</p>
                        </div>

                        <!-- 20% Savings -->
                        <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800 text-left">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-cyan-400">20% Tabungan</span>
                                <span class="text-[10px] text-slate-400 font-semibold">Investasi</span>
                            </div>
                            <p id="savingsResult" class="text-lg font-black text-white">Rp 2.000.000</p>
                            <p class="text-[11px] text-slate-400 mt-1">Dana darurat, reksadana, investasi masa depan.</p>
                        </div>
                    </div>

                    <!-- Direct Action to Apply in Dashboard -->
                    <div class="pt-6 text-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-600/30 active:scale-[0.98] transition-all">
                            <span>Terapkan Alokasi Ini di Dashboard FinTrack</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="cara-kerja" class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1 rounded-full bg-teal-500/10 text-teal-400 text-xs font-bold uppercase tracking-wider border border-teal-500/20">
                    Langkah Sederhana
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                    Mulai Kelola Finansial dalam 3 Menit
                </h2>
                <p class="text-slate-400 text-base mt-2">
                    Tidak ada kurva belajar yang berbelit-belit. Siapa saja dapat langsung mengatur alur keuangannya.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Step 1 -->
                <div class="p-8 rounded-2xl glass-panel relative border border-slate-800/80">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-slate-950 font-black text-xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/20">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Tentukan Kategori Anda</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Buka menu Kategori dan sesuaikan pos pemasukan (Gaji, Bisnis, Dividen) serta pengeluaran (Makanan, Rumah, Hiburan) dengan warna pilihan Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-8 rounded-2xl glass-panel relative border border-slate-800/80">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-teal-500 to-cyan-400 text-slate-950 font-black text-xl flex items-center justify-center mb-6 shadow-lg shadow-teal-500/20">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Catat Transaksi Harian</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Hanya butuh 5 detik untuk memasukkan transaksi setiap kali Anda menerima uang atau mengeluarkan dana. Cepat dan anti ribet.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-8 rounded-2xl glass-panel relative border border-slate-800/80">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-cyan-500 to-emerald-400 text-slate-950 font-black text-xl flex items-center justify-center mb-6 shadow-lg shadow-cyan-500/20">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Evaluasi & Hemat Lebih Banyak</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Buka Dashboard dan Laporan secara berkala untuk melihat kategori apa yang paling boros, lalu sesuaikan strategi belanja Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- Testimonials / User Social Proof -->
        <section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1 rounded-full bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase tracking-wider border border-cyan-500/20">
                    Ulasan Pengguna
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                    Cerita Mereka yang Sudah Merasakan Manfaatnya
                </h2>
                <p class="text-slate-400 text-base mt-2">
                    Bagaimana FinTrack membantu berbagai kalangan menjaga kesehatan finansial mereka setiap bulan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <!-- Testimonial 1 -->
                <div class="p-7 rounded-2xl glass-panel border border-slate-800/80 flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 mb-4">
                            ★★★★★
                        </div>
                        <p class="text-sm text-slate-300 italic mb-6 leading-relaxed">
                            "Sebelum pakai FinTrack, saya sering bingung uang freelance habis ke mana di akhir bulan. Berkat grafik 6 bulan dan rincian per kategori, saya berhasil menabung 30% lebih banyak!"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center font-bold text-slate-950 text-sm">
                            RA
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Rizky Adiputra</p>
                            <p class="text-xs text-slate-400">Freelance Web Designer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-7 rounded-2xl glass-panel border border-slate-800/80 flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 mb-4">
                            ★★★★★
                        </div>
                        <p class="text-sm text-slate-300 italic mb-6 leading-relaxed">
                            "Tampilannya gelap dan sangat estetik! Sangat responsif dibuka di browser laptop maupun smartphone. Ekspor CSV ke Excel juga sangat membantu saat evaluasi pajak tahunan."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-teal-500 to-cyan-400 flex items-center justify-center font-bold text-slate-950 text-sm">
                            SW
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Siti Wulandari</p>
                            <p class="text-xs text-slate-400">Pegawai Swasta & Investor</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="p-7 rounded-2xl glass-panel border border-slate-800/80 flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 mb-4">
                            ★★★★★
                        </div>
                        <p class="text-sm text-slate-300 italic mb-6 leading-relaxed">
                            "Simpel, tanpa iklan, dan yang paling penting data keuangan saya tidak dibagikan ke server pihak ketiga. Manajemen kategori kustomnya sangat fleksibel untuk usaha kecil saya."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-500 to-indigo-400 flex items-center justify-center font-bold text-slate-950 text-sm">
                            BP
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Budi Pratama</p>
                            <p class="text-xs text-slate-400">Pemilik UMKM Kuliner</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-16 md:py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="px-3.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/20">
                    Frequently Asked Questions
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-slate-400 text-sm sm:text-base mt-2">
                    Temukan jawaban cepat seputar penggunaan dan fitur FinTrack.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="rounded-xl glass-panel border border-slate-800 overflow-hidden">
                    <button type="button" class="faq-toggle w-full px-6 py-4 text-left font-bold text-white flex items-center justify-between gap-4 hover:bg-slate-800/40 transition">
                        <span>Apakah data keuangan saya aman dan terjaga privasinya?</span>
                        <svg class="w-5 h-5 text-emerald-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5 text-sm text-slate-400 leading-relaxed border-t border-slate-800/60 pt-3">
                        Ya, 100% aman. FinTrack berjalan di lingkungan server lokal Anda (Laragon/PHP/MySQL), dan tidak ada data keuangan yang dikirim ke cloud atau pihak ketiga mana pun.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="rounded-xl glass-panel border border-slate-800 overflow-hidden">
                    <button type="button" class="faq-toggle w-full px-6 py-4 text-left font-bold text-white flex items-center justify-between gap-4 hover:bg-slate-800/40 transition">
                        <span>Bagaimana cara mengekspor riwayat transaksi ke Excel?</span>
                        <svg class="w-5 h-5 text-emerald-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5 text-sm text-slate-400 leading-relaxed border-t border-slate-800/60 pt-3">
                        Anda dapat membuka menu <strong>Transaksi</strong> atau <strong>Laporan</strong>, lalu klik tombol <em>"Ekspor CSV"</em>. File akan otomatis terunduh dan dapat langsung dibuka di Microsoft Excel atau Google Sheets.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="rounded-xl glass-panel border border-slate-800 overflow-hidden">
                    <button type="button" class="faq-toggle w-full px-6 py-4 text-left font-bold text-white flex items-center justify-between gap-4 hover:bg-slate-800/40 transition">
                        <span>Bisakah saya menambah kategori pengeluaran dan pemasukan sendiri?</span>
                        <svg class="w-5 h-5 text-emerald-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5 text-sm text-slate-400 leading-relaxed border-t border-slate-800/60 pt-3">
                        Tentu saja! Masuk ke menu <strong>Kategori</strong>, di mana Anda bisa menambah, mengedit nama, mengubah warna kategori, dan memilih jenis kategori (Pemasukan atau Pengeluaran).
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="rounded-xl glass-panel border border-slate-800 overflow-hidden">
                    <button type="button" class="faq-toggle w-full px-6 py-4 text-left font-bold text-white flex items-center justify-between gap-4 hover:bg-slate-800/40 transition">
                        <span>Apakah ada batas jumlah transaksi yang bisa dicatat?</span>
                        <svg class="w-5 h-5 text-emerald-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5 text-sm text-slate-400 leading-relaxed border-t border-slate-800/60 pt-3">
                        Tidak ada batas sama sekali. Anda dapat mencatat ribuan hingga puluhan ribu transaksi secara leluasa tanpa batasan kuota.
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Banner -->
        <section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl p-8 sm:p-12 md:p-16 bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 border border-emerald-500/40 text-center relative overflow-hidden shadow-2xl glass-glow">
                <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider border border-emerald-500/30">
                        Siap Mengambil Kendali?
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight">
                        Wujudkan Tujuan Keuangan Anda Bersama FinTrack Hari Ini.
                    </h2>
                    <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto">
                        Mulai dari pencatatan harian yang disiplin, nikmati ketenangan finansial jangka panjang.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-9 py-4 rounded-xl font-bold text-base text-slate-950 bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-400 hover:from-emerald-300 hover:to-teal-200 shadow-xl shadow-emerald-500/25 active:scale-95 transition-all">
                            Buka Dashboard Sekarang →
                        </a>
                        <a href="{{ route('transactions.create') }}" class="w-full sm:w-auto px-7 py-4 rounded-xl font-semibold text-base text-white bg-slate-900/80 hover:bg-slate-800 border border-slate-700/80 transition-all">
                            + Catat Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-slate-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black">
                        F
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white tracking-tight">FinTrack</span>
                        <p class="text-xs text-slate-400">Aplikasi Pengelolaan & Pencatatan Keuangan Modern</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-slate-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-400 transition">Dashboard</a>
                    <a href="{{ route('transactions.index') }}" class="hover:text-emerald-400 transition">Transaksi</a>
                    <a href="{{ route('categories.index') }}" class="hover:text-emerald-400 transition">Kategori</a>
                    <a href="{{ route('reports.index') }}" class="hover:text-emerald-400 transition">Laporan & Analitik</a>
                </div>

                <div class="text-xs text-slate-400 text-center md:text-right">
                    <p>&copy; 2026 FinTrack. Hak Cipta Dilindungi.</p>
                    <p class="mt-0.5 text-slate-400">Dibangun dengan Laravel 12 & Tailwind CSS</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts: Mockup Chart, Calculator, FAQ Accordion, Mobile Menu -->
    <script>
        // 1. Mobile Menu Toggle
        const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
        const mobileNav = document.getElementById('mobile-nav');
        if (mobileToggleBtn && mobileNav) {
            mobileToggleBtn.addEventListener('click', () => {
                mobileNav.classList.toggle('hidden');
            });
            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileNav.classList.add('hidden');
                });
            });
        }

        // 2. Mockup Preview Chart.js
        const previewCanvas = document.getElementById('heroPreviewChart');
        if (previewCanvas && typeof Chart !== 'undefined') {
            const ctx = previewCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar'],
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: [18000000, 22000000, 25000000, 28000000, 30000000, 32500000],
                            backgroundColor: 'rgba(20, 184, 166, 0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Pengeluaran',
                            data: [8500000, 9200000, 11000000, 7800000, 8100000, 7650000],
                            backgroundColor: 'rgba(244, 63, 94, 0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
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
                                    return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { size: 11 } }
                        },
                        y: {
                            grid: { color: 'rgba(51, 65, 85, 0.3)' },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: function(val) {
                                    return 'Rp ' + (val / 1000000) + 'jt';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 3. Interactive 50/30/20 Budget Calculator
        const incomeInput = document.getElementById('incomeInput');
        const needsResult = document.getElementById('needsResult');
        const wantsResult = document.getElementById('wantsResult');
        const savingsResult = document.getElementById('savingsResult');
        const presetBtns = document.querySelectorAll('.preset-btn');

        function formatRupiah(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }

        function calculateBudget(income) {
            const val = parseFloat(income) || 0;
            const needs = val * 0.50;
            const wants = val * 0.30;
            const savings = val * 0.20;

            if (needsResult) needsResult.textContent = formatRupiah(needs);
            if (wantsResult) wantsResult.textContent = formatRupiah(wants);
            if (savingsResult) savingsResult.textContent = formatRupiah(savings);
        }

        if (incomeInput) {
            incomeInput.addEventListener('input', (e) => {
                calculateBudget(e.target.value);
            });
        }

        presetBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const amount = btn.getAttribute('data-amount');
                if (incomeInput) {
                    incomeInput.value = amount;
                    calculateBudget(amount);
                }
                presetBtns.forEach(b => {
                    b.classList.remove('bg-emerald-500/20', 'text-emerald-400', 'border', 'border-emerald-500/30');
                    b.classList.add('bg-slate-800', 'text-slate-300');
                });
                btn.classList.add('bg-emerald-500/20', 'text-emerald-400', 'border', 'border-emerald-500/30');
                btn.classList.remove('bg-slate-800', 'text-slate-300');
            });
        });

        // 4. FAQ Accordion Logic
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');
                const isHidden = content.classList.contains('hidden');

                // Close other faqs
                document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                document.querySelectorAll('.faq-toggle svg').forEach(i => i.classList.remove('rotate-180'));

                if (isHidden) {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>
</body>
</html>
