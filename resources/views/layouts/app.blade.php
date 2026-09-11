<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FinTrack - Aplikasi Pencatatan Keuangan dan Pengeluaran Modern">
    <title>@yield('title', 'FinTrack') - Manajemen Keuangan Cerdas</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-950 font-sans antialiased text-slate-200">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex md:w-72 flex-col bg-slate-900/80 backdrop-blur-xl border-r border-slate-800/80 shrink-0">
            <!-- Brand Logo -->
            <div class="p-6 border-b border-slate-800/60 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 p-[2px] shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-bold bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent">FinTrack</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 rounded-md border border-emerald-500/30">PRO</span>
                        </div>
                        <p class="text-xs text-slate-400 font-medium">Finance & Expense Tracker</p>
                    </div>
                </a>
            </div>

            <!-- Quick Action Button -->
            <div class="px-5 pt-6 pb-2">
                <a href="{{ route('transactions.create') }}" id="btn-quick-new-transaction" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-600/25 hover:shadow-emerald-500/35 active:scale-[0.98] transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Catat Transaksi</span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
                <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Menu Utama</p>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Transaksi -->
                <a href="{{ route('transactions.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('transactions.*') ? 'text-emerald-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Transaksi</span>
                    </div>
                </a>

                <!-- Kategori -->
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('categories.*') ? 'text-emerald-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kategori</span>
                </a>

                <!-- Laporan & Analitik -->
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-emerald-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Laporan & Analitik</span>
                </a>
            </nav>

            <!-- Bottom Status Card -->
            <div class="p-4 m-4 rounded-2xl bg-gradient-to-b from-slate-800/60 to-slate-900/60 border border-slate-800/80">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-xs font-semibold text-emerald-400">Database Aktif</span>
                </div>
                <p class="text-xs text-slate-400">Pencatatan keuangan aman tersimpan di sistem lokal Anda.</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar Header -->
            <header class="h-16 bg-slate-900/60 backdrop-blur-xl border-b border-slate-800/80 px-4 md:px-8 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button id="mobile-menu-btn" type="button" class="md:hidden p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white" aria-label="Menu Navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-base md:text-lg font-bold text-white tracking-tight">@yield('header_title', 'FinTrack App')</h1>
                        <p class="text-xs text-slate-400 hidden sm:block">@yield('header_subtitle', 'Pantau dan kelola arus kas harian Anda secara real-time')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-800/70 border border-slate-700/60 text-xs text-slate-300 font-medium">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <a href="{{ route('transactions.create') }}" class="md:hidden p-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 shadow-md shadow-emerald-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Mobile Drawer Menu -->
            <div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-md">
                <div class="w-72 h-full bg-slate-900 border-r border-slate-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-6 border-b border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-slate-900 font-bold">F</div>
                                <span class="font-bold text-lg text-white">FinTrack</span>
                            </div>
                            <button id="mobile-menu-close" class="p-2 text-slate-400 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <nav class="mt-6 space-y-2">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl font-medium text-sm {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-300' }}">Dashboard</a>
                            <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-sm {{ request()->routeIs('transactions.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-300' }}">Transaksi</a>
                            <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-sm {{ request()->routeIs('categories.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-300' }}">Kategori</a>
                            <a href="{{ route('reports.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-sm {{ request()->routeIs('reports.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-300' }}">Laporan</a>
                        </nav>
                    </div>
                    <a href="{{ route('transactions.create') }}" class="w-full py-2.5 px-4 text-center rounded-xl font-semibold text-sm text-white bg-emerald-600">
                        + Catat Transaksi
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto">
                <div class="max-w-7xl mx-auto space-y-6">
                    @if(session('success'))
                        <div id="alert-success" class="flex items-center justify-between p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 backdrop-blur-md shadow-lg shadow-emerald-950/50 animate-fade-in">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                            <button onclick="document.getElementById('alert-success').remove()" class="text-emerald-400/70 hover:text-emerald-300 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="alert-error" class="flex items-center justify-between p-4 rounded-xl bg-rose-950/60 border border-rose-500/30 text-rose-300 backdrop-blur-md shadow-lg shadow-rose-950/50 animate-fade-in">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                            <button onclick="document.getElementById('alert-error').remove()" class="text-rose-400/70 hover:text-rose-300 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- Page View Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile menu toggle script -->
    <script>
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileClose = document.getElementById('mobile-menu-close');

        if (mobileBtn && mobileMenu && mobileClose) {
            mobileBtn.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
            mobileClose.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        }
    </script>
    @stack('scripts')
</body>
</html>
