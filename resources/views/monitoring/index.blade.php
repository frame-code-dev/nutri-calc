<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Monitoring & Kunci</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Pantau progres pengisian jadwal sekolah</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('monitoring.index') }}" class="flex items-center gap-2">
                        <input type="number" name="week" value="{{ $weekNumber }}" class="w-20 rounded-xl border-gray-200 bg-white text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2 transition-all duration-200" placeholder="Minggu">
                        <input type="number" name="year" value="{{ $year }}" class="w-24 rounded-xl border-gray-200 bg-white text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2 transition-all duration-200" placeholder="Tahun">
                        <button type="submit" class="p-2 bg-gray-900 text-white rounded-xl hover:bg-black transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lock Info Card -->
            <div class="bg-blue-600 rounded-[10px] p-8 text-white relative overflow-hidden shadow-xl shadow-blue-200/50">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <h3 class="text-xl font-black">Kendali Penguncian Jadwal</h3>
                        <p class="text-blue-100 text-sm font-medium opacity-90">Kunci jadwal untuk menghentikan perubahan data oleh Koordinator Sekolah.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="px-6 py-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Total Sekolah</p>
                            <p class="text-2xl font-black">{{ count($monitoringData) }}</p>
                        </div>
                        <div class="px-6 py-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Terkunci</p>
                            <p class="text-2xl font-black">{{ $monitoringData->where('is_locked', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <!-- Abstract patterns -->
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Monitoring Table -->
            <div class="bg-white rounded-[10px] border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50/50">
                            <th class="px-8 py-6">Informasi Sekolah</th>
                            <th class="px-8 py-6">Koordinator</th>
                            <th class="px-8 py-6 text-center">Progres Data</th>
                            <th class="px-8 py-6 text-center">WhatsApp</th>
                            <th class="px-8 py-6 text-right">Kontrol Kunci</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($monitoringData as $data)
                            <tr class="group hover:bg-gray-50/50 transition-all duration-300 {{ $data['is_locked'] ? 'bg-rose-50/10' : '' }}">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black {{ $data['is_locked'] ? 'bg-rose-100 text-rose-600' : 'bg-blue-100 text-blue-600' }}">
                                            {{ substr($data['school']->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors">{{ $data['school']->name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $data['school']->student_count }} Siswa</span>
                                                @if($data['is_locked'])
                                                    <span class="w-1 h-1 bg-rose-300 rounded-full"></span>
                                                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Locked</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <h4 class="text-sm font-bold text-gray-700">{{ $data['coordinator_name'] }}</h4>
                                    <p class="text-xs font-bold text-gray-400 mt-0.5">{{ $data['coordinator_phone'] ?: '-' }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-full max-w-[100px] h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full {{ $data['is_complete'] ? 'bg-emerald-500' : 'bg-amber-400' }}" style="width: {{ ($data['filled_days']/6)*100 }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest {{ $data['is_complete'] ? 'text-emerald-500' : 'text-amber-500' }}">
                                            {{ $data['filled_days'] }}/6 HARI
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if(!$data['is_complete'])
                                        <a href="{{ route('monitoring.wa-reminder', ['school' => $data['school']->id, 'week' => $weekNumber]) }}" 
                                           target="_blank"
                                           class="inline-flex items-center justify-center w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all duration-300">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.371-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487 2.982 1.288 3.601 1.054 4.244.98.644-.075 1.758-.718 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        </a>
                                    @else
                                        <div class="w-10 h-10 mx-auto flex items-center justify-center bg-gray-50 text-gray-300 rounded-xl">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($data['is_locked'])
                                        <form action="{{ route('monitoring.unlock-school') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="school_id" value="{{ $data['school']->id }}">
                                            <input type="hidden" name="week" value="{{ $weekNumber }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <button type="submit" class="px-5 py-2.5 bg-rose-50 text-rose-600 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-rose-600 hover:text-white transition-all" onclick="return confirm('Buka kunci untuk sekolah ini?')">
                                                🔓 Buka Kunci
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('monitoring.lock-school') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="school_id" value="{{ $data['school']->id }}">
                                            <input type="hidden" name="week" value="{{ $weekNumber }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-black transition-all" onclick="return confirm('Kunci sekolah ini? Koordinator tidak bisa mengubah data.')">
                                                🔒 Kunci Data
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary Text -->
            <div class="px-8 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">
                Total {{ count($monitoringData) }} sekolah terdaftar dalam sistem monitoring.
            </div>
        </div>
    </div>
</x-app-layout>
