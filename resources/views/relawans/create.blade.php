<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-bold text-gray-800">Tambah Relawan</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('relawans.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-400 @enderror">
                        @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                               placeholder="e.g. Asisten Lapangan"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jabatan') border-red-400 @enderror">
                        @error('jabatan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                        <select name="tipe" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="tetap" {{ old('tipe') === 'tetap' ? 'selected' : '' }}>Relawan Tetap</option>
                            <option value="magang" {{ old('tipe') === 'magang' ? 'selected' : '' }}>Tenaga Magang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Urut <span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_urut" value="{{ old('nomor_urut', 1) }}" min="1" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">SPPG</label>
                        <select name="sppg_id" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih SPPG --</option>
                            @foreach($sppgs as $s)
                            <option value="{{ $s->id }}" {{ old('sppg_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', '1') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        <label for="aktif" class="text-sm font-semibold text-gray-700">Aktif</label>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('relawans.index') }}"
                       class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
