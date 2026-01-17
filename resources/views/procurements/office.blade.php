<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Belanja Kantor</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola inventaris dan catat pengeluaran perlengkapan kantor.</p>
                </div>
                <div>
                    <a href="{{ route('procurements.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Daftar Belanja Bahan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Input Form -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 overflow-hidden">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Catat Transaksi</h3>
                        </div>

                        <form action="{{ route('procurements.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Transaksi</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" 
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                            </div>

                            <div x-data="{ 
                                open: false, 
                                search: '', 
                                selectedId: '', 
                                selectedName: 'Pilih Item Office...',
                                items: @js($officeItems)
                            }">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Item (Kategori Office)</label>
                                
                                <div class="relative">
                                    <button type="button" @click="open = !open" 
                                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm text-left">
                                        <span x-text="selectedName" :class="selectedId ? 'text-gray-900' : 'text-gray-400'"></span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <!-- Improved Select Dropdown -->
                                    <div x-show="open" @click.away="open = false" 
                                        class="absolute z-50 mt-2 w-full bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                                        <div class="p-2 border-b border-gray-50 bg-gray-50/50">
                                            <input type="text" x-model="search" placeholder="Cari item..." 
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-blue-500 transition-all">
                                        </div>
                                        <div class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                            <template x-for="item in items.filter(i => i.name.toLowerCase().includes(search.toLowerCase()))" :key="item.id">
                                                <button type="button" @click="selectedId = item.id; selectedName = item.name + ' (' + item.unit + ')'; open = false"
                                                    class="w-full text-left px-3 py-2.5 rounded-lg text-xs font-bold transition-all hover:bg-blue-50 hover:text-blue-700 flex items-center justify-between group">
                                                    <span x-text="item.name"></span>
                                                    <span x-text="item.unit" class="text-[10px] text-gray-400 group-hover:text-blue-400 uppercase tracking-widest"></span>
                                                </button>
                                            </template>
                                            <div x-show="items.filter(i => i.name.toLowerCase().includes(search.toLowerCase())).length === 0" 
                                                class="px-3 py-8 text-center">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Item tidak ditemukan</p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="raw_material_id" :value="selectedId" required>
                                </div>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-2 px-1">Gunakan kategori "office" di data bahan baku.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jumlah Beli</label>
                                    <input type="number" step="0.01" name="quantity" required
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Harga Unit</label>
                                    <input type="number" step="0.01" name="price_per_unit" required
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-[0.98] mt-2 group flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-blue-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Transaksi
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: History Table -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden min-h-[500px] flex flex-col">
                        <div class="px-8 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Riwayat Belanja</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total pengeluaran tercatat</p>
                            </div>
                        </div>

                        <div class="flex-1 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 px-2">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th scope="col" class="px-8 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Waktu</th>
                                        <th scope="col" class="px-8 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Informasi Item</th>
                                        <th scope="col" class="px-8 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Banyaknya</th>
                                        <th scope="col" class="px-8 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Biaya</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($procurements as $proc)
                                        <tr class="group hover:bg-gray-50/50 transition-all duration-200">
                                            <td class="px-8 py-5 whitespace-nowrap">
                                                <div class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($proc->date)->format('d M Y') }}</div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="text-sm font-black text-gray-900 tracking-tight">{{ $proc->rawMaterial->name }}</div>
                                            </td>
                                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-1.5">
                                                    <span class="text-sm font-bold text-gray-900 tracking-tighter">{{ number_format($proc->quantity, 2) }}</span>
                                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-1.5 py-0.5 rounded-md border border-gray-100">{{ $proc->rawMaterial->unit }}</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                                <div class="text-sm font-black text-blue-600 tracking-tighter">Rp {{ number_format($proc->total_cost, 0, ',', '.') }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-8 py-20 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-200">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    </div>
                                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada riwayat</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($procurements->hasPages())
                            <div class="px-8 py-4 border-t border-gray-50 bg-gray-50/20">
                                {{ $procurements->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Scrollbar Style -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</x-app-layout>
