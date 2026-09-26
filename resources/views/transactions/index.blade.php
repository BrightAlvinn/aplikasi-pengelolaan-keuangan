@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('header_title', 'Riwayat & Manajemen Transaksi')
@section('header_subtitle', 'Kelola semua transaksi pemasukan dan pengeluaran Anda')

@section('content')
<div class="space-y-6">
    <!-- Top Stats Row (Filtered Data Summary) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Total Pemasukan (Filter)</p>
                <p class="text-xl font-bold font-heading text-[#4ABDAC] mt-0.5">Rp {{ number_format($filteredIncome, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-[#4ABDAC]/15 text-[#4ABDAC] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
        </div>
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Total Pengeluaran (Filter)</p>
                <p class="text-xl font-bold font-heading text-[#FC4A1A] mt-0.5">Rp {{ number_format($filteredExpense, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-[#FC4A1A]/15 text-[#FC4A1A] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
        </div>
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Selisih Bersih (Filter)</p>
                <p class="text-xl font-bold font-heading {{ $filteredNet >= 0 ? 'text-[#4ABDAC]' : 'text-[#FC4A1A]' }} mt-0.5">Rp {{ number_format($filteredNet, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-[#F7B733]/20 text-[#b87b00] dark:text-[#F7B733] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Action Card -->
    <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm space-y-4 transition-colors duration-300">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Cari Keterangan / Catatan</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Ketik kata kunci..." class="w-full pl-9 pr-3 py-2 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Tipe Transaksi</label>
                <select name="type" class="w-full px-3 py-2 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    <option value="">Semua Tipe</option>
                    <option value="income" {{ ($filters['type'] ?? '') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ ($filters['type'] ?? '') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Kategori</label>
                <select name="category_id" class="w-full px-3 py-2 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->type === 'income' ? 'Masuk' : 'Keluar' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="w-full px-3 py-2 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="w-full px-3 py-2 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
            </div>

            <!-- Action Buttons Row -->
            <div class="lg:col-span-6 flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-[#DFDCE3] dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-catat-primary text-xs py-2 px-4 shadow-sm">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('transactions.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition">
                        Reset
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('transactions.export', request()->query()) }}" class="btn-catat-outline text-xs py-2 px-4 shadow-xs">
                        <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Ekspor CSV</span>
                    </a>
                    <a href="{{ route('transactions.create') }}" class="btn-catat-primary text-xs py-2 px-4 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>+ Catat Transaksi</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions Table Card -->
    <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="text-xs font-bold uppercase bg-[#F8F9FB] dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-[#DFDCE3] dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Keterangan & Catatan</th>
                        <th class="py-3.5 px-4 text-right">Nominal</th>
                        <th class="py-3.5 px-4 text-center">Struk / Bukti</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DFDCE3]/60 dark:divide-slate-800 font-medium">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-[#F8F9FB] dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-4 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $tx->transaction_date->format('d M Y') }}</span>
                                <span class="block text-[10px] text-slate-400 dark:text-slate-500 font-semibold">{{ $tx->transaction_date->translatedFormat('l') }}</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" style="background-color: {{ $tx->category?->color ?? '#64748b' }}18; color: {{ $tx->category?->color ?? '#475569' }}; border: 1px solid {{ $tx->category?->color ?? '#64748b' }}35;">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $tx->category?->color ?? '#475569' }}"></span>
                                    {{ $tx->category?->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 max-w-sm">
                                <p class="text-slate-800 dark:text-slate-200 font-bold">{{ $tx->description }}</p>
                                @if($tx->notes)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-1 font-normal">{{ $tx->notes }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <span class="font-bold text-sm {{ $tx->type === 'income' ? 'text-[#4ABDAC]' : 'text-[#FC4A1A]' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} {{ $tx->formatted_amount }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                @if($tx->receipt_path)
                                    <button type="button" onclick="openReceiptModal('{{ $tx->receipt_url }}', '{{ addslashes($tx->description) }}')" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 text-[#4ABDAC] hover:bg-[#4ABDAC]/15 text-xs font-bold transition border border-[#DFDCE3] dark:border-slate-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span>Lihat</span>
                                    </button>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600 text-xs font-semibold">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('transactions.edit', $tx) }}" class="p-1.5 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] hover:border-[#4ABDAC] border border-[#DFDCE3] dark:border-slate-700 transition" title="Edit Transaksi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 text-slate-400 hover:text-[#FC4A1A] hover:bg-[#FC4A1A]/10 border border-[#DFDCE3] dark:border-slate-700 transition" title="Hapus Transaksi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 dark:text-slate-500 text-sm font-medium">
                                Tidak ada transaksi yang sesuai dengan kriteria filter Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6 pt-4 border-t border-[#DFDCE3] dark:border-slate-800">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receipt-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 dark:bg-black/75 backdrop-blur-sm">
    <div class="relative bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 animate-fade-in">
        <div class="flex items-center justify-between pb-3 border-b border-[#DFDCE3] dark:border-slate-800">
            <h3 id="modal-receipt-title" class="text-sm font-bold font-heading text-slate-900 dark:text-white truncate">Bukti Transaksi</h3>
            <button onclick="closeReceiptModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="max-h-96 overflow-auto flex items-center justify-center bg-[#F8F9FB] dark:bg-slate-950 rounded-2xl p-2 border border-[#DFDCE3] dark:border-slate-800">
            <img id="modal-receipt-img" src="" alt="Bukti Transaksi" class="max-h-80 w-auto rounded-xl object-contain hidden">
            <div id="modal-receipt-pdf" class="hidden text-center py-8">
                <svg class="w-12 h-12 text-[#FC4A1A] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <p class="text-xs text-slate-600 dark:text-slate-400 mb-3 font-medium">Dokumen PDF Terlampir</p>
                <a id="modal-receipt-link" href="#" target="_blank" class="btn-catat-primary text-xs py-2 px-4">Buka Dokumen di Tab Baru</a>
            </div>
        </div>
        <div class="flex justify-end">
            <button onclick="closeReceiptModal()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openReceiptModal(url, title) {
        const modal = document.getElementById('receipt-modal');
        const img = document.getElementById('modal-receipt-img');
        const pdf = document.getElementById('modal-receipt-pdf');
        const link = document.getElementById('modal-receipt-link');
        const modalTitle = document.getElementById('modal-receipt-title');

        modalTitle.textContent = title || 'Bukti Transaksi';

        if (url.toLowerCase().endsWith('.pdf')) {
            img.classList.add('hidden');
            pdf.classList.remove('hidden');
            link.href = url;
        } else {
            pdf.classList.add('hidden');
            img.classList.remove('hidden');
            img.src = url;
        }

        modal.classList.remove('hidden');
    }

    function closeReceiptModal() {
        document.getElementById('receipt-modal').classList.add('hidden');
    }
</script>
@endpush
