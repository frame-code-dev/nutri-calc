<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                        <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
                        Status Distribusi MBG
                    </h2>
                    <p class="text-sm font-bold text-gray-400 mt-2 uppercase tracking-[0.2em] ml-5">
                        Laporan Harian Penerima Manfaat
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <form method="GET" action="{{ route('distribution.index') }}" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                               class="rounded-2xl border-gray-200 bg-white shadow-sm text-sm font-medium text-gray-700 focus:ring-blue-500 transition-all px-6 py-3">
                    </form>
                    <a href="{{ route('distribution.settings') }}" class="px-6 py-3 bg-blue-600 border border-blue-500 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 text-sm font-medium text-white flex items-center gap-2 group">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Edit Alokasi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-4 gap-10">
                <!-- Main Distribution Feed (Kloters) -->
                <div class="xl:col-span-3 space-y-12">
                    @foreach($kloters as $kloter)
                        <div class="bg-white rounded-md shadow-2xl shadow-blue-900/5 border border-white overflow-hidden">
                            <div class="bg-gray-900 px-8 py-6 flex items-center justify-between">
                                <h3 class="text-xl font-black text-white uppercase tracking-widest">{{ $kloter->name }}</h3>
                                <div class="px-4 py-1.5 bg-blue-600 rounded-full">
                                    <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $kloter->distributions->count() }} Distribusi</span>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100">
                                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">No</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Sekolah / Unit</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-blue-500 uppercase tracking-widest text-center">PK</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-indigo-500 uppercase tracking-widest text-center">PB</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-emerald-500 uppercase tracking-widest text-center">Guru</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-gray-900 uppercase tracking-widest text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @php
                                            $kPk = 0; $kPb = 0; $kG = 0;
                                            $unitBreakdown = [];
                                            foreach($units as $u) { $unitBreakdown[$u->id] = ['pk' => 0, 'pb' => 0, 'guru' => 0]; }
                                        @endphp
                                        
                                        @foreach($kloter->distributions as $index => $dist)
                                            @php
                                                $sPk = $dist->calculated_pk;
                                                $sPb = $dist->calculated_pb;
                                                $sG = $dist->calculated_guru;
                                                
                                                $kPk += $sPk; $kPb += $sPb; $kG += $sG;
                                                
                                                if($dist->distribution_unit_id) {
                                                    $unitBreakdown[$dist->distribution_unit_id]['pk'] += $sPk;
                                                    $unitBreakdown[$dist->distribution_unit_id]['pb'] += $sPb;
                                                    $unitBreakdown[$dist->distribution_unit_id]['guru'] += $sG;
                                                }
                                            @endphp
                                            <tr class="hover:bg-blue-50/20 transition-colors group">
                                                <td class="px-8 py-5 text-sm font-bold text-gray-300 group-hover:text-blue-300">{{ $index + 1 }}</td>
                                                <td class="px-8 py-5">
                                                    <p class="text-sm font-black text-gray-900">{{ $dist->school->name }}{{ $dist->name ? ' ('.$dist->name.')' : '' }}</p>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $dist->unit->name ?? 'Belum Ada Unit' }}</p>
                                                </td>
                                                <td class="px-8 py-5 text-sm font-black text-gray-700 text-center">{{ number_format($sPk) }}</td>
                                                <td class="px-8 py-5 text-sm font-black text-gray-700 text-center">{{ number_format($sPb) }}</td>
                                                <td class="px-8 py-5 text-sm font-black text-gray-700 text-center">{{ number_format($sG) }}</td>
                                                <td class="px-8 py-5 text-sm font-black text-blue-600 text-center">{{ number_format($sPk + $sPb + $sG) }}</td>
                                            </tr>
                                        @endforeach
                                        
                                        <tr class="bg-gray-50/50 font-black italic">
                                            <td colspan="2" class="px-8 py-6 text-xs text-gray-900 uppercase tracking-widest">Total {{ $kloter->name }}</td>
                                            <td class="px-8 py-6 text-base text-gray-900 text-center underline decoration-blue-500 decoration-2">{{ number_format($kPk) }}</td>
                                            <td class="px-8 py-6 text-base text-gray-900 text-center underline decoration-indigo-500 decoration-2">{{ number_format($kPb) }}</td>
                                            <td class="px-8 py-6 text-base text-gray-900 text-center underline decoration-emerald-500 decoration-2">{{ number_format($kG) }}</td>
                                            <td class="px-8 py-6 text-base text-blue-600 text-center decoration-2">{{ number_format($kPk + $kPb + $kG) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Unit Summary Matrix (Visualized like bottom Excel) -->
                            <div class="px-8 py-8 border-t border-gray-100 bg-[#fefefe]">
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Distribusi Per Unit ({{ $kloter->name }})</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($units as $unit)
                                        @php $ud = $unitBreakdown[$unit->id]; @endphp
                                        <div class="bg-white rounded-md border-2 {{ $ud['pk'] + $ud['pb'] + $ud['guru'] > 0 ? 'border-gray-900' : 'border-gray-50 border-dashed' }} p-6 relative overflow-hidden group hover:scale-[1.02] transition-all">
                                            <div class="flex items-center justify-between mb-5">
                                                <span class="text-xs font-black text-gray-900 uppercase tracking-widest">{{ $unit->name }}</span>
                                                <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-black">#{{ $loop->iteration }}</span>
                                            </div>
                                            <div class="space-y-3">
                                                <div class="flex justify-between items-end border-b border-gray-50 pb-2">
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Porsi Kecil</span>
                                                    <span class="text-sm font-black text-gray-900">{{ number_format($ud['pk']) }}</span>
                                                </div>
                                                <div class="flex justify-between items-end border-b border-gray-50 pb-2">
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Porsi Besar</span>
                                                    <span class="text-sm font-black text-gray-900">{{ number_format($ud['pb']) }}</span>
                                                </div>
                                                <div class="flex justify-between items-end border-b border-gray-50 pb-2">
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Guru</span>
                                                    <span class="text-sm font-black text-gray-900">{{ number_format($ud['guru']) }}</span>
                                                </div>
                                                <div class="flex justify-between items-end pt-2">
                                                    <span class="text-[10px] font-black text-blue-600 uppercase">Total Unit</span>
                                                    <span class="text-lg font-black text-blue-600">{{ number_format($ud['pk'] + $ud['pb'] + $ud['guru']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Grand Summary Sidebar -->
                <div class="space-y-8">
                    <div class="bg-gray-900 rounded-md p-10 text-white shadow-2xl shadow-gray-900/40 sticky top-10">
                        <div class="mb-10">
                            <h3 class="text-xl font-black uppercase tracking-widest">Total Keseluruhan</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Akumulasi Seluruh Kloter</p>
                        </div>
                        
                        <div class="space-y-8">
                            <div class="relative group">
                                <div class="absolute -inset-2 bg-blue-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-all blur-xl"></div>
                                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 pl-1">Porsi Kecil (PK)</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-black">{{ number_format($summary['pk']) }}</span>
                                    <span class="text-xs font-bold text-gray-500 uppercase">Porsi</span>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute -inset-2 bg-indigo-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-all blur-xl"></div>
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1 pl-1">Porsi Besar (PB)</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-black">{{ number_format($summary['pb']) }}</span>
                                    <span class="text-xs font-bold text-gray-500 uppercase">Porsi</span>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute -inset-2 bg-emerald-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-all blur-xl"></div>
                                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1 pl-1">Total Guru</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-black">{{ number_format($summary['guru']) }}</span>
                                    <span class="text-xs font-bold text-gray-500 uppercase">Jiwa</span>
                                </div>
                            </div>

                            <div class="pt-10 border-t border-gray-800">
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Grand Total</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-5xl font-black text-blue-600">{{ number_format($summary['total']) }}</span>
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold text-white uppercase italic">Sesuai Target</p>
                                        <p class="text-[9px] text-gray-500">100.0% Terpenuhi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('distribution.export-word', ['date' => $date]) }}" class="w-full mt-12 py-4 bg-blue-600 border border-blue-500 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-blue-700 transition-all text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Sesuai Gambar (Word)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
