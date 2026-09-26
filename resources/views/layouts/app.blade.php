<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8F9FB] dark:bg-slate-950 text-slate-800 dark:text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CatatUang - Kelola Uang Makin Gampang. Aplikasi pencatatan dan manajemen keuangan modern.">
    <title>@yield('title', 'CatatUang') - Kelola Uang Makin Gampang</title>

    <!-- Theme initialization script (prevents FOUC) -->
    <script>
        if (localStorage.getItem('catatuang_theme') === 'dark' || 
            (!localStorage.getItem('catatuang_theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts: Kantumruy Pro & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-[#F8F9FB] dark:bg-slate-950 font-sans antialiased text-slate-800 dark:text-slate-200 selection:bg-[#4ABDAC]/25 selection:text-[#2e7e73] transition-colors duration-300">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex md:w-72 flex-col bg-white dark:bg-slate-900 border-r border-[#DFDCE3] dark:border-slate-800 shrink-0 z-20 shadow-sm transition-colors duration-300">
            <!-- Brand Logo -->
            <div class="p-6 border-b border-[#DFDCE3] dark:border-slate-800 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-[#4ABDAC] p-2 flex items-center justify-center shadow-md shadow-[#4ABDAC]/25 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-bold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                        </div>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold tracking-tight">Kelola Uang Makin Gampang</p>
                    </div>
                </a>
            </div>

            <!-- Quick Action Button ("Catat Sekarang") -->
            <div class="px-5 pt-6 pb-2">
                <a href="{{ route('transactions.create') }}" id="btn-quick-new-transaction" class="btn-catat-primary w-full text-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Catat Sekarang</span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">Menu Utama</p>

                <!-- Landing Page -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC] transition-all duration-200 group">
                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-hover:text-[#4ABDAC] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Halaman Depan</span>
                </a>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC]' }} group">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500 group-hover:text-[#4ABDAC]' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Transaksi -->
                <a href="{{ route('transactions.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC]' }} group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('transactions.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500 group-hover:text-[#4ABDAC]' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Transaksi</span>
                    </div>
                </a>

                <!-- Kategori -->
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC]' }} group">
                    <svg class="w-5 h-5 {{ request()->routeIs('categories.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500 group-hover:text-[#4ABDAC]' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kategori</span>
                </a>

                <!-- Laporan & Analitik -->
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC]' }} group">
                    <svg class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500 group-hover:text-[#4ABDAC]' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Laporan & Analitik</span>
                </a>
            </nav>

            <!-- Bottom Status Card -->
            <div class="p-4 m-4 rounded-2xl bg-[#F4F3F6] dark:bg-slate-800/60 border border-[#DFDCE3] dark:border-slate-800">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#4ABDAC] animate-ping"></span>
                    <span class="text-xs font-bold text-[#2e7e73] dark:text-[#4ABDAC]">Database Aktif</span>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight">Pencatatan keuangan tersimpan rapi dan aman di sistem lokal Anda.</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar Header -->
            <header class="h-16 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-[#DFDCE3] dark:border-slate-800 px-4 md:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs transition-colors duration-300">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button id="mobile-menu-btn" type="button" class="md:hidden p-2 rounded-xl bg-slate-100 dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:text-[#4ABDAC]" aria-label="Menu Navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-base md:text-lg font-bold font-heading text-slate-900 dark:text-white tracking-tight">@yield('header_title', 'CatatUang')</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 hidden sm:block">@yield('header_subtitle', 'Pantau dan kelola arus kas harian Anda secara real-time')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Theme Toggle Button (Light / Dark Mode) -->
                    <button type="button" onclick="toggleTheme()" class="theme-toggle-btn p-2 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC] transition shadow-xs" title="Ganti Mode Terang / Gelap" aria-label="Toggle Theme">
                        <!-- Sun Icon (Active in Dark Mode) -->
                        <svg class="theme-icon-sun hidden w-4.5 h-4.5 text-[#F7B733]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <!-- Moon Icon (Active in Light Mode) -->
                        <svg class="theme-icon-moon w-4.5 h-4.5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <a href="{{ route('landing') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 hover:bg-[#eae8f0] dark:hover:bg-slate-700 border border-[#DFDCE3] dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC] transition">
                        <svg class="w-3.5 h-3.5 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Landing Page</span>
                    </a>

                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300 font-medium">
                        <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <a href="{{ route('transactions.create') }}" class="md:hidden p-2 rounded-xl bg-[#4ABDAC] text-white hover:bg-[#3ca092] shadow-md shadow-[#4ABDAC]/25">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Mobile Drawer Menu -->
            <div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-slate-900/60 dark:bg-black/70 backdrop-blur-sm">
                <div class="w-72 h-full bg-white dark:bg-slate-900 border-r border-[#DFDCE3] dark:border-slate-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-6 border-b border-[#DFDCE3] dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#4ABDAC] flex items-center justify-center text-white font-bold font-heading">C</div>
                                <div>
                                    <span class="font-bold text-lg font-heading text-[#4ABDAC]">CATATUANG</span>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500">Kelola Uang Makin Gampang</p>
                                </div>
                            </div>
                            <button id="mobile-menu-close" class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <nav class="mt-6 space-y-2">
                            <a href="{{ route('landing') }}" class="block px-4 py-2.5 rounded-xl font-semibold text-sm text-slate-700 dark:text-slate-300 hover:bg-[#F4F3F6] dark:hover:bg-slate-800">🌐 Halaman Depan</a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('dashboard') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC]' : 'text-slate-700 dark:text-slate-300' }}">Dashboard</a>
                            <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('transactions.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC]' : 'text-slate-700 dark:text-slate-300' }}">Transaksi</a>
                            <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('categories.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC]' : 'text-slate-700 dark:text-slate-300' }}">Kategori</a>
                            <a href="{{ route('reports.index') }}" class="block px-4 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('reports.*') ? 'bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC]' : 'text-slate-700 dark:text-slate-300' }}">Laporan</a>
                        </nav>
                    </div>

                    <div class="space-y-3">
                        <button type="button" onclick="toggleTheme()" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300">
                            <span class="theme-icon-sun hidden text-[#F7B733]">☀️ Mode Terang</span>
                            <span class="theme-icon-moon text-slate-600 dark:text-slate-300">🌙 Mode Gelap</span>
                        </button>
                        <a href="{{ route('transactions.create') }}" class="btn-catat-primary w-full text-center">
                            Catat Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Flash Messages & Main Content -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto">
                <div class="max-w-7xl mx-auto space-y-6">
                    @if(session('success'))
                        <div id="alert-success" class="flex items-center justify-between p-4 rounded-2xl bg-[#eaf7f5] dark:bg-emerald-950/50 border border-[#4ABDAC]/40 dark:border-emerald-500/40 text-[#2e7e73] dark:text-emerald-300 shadow-sm animate-fade-in">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-[#4ABDAC]/20 text-[#4ABDAC] flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold">{{ session('success') }}</p>
                            </div>
                            <button onclick="document.getElementById('alert-success').remove()" class="text-[#4ABDAC] hover:text-[#2e7e73] dark:hover:text-emerald-200 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="alert-error" class="flex items-center justify-between p-4 rounded-2xl bg-[#fef0ec] dark:bg-rose-950/50 border border-[#FC4A1A]/40 dark:border-rose-500/40 text-[#FC4A1A] dark:text-rose-300 shadow-sm animate-fade-in">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-[#FC4A1A]/20 text-[#FC4A1A] flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold">{{ session('error') }}</p>
                            </div>
                            <button onclick="document.getElementById('alert-error').remove()" class="text-[#FC4A1A] hover:text-[#e03b0d] dark:hover:text-rose-200 p-1">
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

    <!-- Mobile menu toggle & Theme Toggle script -->
    <script>
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileClose = document.getElementById('mobile-menu-close');

        if (mobileBtn && mobileMenu && mobileClose) {
            mobileBtn.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
            mobileClose.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('catatuang_theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
            window.dispatchEvent(new CustomEvent('themechanged', { detail: { isDark } }));
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>
    @stack('scripts')
</body>
</html>
