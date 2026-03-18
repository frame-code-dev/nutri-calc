<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-bold text-gray-800">Setting Upah per Jabatan</h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Form tambah/edit --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4">Tambah / Update Setting</h3>
            <form method="POST" action="{{ route('salary-settings.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                           placeholder="e.g. Asisten Lapangan"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Harus sama persis dengan Jabatan di Data Relawan</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Upah per Hari (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="upah_per_hari" value="{{ old('upah_per_hari') }}" required
                           min="0" step="1000" placeholder="100000"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit"
                        class="w-full py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Simpan Setting
                </button>
            </form>
        </div>

        {{-- Tabel setting --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Daftar Setting Upah</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-4 py-3 text-left">Jabatan</th>
                            <th class="px-4 py-3 text-right">Upah/Hari</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($settings as $s)
                        <tr class="hover:bg-gray-50" x-data="{ editing: false }">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <span x-show="!editing">{{ $s->jabatan }}</span>
                                <span x-show="editing" x-cloak>
                                    <form method="POST" action="{{ route('salary-settings.update', $s) }}" class="flex gap-2">
                                        @csrf @method('PUT')
                                        <input type="text" name="jabatan" value="{{ $s->jabatan }}"
                                               class="border border-gray-200 rounded-lg px-2 py-1 text-xs w-36">
                                        <input type="number" name="upah_per_hari" value="{{ $s->upah_per_hari }}" step="1000"
                                               class="border border-gray-200 rounded-lg px-2 py-1 text-xs w-28">
                                        <button type="submit" class="text-xs font-semibold text-blue-600 hover:underline">Simpan</button>
                                        <button type="button" @click="editing=false" class="text-xs text-gray-500 hover:underline">Batal</button>
                                    </form>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-gray-700" x-show="!editing">
                                Rp{{ number_format($s->upah_per_hari, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right" x-show="!editing">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="editing=true"
                                            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('salary-settings.destroy', $s) }}" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada setting upah. Tambahkan di form kiri.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
