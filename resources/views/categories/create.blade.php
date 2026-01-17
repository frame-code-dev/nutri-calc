<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            <!-- Breadcrumbs/Back -->
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-blue-600 transition-colors mb-6 group">
                <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar
            </a>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Tambah Kategori Baru</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Definisikan kelompok bahan baku baru.</p>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Kategori</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                            placeholder="Contoh: Sayuran, Daging, Alat Tulis">
                        @error('name')
                            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-tight mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none"
                            placeholder="Berikan penjelasan singkat mengenai kategori ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-tight mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-widest py-4 rounded-2xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 text-blue-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
