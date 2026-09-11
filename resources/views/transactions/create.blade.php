@extends('layouts.app')

@section('title', 'Catat Transaksi Baru')
@section('header_title', 'Catat Transaksi Baru')
@section('header_subtitle', 'Masukkan detail transaksi pemasukan atau pengeluaran Anda')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="p-6 md:p-8 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-2xl relative overflow-hidden">
        <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Type Selector (Income vs Expense) -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-2">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-800/80 border border-slate-700/60 rounded-2xl">
                    <label id="label-income" class="cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200">
                        <input type="radio" name="type" value="income" class="sr-only" {{ old('type', request('type', 'expense')) === 'income' ? 'checked' : '' }} onchange="switchTransactionType('income')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                        <span>Pemasukan</span>
                    </label>

                    <label id="label-expense" class="cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200">
                        <input type="radio" name="type" value="expense" class="sr-only" {{ old('type', request('type', 'expense')) === 'expense' ? 'checked' : '' }} onchange="switchTransactionType('expense')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                        <span>Pengeluaran</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount Input with Rupiah formatting preview -->
            <div>
                <label for="amount" class="block text-xs font-semibold text-slate-400 mb-1">Nominal (Rupiah) <span class="text-rose-400">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-slate-400 font-bold text-base">Rp</span>
                    <input type="text" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0" required class="w-full pl-12 pr-4 py-3 bg-slate-800/80 border border-slate-700 rounded-xl text-lg font-bold text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">
                </div>
                <p id="amount-formatted-preview" class="text-xs text-emerald-400 font-semibold mt-1.5 min-h-[1rem]"></p>
                @error('amount')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Dropdown -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="category_id" class="block text-xs font-semibold text-slate-400">Kategori <span class="text-rose-400">*</span></label>
                    <a href="{{ route('categories.index') }}" class="text-[11px] text-emerald-400 hover:underline">+ Kelola Kategori</a>
                </div>
                <select id="category_id" name="category_id" required class="w-full px-4 py-3 bg-slate-800/80 border border-slate-700 rounded-xl text-sm font-medium text-white focus:outline-none focus:border-emerald-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($incomeCategories as $cat)
                        <option value="{{ $cat->id }}" data-type="income" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                    @foreach($expenseCategories as $cat)
                        <option value="{{ $cat->id }}" data-type="expense" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Transaction Date -->
            <div>
                <label for="transaction_date" class="block text-xs font-semibold text-slate-400 mb-1">Tanggal Transaksi <span class="text-rose-400">*</span></label>
                <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required class="w-full px-4 py-3 bg-slate-800/80 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-emerald-500 transition">
                @error('transaction_date')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-slate-400 mb-1">Keterangan Singkat <span class="text-rose-400">*</span></label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" placeholder="Contoh: Beli bensin, Belanja mingguan, Pembayaran invoice..." required class="w-full px-4 py-3 bg-slate-800/80 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">
                @error('description')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes (Optional) -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-slate-400 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Tambahkan rincian bila diperlukan..." class="w-full px-4 py-3 bg-slate-800/80 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Receipt / Struk Upload -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Lampirkan Bukti / Struk (Opsional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-700 border-dashed rounded-2xl hover:border-slate-500 transition bg-slate-800/40 relative">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-xs text-slate-400 justify-center">
                            <label for="receipt" class="relative cursor-pointer rounded-md font-semibold text-emerald-400 hover:text-emerald-300">
                                <span>Pilih file</span>
                                <input id="receipt" name="receipt" type="file" accept="image/*,application/pdf" class="sr-only" onchange="previewFile(event)">
                            </label>
                            <p class="pl-1">atau tarik file ke sini</p>
                        </div>
                        <p class="text-[11px] text-slate-500">PNG, JPG, WEBP, PDF (Maks. 5MB)</p>
                    </div>
                </div>
                <div id="file-preview-box" class="hidden mt-2 p-2 bg-slate-800 rounded-xl flex items-center justify-between">
                    <span id="file-preview-name" class="text-xs text-slate-300 truncate max-w-xs"></span>
                    <button type="button" onclick="clearReceiptFile()" class="text-xs text-rose-400 hover:underline">Hapus</button>
                </div>
                @error('receipt')
                    <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('transactions.index') }}" class="px-5 py-2.5 rounded-xl font-medium text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-600/30 transition">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTransactionType(type) {
        const incomeLabel = document.getElementById('label-income');
        const expenseLabel = document.getElementById('label-expense');
        const categorySelect = document.getElementById('category_id');

        if (type === 'income') {
            incomeLabel.className = 'cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200 bg-emerald-500 text-white shadow-lg shadow-emerald-500/25';
            expenseLabel.className = 'cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-slate-400 hover:text-white';
        } else {
            expenseLabel.className = 'cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200 bg-rose-500 text-white shadow-lg shadow-rose-500/25';
            incomeLabel.className = 'cursor-pointer flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-slate-400 hover:text-white';
        }

        // Filter category dropdown options
        let firstAvailable = null;
        for (let i = 0; i < categorySelect.options.length; i++) {
            const opt = categorySelect.options[i];
            if (!opt.value) continue;
            if (opt.getAttribute('data-type') === type) {
                opt.style.display = '';
                if (!firstAvailable) firstAvailable = opt.value;
            } else {
                opt.style.display = 'none';
                if (categorySelect.value === opt.value) {
                    categorySelect.value = '';
                }
            }
        }
    }

    // Live Rupiah preview
    const amountInput = document.getElementById('amount');
    const amountPreview = document.getElementById('amount-formatted-preview');

    function updateAmountPreview() {
        let val = amountInput.value.replace(/[^0-9]/g, '');
        if (val) {
            amountPreview.textContent = '= Rp ' + new Intl.NumberFormat('id-ID').format(val);
        } else {
            amountPreview.textContent = '';
        }
    }

    amountInput.addEventListener('input', updateAmountPreview);

    function previewFile(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('file-preview-box').classList.remove('hidden');
            document.getElementById('file-preview-name').textContent = '📎 ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        }
    }

    function clearReceiptFile() {
        const input = document.getElementById('receipt');
        input.value = '';
        document.getElementById('file-preview-box').classList.add('hidden');
    }

    // Initialize state on load
    document.addEventListener('DOMContentLoaded', () => {
        const initialType = document.querySelector('input[name="type"]:checked')?.value || 'expense';
        switchTransactionType(initialType);
        updateAmountPreview();
    });
</script>
@endpush
