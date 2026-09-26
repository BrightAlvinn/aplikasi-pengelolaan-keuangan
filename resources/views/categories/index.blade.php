@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('header_title', 'Manajemen Kategori')
@section('header_subtitle', 'Kelola kategori pemasukan dan pengeluaran Anda')

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm transition-colors duration-300">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#eaf7f5] dark:bg-teal-950/40 text-[#2e7e73] dark:text-[#4ABDAC] text-xs font-bold mb-1.5 border border-[#4ABDAC]/30">
                Kategori Transaksi
            </span>
            <h2 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Daftar Kategori Finansial</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelompokkan arus transaksi agar analisis keuangan lebih teratur dan mudah dipantau.</p>
        </div>
        <button type="button" onclick="openCategoryModal('create')" class="btn-catat-primary text-xs sm:text-sm py-2.5 px-5 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>+ Tambah Kategori Baru</span>
        </button>
    </div>

    <!-- Category Columns Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengeluaran Categories Column -->
        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm space-y-4 transition-colors duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-[#DFDCE3] dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-[#FC4A1A]/15 text-[#FC4A1A] border border-[#FC4A1A]/30 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold font-heading text-slate-900 dark:text-white">Kategori Pengeluaran</h3>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold">{{ $expenseCategories->count() }} kategori terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5">
                @forelse($expenseCategories as $cat)
                    <div class="p-3.5 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800 flex items-center justify-between hover:border-[#FC4A1A]/50 transition group">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full shrink-0 shadow-sm" style="background-color: {{ $cat->color }}"></span>
                            <div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $cat->name }}</span>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ $cat->transactions_count }} transaksi tercatat</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 opacity-90 group-hover:opacity-100 transition">
                            <button type="button" onclick="editCategory({{ json_encode($cat) }})" class="p-1.5 rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] hover:border-[#4ABDAC] border border-[#DFDCE3] dark:border-slate-700 transition shadow-xs" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:text-[#FC4A1A] hover:bg-[#FC4A1A]/10 border border-[#DFDCE3] dark:border-slate-700 transition shadow-xs" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-6 font-medium">Belum ada kategori pengeluaran.</p>
                @endforelse
            </div>
        </div>

        <!-- Pemasukan Categories Column -->
        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 shadow-sm space-y-4 transition-colors duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-[#DFDCE3] dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-[#4ABDAC]/15 text-[#4ABDAC] border border-[#4ABDAC]/30 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold font-heading text-slate-900 dark:text-white">Kategori Pemasukan</h3>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold">{{ $incomeCategories->count() }} kategori terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5">
                @forelse($incomeCategories as $cat)
                    <div class="p-3.5 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950/70 border border-[#DFDCE3] dark:border-slate-800 flex items-center justify-between hover:border-[#4ABDAC]/50 transition group">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full shrink-0 shadow-sm" style="background-color: {{ $cat->color }}"></span>
                            <div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $cat->name }}</span>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ $cat->transactions_count }} transaksi tercatat</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 opacity-90 group-hover:opacity-100 transition">
                            <button type="button" onclick="editCategory({{ json_encode($cat) }})" class="p-1.5 rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] hover:border-[#4ABDAC] border border-[#DFDCE3] dark:border-slate-700 transition shadow-xs" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:text-[#FC4A1A] hover:bg-[#FC4A1A]/10 border border-[#DFDCE3] dark:border-slate-700 transition shadow-xs" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-6 font-medium">Belum ada kategori pemasukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Kategori (Create / Edit) -->
<div id="category-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 dark:bg-black/75 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 animate-fade-in">
        <div class="flex items-center justify-between pb-3 border-b border-[#DFDCE3] dark:border-slate-800">
            <h3 id="modal-category-title" class="text-base font-bold font-heading text-slate-900 dark:text-white">Tambah Kategori Baru</h3>
            <button onclick="closeCategoryModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="category-form" action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div id="category-form-method"></div>

            <!-- Name -->
            <div>
                <label for="cat-name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Nama Kategori <span class="text-[#FC4A1A]">*</span></label>
                <input type="text" id="cat-name" name="name" required placeholder="Contoh: Belanja Online, Makanan..." class="w-full px-3.5 py-2.5 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
            </div>

            <!-- Type -->
            <div>
                <label for="cat-type" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Jenis Kategori <span class="text-[#FC4A1A]">*</span></label>
                <select id="cat-type" name="type" required class="w-full px-3.5 py-2.5 bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-white focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition">
                    <option value="expense">Pengeluaran</option>
                    <option value="income">Pemasukan</option>
                </select>
            </div>

            <!-- Color with presets -->
            <div>
                <label for="cat-color" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Warna Penanda <span class="text-[#FC4A1A]">*</span></label>
                <div class="flex items-center gap-3">
                    <input type="color" id="cat-color" name="color" value="#4ABDAC" class="w-10 h-10 rounded-xl bg-transparent border-0 cursor-pointer">
                    <div class="flex flex-wrap gap-2">
                        @foreach(['#4ABDAC', '#FC4A1A', '#F7B733', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#ef4444', '#64748b'] as $presetColor)
                            <button type="button" onclick="selectColor('{{ $presetColor }}')" class="w-6 h-6 rounded-full border border-white dark:border-slate-700 hover:scale-110 transition shadow" style="background-color: {{ $presetColor }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#DFDCE3] dark:border-slate-800">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit" class="btn-catat-primary text-xs py-2 px-5 shadow-sm">
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
            document.getElementById('cat-color').value = '#4ABDAC';
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
