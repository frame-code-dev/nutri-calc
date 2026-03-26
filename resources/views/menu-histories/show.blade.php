<x-app-layout>
    <div class="pb-12 bg-gray-50/50 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Breadcrumb + Header --}}
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium mb-2">
                        <a href="{{ route('menu-histories.index') }}" class="hover:text-indigo-600">History</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <span>{{ $menuHistory->nomor }}</span>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight font-mono">{{ $menuHistory->nomor }}</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">{{ $menuHistory->description }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $pct = $menuHistory->completion_percent;
                        $done = $menuHistory->days->where('status','selesai')->count();
                        $total = $menuHistory->days->count();
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-2xl px-4 py-3 text-center shadow-sm">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Upload Foto</p>
                        <p class="text-2xl font-black {{ $pct >= 100 ? 'text-emerald-600' : 'text-indigo-700' }}">{{ $pct }}%</p>
                        <p class="text-[10px] text-gray-400">{{ $done }}/{{ $total }} selesai</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TABS --}}
            <div x-data="{ tab: 'menu' }">
                <div class="flex gap-1 bg-white border border-gray-200 rounded-2xl p-1.5 shadow-sm w-fit">
                    <button @click="tab='menu'"
                        :class="tab==='menu' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                        class="px-5 py-2 rounded-xl text-sm font-bold transition-all">
                        📋 Menu Harian
                    </button>
                    <button @click="tab='nota'"
                        :class="tab==='nota' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                        class="px-5 py-2 rounded-xl text-sm font-bold transition-all">
                        🧾 Nota Harian
                    </button>
                    <button @click="tab='rab'"
                        :class="tab==='rab' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                        class="px-5 py-2 rounded-xl text-sm font-bold transition-all">
                        💰 RAB
                    </button>
                </div>

                {{-- ══════════════════════ TAB: MENU ══════════════════════ --}}
                <div x-show="tab==='menu'" x-cloak class="mt-4 space-y-4">
                    <div class="flex justify-end pr-2">
                        <a href="{{ route('menu-histories.download-word', $menuHistory) }}" 
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Word
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($menuHistory->days as $day)
                            @php
                                $isSelesai = $day->status === 'selesai';
                            @endphp
                            <div class="bg-white rounded-2xl border {{ $isSelesai ? 'border-emerald-200' : 'border-gray-200' }} shadow-sm overflow-hidden">
                                {{-- Day Header --}}
                                <div class="px-5 py-3 flex items-center justify-between {{ $isSelesai ? 'bg-emerald-50' : 'bg-gray-50' }} border-b {{ $isSelesai ? 'border-emerald-100' : 'border-gray-100' }}">
                                    <div>
                                        <p class="font-black text-gray-900 text-sm">{{ $day->day_name }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $day->date->isoFormat('D MMM Y') }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $isSelesai ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $isSelesai ? 'Selesai' : 'Pending' }}
                                    </span>
                                </div>

                                {{-- Menu Name --}}
                                <div class="px-5 py-3 border-b border-gray-50">
                                    @if($day->menu)
                                        <p class="text-xs font-bold text-gray-600">{{ $day->menu->name }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $day->menu->type == 'wet' ? 'Menu Basah' : 'Menu Kering' }}</p>
                                    @else
                                        <p class="text-xs text-gray-300 italic">Menu belum diassign</p>
                                    @endif
                                </div>

                                {{-- Photo --}}
                                @if($day->photo_path)
                                    <div class="relative">
                                        <img src="{{ $day->photo_url }}" alt="Foto {{ $day->day_name }}"
                                            class="w-full h-36 object-cover">
                                        <div class="absolute top-2 right-2 bg-emerald-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase">
                                            ✓ Uploaded
                                        </div>
                                    </div>
                                    @if($day->notes)
                                        <div class="px-4 py-2 bg-gray-50">
                                            <p class="text-[10px] text-gray-500">{{ $day->notes }}</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="px-5 py-6 flex flex-col items-center justify-center text-center bg-gray-50/50">
                                        <svg class="w-8 h-8 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs text-gray-300 font-medium">Belum ada foto</p>
                                    </div>
                                @endif

                                {{-- Upload Form --}}
                                <div class="px-4 py-3 border-t border-gray-100 bg-white">
                                    <form action="{{ route('menu-histories.upload-photo', $day) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                        @csrf
                                        <div class="flex gap-2">
                                            <label class="flex-1 cursor-pointer">
                                                <input type="file" name="photo" accept="image/*" class="hidden"
                                                    onchange="this.parentElement.querySelector('span').textContent = this.files[0]?.name ?? '{{ $isSelesai ? 'Ganti foto...' : 'Pilih foto...' }}'">
                                                <div class="w-full border border-dashed border-gray-200 rounded-lg px-3 py-2 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-all group">
                                                    <span class="text-[11px] text-gray-400 group-hover:text-indigo-600 font-medium">
                                                        {{ $isSelesai ? 'Ganti foto...' : 'Pilih foto...' }}
                                                    </span>
                                                </div>
                                            </label>
                                            <button type="submit"
                                                class="px-3 py-2 {{ $isSelesai ? 'bg-gray-100 text-gray-500 hover:bg-gray-200' : 'bg-indigo-600 text-white hover:bg-indigo-700' }} text-xs font-bold rounded-lg transition-all shadow-sm">
                                                Upload
                                            </button>
                                        </div>
                                        <input type="text" name="notes" placeholder="Catatan (opsional)"
                                            value="{{ $day->notes }}"
                                            class="w-full text-xs border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 py-1.5">
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ══════════════════════ TAB: NOTA ══════════════════════ --}}
                <div x-show="tab==='nota'" x-cloak class="mt-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($menuHistory->days as $day)
                            @php
                                $isNotaSelesai = $day->nota_status === 'selesai';
                            @endphp
                            <div class="bg-white rounded-2xl border {{ $isNotaSelesai ? 'border-emerald-200' : 'border-gray-200' }} shadow-sm overflow-hidden">
                                {{-- Day Header --}}
                                <div class="px-5 py-3 flex items-center justify-between {{ $isNotaSelesai ? 'bg-emerald-50' : 'bg-gray-50' }} border-b {{ $isNotaSelesai ? 'border-emerald-100' : 'border-gray-100' }}">
                                    <div>
                                        <p class="font-black text-gray-900 text-sm">{{ $day->day_name }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $day->date->isoFormat('D MMM Y') }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $isNotaSelesai ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $isNotaSelesai ? 'Selesai' : 'Pending' }}
                                    </span>
                                </div>

                                {{-- Meta Info --}}
                                <div class="px-5 py-3 border-b border-gray-50">
                                    <p class="text-xs font-bold text-gray-600">Bukti Struk/Nota Belanja</p>
                                    <p class="text-[10px] text-gray-400">Total harian SPPG</p>
                                </div>

                                {{-- Photo Nota --}}
                                @if(!empty($day->nota_urls))
                                    <div class="p-4 grid grid-cols-2 gap-3 bg-gray-50/30">
                                        @foreach($day->nota_urls as $idx => $url)
                                            <div class="relative group">
                                                <img src="{{ $url }}" alt="Nota {{ $day->day_name }} {{ $idx+1 }}"
                                                    class="w-full h-24 object-cover rounded-xl shadow-sm border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity"
                                                    onclick="window.open('{{ $url }}', '_blank')">
                                                <form action="{{ route('menu-histories.delete-nota', [$day, $idx]) }}" method="POST" class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus foto nota ini?')" class="bg-rose-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] shadow-md hover:bg-rose-600 font-bold" title="Hapus Foto">✕</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($day->nota_notes)
                                        <div class="px-4 py-2 bg-indigo-50/50 border-t border-gray-50">
                                            <p class="text-[10px] text-gray-600 font-medium">Catatan: <span class="text-gray-900">{{ $day->nota_notes }}</span></p>
                                        </div>
                                    @endif
                                @else
                                    <div class="px-5 py-8 flex flex-col items-center justify-center text-center bg-gray-50/50">
                                        <svg class="w-8 h-8 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-xs text-gray-300 font-medium">Belum ada foto nota</p>
                                    </div>
                                @endif

                                {{-- Upload Form --}}
                                <div class="px-4 py-3 border-t border-gray-100 bg-white">
                                    <form action="{{ route('menu-histories.upload-nota', $day) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                        @csrf
                                        <div class="flex gap-2">
                                            <label class="flex-1 cursor-pointer">
                                                <input type="file" name="nota_photos[]" accept="image/*" class="hidden" multiple
                                                    onchange="this.parentElement.querySelector('span').textContent = this.files.length > 1 ? this.files.length + ' foto dipilih' : (this.files[0]?.name ?? '{{ $isNotaSelesai ? 'Tambah foto lain...' : 'Upload nota...' }}')">
                                                <div class="w-full border border-dashed border-gray-300 rounded-lg px-3 py-2 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-all group bg-gray-50/50">
                                                    <span class="text-[11px] text-gray-500 group-hover:text-indigo-600 font-medium block truncate max-w-[120px] mx-auto">
                                                        {{ $isNotaSelesai ? 'Tambah foto lain...' : 'Upload nota...' }}
                                                    </span>
                                                </div>
                                            </label>
                                            <button type="submit"
                                                class="px-3 py-2 {{ $isNotaSelesai ? 'bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-200' : 'bg-gray-800 text-white hover:bg-gray-900 border border-transparent' }} text-xs font-bold rounded-lg transition-all shadow-sm">
                                                Simpan
                                            </button>
                                        </div>
                                        <input type="text" name="nota_notes" placeholder="Catatan opsional (cth: Total Rp500rb)"
                                            value="{{ $day->nota_notes }}"
                                            class="w-full text-xs border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 py-1.5 bg-gray-50 focus:bg-white transition-colors">
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ══════════════════════ TAB: RAB ══════════════════════ --}}
                <div x-show="tab==='rab'" x-cloak class="mt-4">
                    @if(empty($dailyRabs))
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-bold text-gray-300">RAB harian belum tersedia</p>
                            <p class="text-xs text-gray-300 mt-1">Pastikan jadwal menu sudah lengkap di menu siklus.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($dailyRabs as $rabData)
                                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                                    {{-- Header per Hari --}}
                                    <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                        <div>
                                            <p class="font-black text-gray-900 text-sm">HARI {{ $loop->iteration }} ({{ mb_strtoupper($rabData['day']->day_name) }})</p>
                                            <p class="text-[10px] text-gray-500 mt-0.5">{{ $rabData['day']->date->isoFormat('D MMMM Y') }} &bull; Total {{ $rabData['totalPortions'] }} porsi (PM: {{ $rabData['porsiBesar'] }}, PK: {{ $rabData['porsiKecil'] }})</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-right">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">PAGU</p>
                                                <p class="font-black text-indigo-700">Rp {{ number_format($rabData['pagu'], 0, ',', '.') }}</p>
                                            </div>
                                            <a href="{{ route('menu-histories.print-rab', [$menuHistory, $rabData['day']]) }}" target="_blank"
                                                class="ml-3 inline-flex items-center gap-1.5 px-3 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-all border border-indigo-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                                Cetak RAB
                                            </a>
                                        </div>
                                    </div>
                                    
                                    {{-- Bahan Baku Table --}}
                                    @if(count($rabData['ingredients']) > 0)
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left">
                                                <thead>
                                                    <tr class="text-[9px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-white">
                                                        <th class="px-5 py-3">Daftar Bahan</th>
                                                        <th class="px-3 py-3 text-right">Qty</th>
                                                        <th class="px-3 py-3">Satuan</th>
                                                        <th class="px-3 py-3 text-right">Harga Beli (HET)</th>
                                                        <th class="px-3 py-3 text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-50">
                                                    @foreach($rabData['ingredients'] as $ing)
                                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                                            <td class="px-5 py-2.5 text-xs font-medium text-gray-700">{{ $ing['name'] }}</td>
                                                            <td class="px-3 py-2.5 text-xs text-gray-600 font-semibold text-right">{{ $ing['qty'] }}</td>
                                                            <td class="px-3 py-2.5 text-xs text-gray-500">{{ $ing['unit'] }}</td>
                                                            <td class="px-3 py-2.5 text-xs text-gray-500 text-right">Rp {{ number_format($ing['price'], 0, ',', '.') }}</td>
                                                            <td class="px-3 py-2.5 text-xs font-bold text-gray-800 text-right">Rp {{ number_format($ing['subtotal'], 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-gray-50/50">
                                                    <tr>
                                                        <td colspan="4" class="px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">TOTAL BELANJA</td>
                                                        <td class="px-3 py-3 text-xs font-black text-gray-900 text-right">Rp {{ number_format($rabData['totalBelanja'], 0, ',', '.') }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        
                                        {{-- Kalkulasi Summary Box --}}
                                        <div class="px-5 py-4 bg-indigo-50/50 border-t border-indigo-100 grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div>
                                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Pagu (PM+PK)</p>
                                                <p class="text-sm font-black text-indigo-700">Rp {{ number_format($rabData['pagu'], 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Selisih</p>
                                                <p class="text-sm font-black {{ $rabData['selisih'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format($rabData['selisih'], 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Harga / Porsi PM</p>
                                                <p class="text-sm font-black text-indigo-700">Rp {{ number_format($rabData['hargaPM'], 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Harga / Porsi PK</p>
                                                <p class="text-sm font-black text-indigo-700">Rp {{ number_format($rabData['hargaPK'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="px-5 py-8 text-center text-gray-400 text-xs italic">
                                            Belum ada bahan baku untuk menu hari ini.
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
