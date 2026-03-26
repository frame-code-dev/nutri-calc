<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-bold text-gray-800">Buat Periode Gaji</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('gaji-relawan.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Periode <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_periode" value="{{ old('nama_periode') }}" required
                            placeholder="e.g. Minggu KE 1 / Maret 2026"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('nama_periode')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Periode <span
                                class="text-red-500">*</span></label>
                        <select name="tipe" required
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="mingguan" {{ old('tipe') === 'mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="bulanan" {{ old('tipe') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Periode Ke- <span
                                class="text-red-500">*</span></label>
                        <select name="periode_ke" required
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach (['I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5, 'VI' => 6, 'VII' => 7, 'VIII' => 8, 'IX' => 9, 'X' => 10, 'XI' => 11, 'XII' => 12] as $roman => $val)
                                <option value="{{ $val }}" {{ old('periode_ke') == $val ? 'selected' : '' }}>
                                    {{ $roman }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Instansi</label>
                        <input type="text" name="instansi"
                            value="{{ old('instansi', 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02') }}"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-400 mt-1">Muncul di header slip gaji</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Mengetahui (Penandatangan
                            1)</label>
                        <input type="text" name="penandatangan_1"
                            value="{{ old('penandatangan_1', 'Mentari Citra Aura J, A.Md. Ak.') }}"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Menyetujui (Penandatangan
                            2)</label>
                        <input type="text" name="penandatangan_2"
                            value="{{ old('penandatangan_2', 'Ilyas Syams Sentosa, S.P.') }}"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">SPPG</label>
                        <select name="sppg_id"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Semua SPPG --</option>
                            @foreach ($sppgs as $s)
                                <option value="{{ $s->id }}" {{ old('sppg_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                        Buat Periode
                    </button>
                    <a href="{{ route('gaji-relawan.index') }}"
                        class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
