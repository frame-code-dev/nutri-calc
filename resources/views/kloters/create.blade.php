<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Kloter Baru</h2>
                    <p class="text-sm text-gray-500 mt-1">Buat kelompok sekolah baru untuk distribusi makanan</p>
                </div>
                <a href="{{ route('kloters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <!-- Form -->
            <form action="{{ route('kloters.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Dasar</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Kloter <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium"
                                placeholder="Contoh: Kloter 1">
                            @error('name') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal (Opsional)</label>
                            <input type="date" name="date" id="date" value="{{ old('date') }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium">
                            @error('date') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium"
                                placeholder="Tuliskan deskripsi singkat...">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-end pb-2">
                            <label class="inline-flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </div>
                                <span class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">Kloter Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>


                <!-- Action Footer -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('kloters.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95">
                        Simpan Kloter
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
