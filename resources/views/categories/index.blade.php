@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('header_title', 'Manajemen Kategori')
@section('header_subtitle', 'Kelola kategori pemasukan dan pengeluaran Anda')

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl">
        <div>
            <h2 class="text-lg font-bold text-white">Daftar Kategori Transaksi</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kelompokkan arus transaksi agar analisis keuangan lebih teratur.</p>
        </div>
        <button type="button" onclick="openCategoryModal('create')" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-md shadow-emerald-600/30 flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>+ Tambah Kategori Baru</span>
        </button>
    </div>

    <!-- Category Columns Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengeluaran Categories Column -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Kategori Pengeluaran</h3>
                        <p class="text-[11px] text-slate-400">{{ $expenseCategories->count() }} kategori terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5">
                @forelse($expenseCategories as $cat)
                    <div class="p-3.5 rounded-2xl bg-slate-800/50 border border-slate-700/60 flex items-center justify-between hover:border-slate-600 transition group">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full shrink-0 shadow-sm" style="background-color: {{ $cat->color }}"></span>
                            <div>
                                <span class="text-sm font-semibold text-white">{{ $cat->name }}</span>
                                <span class="block text-[11px] text-slate-400">{{ $cat->transactions_count }} transaksi</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 opacity-80 group-hover:opacity-100 transition">
                            <button type="button" onclick="editCategory({{ json_encode($cat) }})" class="p-1.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white transition" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-slate-700 text-slate-400 hover:text-rose-400 hover:bg-rose-500/20 transition" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada kategori pengeluaran.</p>
                @endforelse
            </div>
        </div>

        <!-- Pemasukan Categories Column -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800/80 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Kategori Pemasukan</h3>
                        <p class="text-[11px] text-slate-400">{{ $incomeCategories->count() }} kategori terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5">
                @forelse($incomeCategories as $cat)
                    <div class="p-3.5 rounded-2xl bg-slate-800/50 border border-slate-700/60 flex items-center justify-between hover:border-slate-600 transition group">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full shrink-0 shadow-sm" style="background-color: {{ $cat->color }}"></span>
                            <div>
                                <span class="text-sm font-semibold text-white">{{ $cat->name }}</span>
                                <span class="block text-[11px] text-slate-400">{{ $cat->transactions_count }} transaksi</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 opacity-80 group-hover:opacity-100 transition">
                            <button type="button" onclick="editCategory({{ json_encode($cat) }})" class="p-1.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white transition" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-slate-700 text-slate-400 hover:text-rose-400 hover:bg-rose-500/20 transition" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada kategori pemasukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Kategori (Create / Edit) -->
<div id="category-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 id="modal-category-title" class="text-base font-bold text-white">Tambah Kategori Baru</h3>
            <button onclick="closeCategoryModal()" class="text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="category-form" action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div id="category-form-method"></div>

            <!-- Name -->
            <div>
                <label for="cat-name" class="block text-xs font-semibold text-slate-400 mb-1">Nama Kategori <span class="text-rose-400">*</span></label>
                <input type="text" id="cat-name" name="name" required placeholder="Contoh: Belanja Online, Servis Kendaraan..." class="w-full px-3.5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">
            </div>

            <!-- Type -->
            <div>
                <label for="cat-type" class="block text-xs font-semibold text-slate-400 mb-1">Jenis Kategori <span class="text-rose-400">*</span></label>
                <select id="cat-type" name="type" required class="w-full px-3.5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-emerald-500 transition">
                    <option value="expense">Pengeluaran</option>
                    <option value="income">Pemasukan</option>
                </select>
            </div>

            <!-- Color with presets -->
            <div>
                <label for="cat-color" class="block text-xs font-semibold text-slate-400 mb-1.5">Warna Penanda <span class="text-rose-400">*</span></label>
                <div class="flex items-center gap-3">
                    <input type="color" id="cat-color" name="color" value="#10b981" class="w-10 h-10 rounded-xl bg-transparent border-0 cursor-pointer">
                    <div class="flex flex-wrap gap-2">
                        @foreach(['#ef4444', '#f97316', '#f59e0b', '#10b981', '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899', '#64748b'] as $presetColor)
                            <button type="button" onclick="selectColor('{{ $presetColor }}')" class="w-6 h-6 rounded-full border border-slate-700 hover:scale-110 transition shadow" style="background-color: {{ $presetColor }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-md shadow-emerald-600/30 transition">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('category-modal');
    const form = document.getElementById('category-form');
    const title = document.getElementById('modal-category-title');
    const methodContainer = document.getElementById('category-form-method');

    function openCategoryModal(mode) {
        if (mode === 'create') {
            title.textContent = 'Tambah Kategori Baru';
            form.action = "{{ route('categories.store') }}";
            methodContainer.innerHTML = '';
            document.getElementById('cat-name').value = '';
            document.getElementById('cat-type').value = 'expense';
            document.getElementById('cat-color').value = '#10b981';
        }
        modal.classList.remove('hidden');
    }

    function editCategory(cat) {
        title.textContent = 'Edit Kategori';
        form.action = "/categories/" + cat.id;
        methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('cat-name').value = cat.name;
        document.getElementById('cat-type').value = cat.type;
        document.getElementById('cat-color').value = cat.color;
        modal.classList.remove('hidden');
    }

    function closeCategoryModal() {
        modal.classList.add('hidden');
    }

    function selectColor(color) {
        document.getElementById('cat-color').value = color;
    }
</script>
@endpush
