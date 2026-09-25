<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FinTrack - Kendalikan Keuangan Anda Mulai Hari Ini. Aplikasi pencatatan dan pengelolaan arus kas modern.">
    <title>FinTrack - Kendalikan Keuangan Anda Mulai Hari Ini</title>

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

        .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }
        .text-gradient-emerald {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-full bg-slate-950 font-sans antialiased text-slate-200 selection:bg-emerald-500/30 selection:text-emerald-300 relative overflow-x-hidden">

    <!-- Ambient Glow Backgrounds -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/4 w-[600px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-[40%] -left-36 w-[500px] h-[500px] bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-[20%] -right-36 w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-1/4 w-[500px] h-[400px] bg-emerald-600/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Alert Notifications (Flash Messages & Validation Errors) -->
    <div class="relative z-50 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        @if(session('success'))
            <div id="flash-success" class="flex items-center justify-between p-4 mb-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 shadow-xl backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-400/80 hover:text-emerald-200 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div id="flash-error" class="flex items-center justify-between p-4 mb-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 shadow-xl backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="text-sm">
                        @foreach($errors->all() as $error)
                            <p class="font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                <button onclick="document.getElementById('flash-error').remove()" class="text-rose-400/80 hover:text-rose-200 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif
    </div>

    <!-- TOP NAVIGATION BAR -->
    <header class="relative z-30 w-full border-b border-slate-800/80 bg-slate-950/70 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 p-[2px] shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white">FinTrack</span>
                </div>
            </a>

            <!-- Nav Menu Links (Fitur, Kalkulator, Daftar, Masuk) -->
            <nav class="flex items-center gap-4 sm:gap-7">
                <a href="#fitur" class="text-sm font-semibold text-slate-300 hover:text-emerald-400 transition-colors">Fitur</a>
                <a href="#kalkulator" class="text-sm font-semibold text-slate-300 hover:text-emerald-400 transition-colors hidden sm:inline-block">Kalkulator</a>
                @guest
                    <button type="button" onclick="openAuthDrawer('register')" class="text-sm font-semibold text-slate-300 hover:text-emerald-400 transition-colors">
                        Daftar
                    </button>
                    <button type="button" onclick="openAuthDrawer('login')" class="px-5 py-2 rounded-full border border-slate-700 hover:border-emerald-400 text-sm font-semibold text-white hover:text-emerald-400 hover:bg-slate-900 transition-all duration-200">
                        Masuk
                    </button>
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-sm font-semibold hover:bg-emerald-500/30 transition-all">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-slate-400 hover:text-rose-400 transition-colors">Keluar</button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <!-- FULL-WIDTH HERO SECTION (KENDALIKAN KEUANGAN ANDA MULAI HARI INI) -->
    <section class="relative z-10 w-full min-h-[calc(100vh-80px)] flex items-center py-12 lg:py-20 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Column (lg:col-span-7): Headline & CTA -->
                <div class="lg:col-span-7">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Platform Pengelolaan Keuangan Cerdas
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.12] mb-6">
                        Kendalikan Keuangan <br>
                        <span class="text-gradient-emerald">Anda Mulai Hari Ini</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-slate-400 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                        Kelola pemasukan dan pengeluaran dengan lebih terarah, pantau tren arus kas real-time, dan capai kebebasan finansial tanpa kerumitan.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        @guest
                            <button type="button" onclick="openAuthDrawer('register')" class="px-8 py-3.5 rounded-xl font-bold text-sm sm:text-base text-slate-950 bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-400 hover:from-emerald-300 hover:to-teal-200 shadow-xl shadow-emerald-500/25 active:scale-[0.98] transition-all duration-200 flex items-center gap-2">
                                <span>Daftar Gratis</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </button>
                            <button type="button" onclick="openAuthDrawer('login')" class="px-6 py-3.5 rounded-xl font-semibold text-sm sm:text-base text-slate-300 hover:text-white glass-panel border border-slate-700 hover:border-slate-500 hover:bg-slate-800 transition-all duration-200">
                                Masuk ke Akun →
                            </button>
                        @else
                            <a href="{{ route('dashboard') }}" class="px-8 py-3.5 rounded-xl font-bold text-sm sm:text-base text-slate-950 bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-400 hover:from-emerald-300 hover:to-teal-200 shadow-xl shadow-emerald-500/25 transition-all flex items-center gap-2">
                                <span>Buka Dashboard FinTrack</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endguest
                    </div>

                    <!-- Trust Highlights -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800/80 text-xs text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>100% Bebas Biaya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-teal-400 font-bold">✓</span>
                            <span>Visualisasi Arus Kas Real-time</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-cyan-400 font-bold">✓</span>
                            <span>Data Aman & Privat</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column (lg:col-span-5): Device Illustration Mockup -->
                <div class="lg:col-span-5 relative">
                    <!-- Subtle Glow Backdrop -->
                    <div class="absolute -inset-4 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Laptop Mockup -->
                    <div class="relative mx-auto w-full max-w-[480px]">
                        <!-- Laptop Screen Outer Frame -->
                        <div class="bg-slate-900 border-2 border-slate-700/80 rounded-t-2xl pt-2 px-2 pb-1 shadow-2xl relative">
                            <!-- Camera Dot -->
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-600 mx-auto mb-1.5"></div>
                            
                            <!-- Laptop Display Area -->
                            <div class="bg-slate-950 rounded-lg p-3 sm:p-4 border border-slate-800 relative overflow-hidden">
                                <!-- Header Mockup in Screen -->
                                <div class="flex items-center justify-between pb-3 border-b border-slate-800/80 mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-md bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">F</div>
                                        <span class="text-xs font-bold text-white">FinTrack Dashboard</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aktif</span>
                                </div>

                                <!-- Mini Metrics Row -->
                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div class="p-2 rounded-lg bg-slate-900/90 border border-slate-800">
                                        <span class="text-[10px] text-slate-400">Total Saldo</span>
                                        <p class="text-xs sm:text-sm font-extrabold text-white">Rp 24.850.000</p>
                                    </div>
                                    <div class="p-2 rounded-lg bg-slate-900/90 border border-slate-800">
                                        <span class="text-[10px] text-teal-400">Pemasukan Bulan Ini</span>
                                        <p class="text-xs sm:text-sm font-extrabold text-teal-400">Rp 32.500.000</p>
                                    </div>
                                </div>

                                <!-- Mini Chart Bars -->
                                <div class="h-16 flex items-end justify-between gap-1.5 pt-2 px-1">
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-teal-500/80 rounded-t" style="height: 60%"></div>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-rose-500/80 rounded-t" style="height: 35%"></div>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-teal-500/80 rounded-t" style="height: 75%"></div>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-rose-500/80 rounded-t" style="height: 40%"></div>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-teal-500/80 rounded-t" style="height: 90%"></div>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-t flex flex-col justify-end h-full">
                                        <div class="w-full bg-rose-500/80 rounded-t" style="height: 30%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Laptop Base / Keyboard Hinge -->
                        <div class="relative bg-slate-800 h-3 rounded-b-xl border-t border-slate-700/60 shadow-lg">
                            <div class="w-16 h-1 bg-slate-600 rounded-full mx-auto -mt-0.5"></div>
                        </div>
                        <div class="w-[104%] -ml-[2%] bg-slate-900 h-1.5 rounded-b-md shadow-2xl"></div>

                        <!-- Smartphone Mockup -->
                        <div class="absolute -right-3 -bottom-4 w-28 sm:w-36 bg-slate-900 border-2 border-slate-700 rounded-2xl p-1.5 shadow-2xl z-20">
                            <div class="w-8 h-1 bg-slate-700 rounded-full mx-auto mb-1.5"></div>
                            <div class="bg-slate-950 rounded-xl p-2.5 border border-slate-800 text-center">
                                <!-- Avatar in Smartphone -->
                                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 text-slate-950 flex items-center justify-center mx-auto mb-2 shadow-md font-bold">
                                    <svg class="w-5 h-5 text-slate-950" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 2a5 5 0 100 10 5 5 0 000-10zm-7 18a7 7 0 0114 0H5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-[10px] font-bold text-white truncate">FinTrack Mobile</p>
                                <span class="inline-block mt-1 px-1.5 py-0.5 text-[8px] font-semibold bg-emerald-500/20 text-emerald-400 rounded">
                                    + Rp 15.000.000
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SLIDE-OVER AUTH DRAWER (SLIDES IN FROM RIGHT TO LEFT) -->
    @php
        $initialOpen = request('action') === 'register' || request('action') === 'login' || $errors->any();
        $initialMode = request('action') === 'register' ? 'register' : 'login';
    @endphp

    <!-- Backdrop Overlay -->
    <div id="auth-drawer-overlay" 
         onclick="closeAuthDrawer()" 
         class="{{ $initialOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }} fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm transition-opacity duration-300">
    </div>

    <!-- Slide-over Drawer Panel -->
    <aside id="auth-drawer" 
           class="{{ $initialOpen ? 'translate-x-0' : 'translate-x-full' }} fixed inset-y-0 right-0 z-50 w-full sm:w-[460px] md:w-[480px] bg-slate-900/95 backdrop-blur-2xl border-l border-slate-700/80 shadow-2xl transition-transform duration-500 ease-out flex flex-col justify-between overflow-y-auto">
        <div class="p-6 sm:p-8">
            <!-- Header with Close Button -->
            <div class="flex items-center justify-between pb-6 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 p-[1.5px]">
                        <div class="w-full h-full bg-slate-950 rounded-[7px] flex items-center justify-center">
                            <span class="text-xs font-black text-emerald-400">F</span>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-white tracking-tight">FinTrack Portal</span>
                </div>
                <button type="button" 
                        onclick="closeAuthDrawer()" 
                        class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors" 
                        title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            @auth
                <!-- STATE: USER ALREADY LOGGED IN -->
                <div class="pt-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 text-slate-950 font-black text-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/25">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-xs text-slate-400 mt-1 mb-6">Akun aktif: <span class="text-emerald-400 font-medium">{{ Auth::user()->email }}</span></p>

                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" class="w-full py-3.5 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-300 hover:from-emerald-300 hover:to-teal-200 shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2 transition-all">
                            <span>Buka Dashboard FinTrack</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-medium text-xs text-slate-400 hover:text-rose-400 hover:bg-slate-800/80 border border-slate-700/60 transition">
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- 1. LOGIN FORM BOX -->
                <div id="login-box" class="{{ $initialMode === 'login' ? 'block' : 'hidden' }} pt-6">
                    <div class="mb-5 pr-4">
                        <h2 class="text-2xl font-bold text-white tracking-tight">Masuk ke Akun Anda</h2>
                        <p class="text-xs text-slate-400 mt-1">Masukkan kredensial Anda untuk melanjutkan ke dashboard.</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Email or Username -->
                        <div>
                            <label for="login-email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email / Username</label>
                            <input 
                                type="text" 
                                name="email" 
                                id="login-email" 
                                value="{{ old('email') }}" 
                                required 
                                placeholder="Email Anda"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            >
                        </div>

                        <!-- Password with Eye Toggle -->
                        <div>
                            <label for="login-password" class="block text-xs font-semibold text-slate-300 mb-1.5">Kata Sandi</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="login-password" 
                                    required 
                                    placeholder="Kata Sandi Anda"
                                    class="w-full pl-4 pr-11 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('login-password', 'eye-icon-login')" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 transition" 
                                    aria-label="Toggle Password Visibility"
                                >
                                    <svg id="eye-icon-login" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-right mt-1.5">
                                <a href="javascript:void(0)" onclick="alert('Untuk kemudahan akses cepat, Anda dapat menggunakan tombol \'Masuk dengan Google / Demo\' di bawah atau akun demo@fintrack.test (password: password).')" class="text-xs text-slate-400 hover:text-emerald-400 transition-colors">
                                    Lupa kata sandi?
                                </a>
                            </div>
                        </div>

                        <!-- Submit Button Masuk -->
                        <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 shadow-lg shadow-emerald-500/20 active:scale-[0.98] transition-all">
                            Masuk
                        </button>
                    </form>

                    <!-- Divider: Atau -->
                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-800"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-3 bg-slate-900 text-slate-400 font-medium">Atau</span>
                        </div>
                    </div>

                    <!-- Social Login (Google / Demo) -->
                    <a href="{{ route('auth.google') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-950 hover:bg-slate-800 border border-slate-700 hover:border-slate-600 text-white text-xs font-semibold flex items-center justify-center gap-3 shadow-md transition-all">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>

                    <!-- Footer Card Switcher -->
                    <div class="mt-6 text-center text-xs text-slate-400">
                        <span>Belum punya akun?</span>
                        <button type="button" onclick="switchToRegister()" class="font-bold text-emerald-400 hover:text-emerald-300 ml-1 underline underline-offset-2">
                            Daftar
                        </button>
                    </div>
                </div>

                <!-- 2. REGISTER FORM BOX (NO GOOGLE BUTTON, AS REQUESTED) -->
                <div id="register-box" class="{{ $initialMode === 'register' ? 'block' : 'hidden' }} pt-6">
                    <div class="mb-4 pr-4">
                        <h2 class="text-2xl font-bold text-white tracking-tight">Daftar Akun Baru</h2>
                        <p class="text-xs text-slate-400 mt-1">Buat akun FinTrack untuk mulai mencatat keuangan Anda.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                        @csrf
                        <!-- Full Name -->
                        <div>
                            <label for="reg-name" class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="reg-name" 
                                value="{{ old('name') }}" 
                                required 
                                placeholder="Nama Lengkap Anda"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="reg-email" class="block text-xs font-semibold text-slate-300 mb-1">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="reg-email" 
                                value="{{ old('email') }}" 
                                required 
                                placeholder="nama@email.com"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="reg-password" class="block text-xs font-semibold text-slate-300 mb-1">Kata Sandi</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="reg-password" 
                                    required 
                                    placeholder="Minimal 6 karakter"
                                    class="w-full pl-4 pr-11 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('reg-password', 'eye-icon-reg')" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 transition" 
                                    aria-label="Toggle Password Visibility"
                                >
                                    <svg id="eye-icon-reg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="reg-password-confirm" class="block text-xs font-semibold text-slate-300 mb-1">Konfirmasi Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="reg-password-confirm" 
                                required 
                                placeholder="Ulangi kata sandi"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            >
                        </div>

                        <!-- Submit Button Daftar (No Google option on register) -->
                        <button type="submit" class="w-full mt-2 py-3 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 shadow-lg shadow-emerald-500/20 active:scale-[0.98] transition-all">
                            Daftar Sekarang
                        </button>
                    </form>

                    <!-- Footer Card Switcher -->
                    <div class="mt-5 text-center text-xs text-slate-400">
                        <span>Sudah punya akun?</span>
                        <button type="button" onclick="switchToLogin()" class="font-bold text-emerald-400 hover:text-emerald-300 ml-1 underline underline-offset-2">
                            Masuk
                        </button>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Drawer Footer Note -->
        <div class="p-6 border-t border-slate-800 text-center">
            <p class="text-[11px] text-slate-500 leading-relaxed">
                Dilindungi oleh standar keamanan data FinTrack. Seluruh data transaksi Anda tersimpan aman dan terenkripsi.
            </p>
        </div>
    </aside>

    <!-- SECTION FITUR UNGGULAN -->
    <section id="fitur" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/20">
                Fitur Unggulan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                Didesain Khusus untuk Efisiensi & Kontrol Finansial
            </h2>
            <p class="text-slate-400 text-base mt-3">
                Nikmati kemudahan mencatat dan menganalisis setiap transaksi dalam satu aplikasi terintegrasi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- 1. Pencatatan Instan -->
            <div class="p-7 rounded-2xl glass-panel hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Pencatatan Instan 5 Detik</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Catat pengeluaran dan pemasukan dengan cepat lengkap dengan kategori, nominal, dan tanggal transaksi.</p>
            </div>

            <!-- 2. Grafik Tren Arus Kas -->
            <div class="p-7 rounded-2xl glass-panel hover:border-teal-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Grafik Tren Arus Kas 6 Bulan</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Pantau pertumbuhan tabungan dan rasio pemasukan vs pengeluaran Anda dengan visualisasi grafik interaktif.</p>
            </div>

            <!-- 3. Kategori Kustom -->
            <div class="p-7 rounded-2xl glass-panel hover:border-cyan-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Kategori Kustom & Berwarna</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Kelompokkan transaksi sesuka hati dengan pilihan palet warna dan ikon yang representatif.</p>
            </div>

            <!-- 4. Laporan Neraca & Filter -->
            <div class="p-7 rounded-2xl glass-panel hover:border-amber-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Laporan & Filter Periode</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Filter transaksi berdasarkan rentang tanggal, kategori, atau tipe untuk evaluasi anggaran berkala.</p>
            </div>

            <!-- 5. Ekspor Sekali Klik -->
            <div class="p-7 rounded-2xl glass-panel hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Ekspor CSV Spreadsheet</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Unduh seluruh riwayat pembukuan ke file format CSV untuk dibuka di Microsoft Excel atau Google Sheets.</p>
            </div>

            <!-- 6. Privasi Database Lokal -->
            <div class="p-7 rounded-2xl glass-panel hover:border-purple-500/40 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">100% Privasi & Data Lokal</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Data Anda tersimpan di server database lokal Anda sendiri, tanpa pelacak atau iklan pihak ketiga.</p>
            </div>
        </div>
    </section>

    <!-- SECTION KALKULATOR ANGGARAN 50/30/20 (INTERACTIVE WITH 3-TIMES POPUP TRIGGER) -->
    <section id="kalkulator" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="p-8 sm:p-12 rounded-3xl glass-panel border border-slate-700/80 relative overflow-hidden shadow-2xl">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <span class="px-3.5 py-1 rounded-full bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase tracking-wider border border-cyan-500/20">
                    Kalkulator Interaktif
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">
                    Kalkulator Aturan Anggaran 50 / 30 / 20
                </h2>
                <p class="text-slate-400 text-sm sm:text-base mt-2">
                    Ketahui alokasi gaji ideal Anda: 50% Kebutuhan, 30% Keinginan, dan 20% Tabungan / Investasi.
                </p>
            </div>

            <div class="max-w-xl mx-auto space-y-6">
                <div>
                    <label for="incomeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Pemasukan Bulanan Anda (Rp)
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
                            class="w-full pl-14 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white font-bold text-lg focus:outline-none focus:border-emerald-500 transition-all"
                        >
                    </div>
                </div>

                <!-- Preset Pills -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="text-xs text-slate-400 font-medium">Contoh:</span>
                    <button type="button" class="preset-btn px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-semibold hover:text-white" data-amount="5000000">Rp 5 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold" data-amount="10000000">Rp 10 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-semibold hover:text-white" data-amount="20000000">Rp 20 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-semibold hover:text-white" data-amount="35000000">Rp 35 Juta</button>
                </div>

                <!-- 3 Alokasi -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3">
                    <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800">
                        <span class="text-xs font-bold text-emerald-400">50% Kebutuhan</span>
                        <p id="needsResult" class="text-lg font-black text-white mt-1">Rp 5.000.000</p>
                        <p class="text-[10px] text-slate-400 mt-1">Makanan, tempat tinggal, listrik.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800">
                        <span class="text-xs font-bold text-amber-400">30% Keinginan</span>
                        <p id="wantsResult" class="text-lg font-black text-white mt-1">Rp 3.000.000</p>
                        <p class="text-[10px] text-slate-400 mt-1">Hiburan, belanja, liburan.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800">
                        <span class="text-xs font-bold text-cyan-400">20% Tabungan</span>
                        <p id="savingsResult" class="text-lg font-black text-white mt-1">Rp 2.000.000</p>
                        <p class="text-[10px] text-slate-400 mt-1">Dana darurat, investasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALCULATOR INTERACTION POPUP MODAL (APPEARS AFTER 3 INTERACTIONS) -->
    <div id="calculator-interest-modal" class="hidden fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md flex items-center justify-center p-4">
        <div class="glass-panel border border-emerald-500/50 p-6 sm:p-8 rounded-2xl max-w-md w-full relative shadow-2xl animate-fade-in">
            <!-- Close Button -->
            <button type="button" onclick="closeCalculatorModal()" class="absolute top-4 right-4 p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition" aria-label="Tutup Pop-up">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Modal Header -->
            <div class="text-center mb-5">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-3 shadow-md shadow-emerald-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Sepertinya anda tertarik dengan web kami
                </h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Yuk buat akun gratis sekarang untuk menerapkan alokasi 50/30/20 ini dan mulai mencatat keuangan harian Anda!
                </p>
            </div>

            <!-- Registration Form Inside Modal (No Google button) -->
            <form action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label for="modal-reg-name" class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="modal-reg-name" 
                        required 
                        placeholder="Nama Lengkap Anda"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                    >
                </div>

                <div>
                    <label for="modal-reg-email" class="block text-xs font-semibold text-slate-300 mb-1">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="modal-reg-email" 
                        required 
                        placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                    >
                </div>

                <div>
                    <label for="modal-reg-password" class="block text-xs font-semibold text-slate-300 mb-1">Kata Sandi</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="modal-reg-password" 
                        required 
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                    >
                </div>

                <div>
                    <label for="modal-reg-password-confirm" class="block text-xs font-semibold text-slate-300 mb-1">Konfirmasi Kata Sandi</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="modal-reg-password-confirm" 
                        required 
                        placeholder="Ulangi kata sandi"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                    >
                </div>

                <button type="submit" class="w-full mt-2 py-3 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 shadow-lg shadow-emerald-500/25 active:scale-[0.98] transition-all">
                    Daftar Sekarang & Terapkan Anggaran
                </button>
            </form>

            <div class="mt-4 text-center text-xs text-slate-400">
                <span>Sudah punya akun?</span>
                <button type="button" onclick="closeCalculatorModal(); switchToLogin();" class="font-bold text-emerald-400 hover:text-emerald-300 ml-1 underline underline-offset-2">
                    Masuk di sini
                </button>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="border-t border-slate-800/80 bg-slate-950 py-10 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black text-sm">
                    F
                </div>
                <span class="text-base font-bold text-white tracking-tight">FinTrack</span>
                <span class="text-xs text-slate-400">• Aplikasi Pengelolaan & Pencatatan Keuangan Modern</span>
            </div>

            <div class="flex items-center gap-6 text-xs text-slate-400">
                <a href="#fitur" class="hover:text-emerald-400 transition">Fitur</a>
                <button type="button" onclick="switchToLogin()" class="hover:text-emerald-400 transition">Masuk</button>
                <button type="button" onclick="switchToRegister()" class="hover:text-emerald-400 transition">Daftar</button>
            </div>

            <p class="text-xs text-slate-400">&copy; 2026 FinTrack. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT LOGIC -->
    <script>
        // 1. Sliding Auth Drawer Logic (Slide-in from right to left)
        function openAuthDrawer(mode) {
            const drawer = document.getElementById('auth-drawer');
            const overlay = document.getElementById('auth-drawer-overlay');
            const loginBox = document.getElementById('login-box');
            const registerBox = document.getElementById('register-box');

            if (mode === 'register') {
                if (loginBox) loginBox.classList.add('hidden');
                if (registerBox) registerBox.classList.remove('hidden');
            } else {
                if (registerBox) registerBox.classList.add('hidden');
                if (loginBox) loginBox.classList.remove('hidden');
            }

            if (overlay) {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'pointer-events-auto');
            }

            if (drawer) {
                drawer.classList.remove('translate-x-full');
                drawer.classList.add('translate-x-0');
            }

            setTimeout(() => {
                if (mode === 'register') {
                    const nameInput = document.getElementById('reg-name');
                    if (nameInput) nameInput.focus();
                } else {
                    const emailInput = document.getElementById('login-email');
                    if (emailInput) emailInput.focus();
                }
            }, 300);
        }

        function closeAuthDrawer() {
            const drawer = document.getElementById('auth-drawer');
            const overlay = document.getElementById('auth-drawer-overlay');

            if (drawer) {
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('translate-x-full');
            }

            if (overlay) {
                overlay.classList.remove('opacity-100', 'pointer-events-auto');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Backward compatibility functions
        function openAuthCard(mode) {
            openAuthDrawer(mode);
        }

        function closeAuthCard() {
            closeAuthDrawer();
        }

        function switchToLogin() {
            openAuthDrawer('login');
        }

        function switchToRegister() {
            openAuthDrawer('register');
        }

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAuthDrawer();
                closeCalculatorModal();
            }
        });

        // 2. Toggle Password Visibility Eye Icon
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // 3. Calculator 50/30/20 Logic with 3-Time Usage Pop-up Trigger
        const incomeInput = document.getElementById('incomeInput');
        const needsResult = document.getElementById('needsResult');
        const wantsResult = document.getElementById('wantsResult');
        const savingsResult = document.getElementById('savingsResult');
        const presetBtns = document.querySelectorAll('.preset-btn');

        let calculatorInteractionCount = 0;
        let calculatorModalShown = false;

        function recordCalculatorInteraction() {
            @auth
                // If user is already authenticated, don't show the register popup
                return;
            @endauth

            if (calculatorModalShown) return;

            calculatorInteractionCount++;
            if (calculatorInteractionCount >= 3) {
                calculatorModalShown = true;
                setTimeout(showCalculatorModal, 400);
            }
        }

        function showCalculatorModal() {
            const modal = document.getElementById('calculator-interest-modal');
            if (modal) {
                modal.classList.remove('hidden');
                const modalName = document.getElementById('modal-reg-name');
                if (modalName) setTimeout(() => modalName.focus(), 200);
            }
        }

        function closeCalculatorModal() {
            const modal = document.getElementById('calculator-interest-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function formatRupiah(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }

        function calculateBudget(income) {
            const val = parseFloat(income) || 0;
            if (needsResult) needsResult.textContent = formatRupiah(val * 0.50);
            if (wantsResult) wantsResult.textContent = formatRupiah(val * 0.30);
            if (savingsResult) savingsResult.textContent = formatRupiah(val * 0.20);
        }

        if (incomeInput) {
            // Track when user alters the input
            incomeInput.addEventListener('change', () => {
                recordCalculatorInteraction();
            });
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

                // Record preset click as interaction
                recordCalculatorInteraction();
            });
        });
    </script>
</body>
</html>
