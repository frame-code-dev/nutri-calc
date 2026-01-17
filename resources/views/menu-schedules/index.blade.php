<x-app-layout>
    <div class="pb-12 bg-gray-50/50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header & Week Selector -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Siklus Menu</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Minggu ke-{{ $weekNumber }}, {{ $year }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('menu-schedules.index') }}" class="flex flex-wrap items-center gap-2">
                        <select name="school_id" class="rounded-xl border-gray-200 bg-white text-gray-700 text-sm font-bold focus:border-blue-500 focus:ring-blue-500 py-2 pl-4 pr-10 transition-all duration-200" onchange="this.form.submit()">
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach($schoolsWithCalendars as $school)
                                <option value="{{ $school->id }}" {{ ($selectedSchool?->id == $school->id) ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="week" class="rounded-xl border-gray-200 bg-white text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2 transition-all duration-200" onchange="this.form.submit()">
                            @for($i = 1; $i <= 52; $i++)
                                <option value="{{ $i }}" {{ $weekNumber == $i ? 'selected' : '' }}>Minggu {{ $i }}</option>
                            @endfor
                        </select>
                        <select name="year" class="rounded-xl border-gray-200 bg-white text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2 transition-all duration-200" onchange="this.form.submit()">
                            @for($y = 2024; $y <= 2026; $y++)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Portions Card -->
                <div class="bg-white rounded p-6 border shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Porsi</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ number_format($totalPortions) }}</h3>
                    </div>
                </div>

                <!-- Cost Card -->
                <div class="bg-white rounded p-6 border shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Biaya</p>
                        <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalCost) }}</h3>
                    </div>
                </div>

                {{-- <!-- RAB Status Card -->
                <div class="bg-white rounded p-6 border shadow-sm flex items-center gap-4 lg:col-span-2">
                    <div class="w-12 h-12 {{ $remainingRab >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sisa RAB (Mingguan)</p>
                        <h3 class="text-2xl font-black {{ $remainingRab >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            Rp {{ number_format($remainingRab) }}
                        </h3>
                    </div>
                </div> --}}
            </div>

            <!-- Budget Progress -->
            @if($totalRab > 0)
            <div class="bg-white rounded p-8 border shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-700">Progress Anggaran ({{ $selectedSchool?->name }})</h3>
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ number_format($budgetProgress, 1) }}% dari RAB</span>
                </div>
                <div class="relative w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                    <div class="absolute inset-y-0 left-0 {{ $budgetProgress > 100 ? 'bg-rose-500' : 'bg-emerald-500' }} rounded-full transition-all duration-1000" style="width: {{ min($budgetProgress, 100) }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold text-gray-400 tracking-widest uppercase">
                    <span>Terpakai: Rp {{ number_format($totalCost) }}</span>
                    <span>Total RAB: Rp {{ number_format($totalRab) }}</span>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Matrix Assignment Menu -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded p-8 border shadow-sm relative overflow-hidden">
                        <div class="flex flex-col gap-1 mb-8">
                            <h3 class="text-xl font-black text-gray-900">Matrix Assignment Menu</h3>
                            <p class="text-sm font-medium text-gray-500">
                                @if($selectedSchool)
                                    Jadwal untuk <strong>{{ $selectedSchool->name }}</strong>
                                @else
                                    Silakan pilih sekolah untuk memulai assignment
                                @endif
                            </p>
                        </div>

                        <form action="{{ route('menu-schedules.store') }}" method="POST" id="assignForm" class="space-y-8">
                            @csrf
                            <input type="hidden" name="week" value="{{ $weekNumber }}">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <input type="hidden" name="school_id" value="{{ $selectedSchool?->id }}">
                            
                            <div class="flex flex-wrap gap-4 justify-between">
                                @foreach($days as $index => $day)
                                    @php
                                        $dateStr = $dates[$index];
                                        $status = $dayStatuses[$dateStr] ?? 'pending';
                                        $assignedMenuId = $selectedMenus[$dateStr] ?? null;
                                        $assignedMenu = null;
                                        if($assignedMenuId) {
                                            $assignedMenu = \App\Models\Menu::find($assignedMenuId);
                                        }
                                    @endphp
                                    <div class="flex-1 min-w-[120px] space-y-4 text-center relative group">
                                        <div class="space-y-1">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $day }}</p>
                                            <p class="text-[9px] text-gray-400 font-medium">{{ Carbon\Carbon::parse($dateStr)->format('d M Y') }}</p>
                                            <p class="text-[10px] font-medium text-gray-300" id="menu-name-{{ $index }}">
                                                @if($status === 'holiday')
                                                    <span class="text-rose-400 font-black uppercase">Libur</span>
                                                @else
                                                    {{ $assignedMenu ? $assignedMenu->name : 'Belum Dipilih' }}
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <div class="relative {{ $status === 'holiday' ? 'cursor-not-allowed' : 'cursor-pointer' }}" 
                                             @if($status !== 'holiday') onclick="openMenuModal({{ $index }}, '{{ $dates[$index] }}')" @endif>
                                            <input type="hidden" name="assignments[{{ $index }}][date]" value="{{ $dates[$index] }}">
                                            <input type="hidden" name="assignments[{{ $index }}][menu_id]" id="menu-id-{{ $index }}" value="{{ $assignedMenuId }}">
                                            
                                            <div id="btn-{{ $index }}" class="w-full py-3 rounded-xl border-2 transition-all flex items-center justify-center 
                                                {{ $status === 'holiday' ? 'border-rose-100 bg-rose-50 text-rose-300' : 
                                                   ($assignedMenu ? ($assignedMenu->type == 'wet' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-orange-500 bg-orange-50 text-orange-600') : 'border-dashed border-gray-200 text-gray-300 hover:border-blue-400 hover:text-blue-500') }}">
                                                @if($status === 'holiday')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                @elseif($assignedMenu)
                                                    <span class="font-black text-[10px] uppercase">{{ $assignedMenu->type == 'wet' ? 'Basah' : 'Kering' }}</span>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                @endif
                                            </div>
                                        </div>

                                        @if($assignedMenuId && $status !== 'holiday')
                                            <button type="button" onclick="clearDayAssignment('{{ $dates[$index] }}')" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-black text-sm rounded-2xl shadow-lg hover:bg-black transition-all">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                        
                        <form id="clearForm" action="{{ route('menu-schedules.clear') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="date" id="clearDateInput">
                            <input type="hidden" name="school_id" value="{{ $selectedSchool?->id }}">
                        </form>
                    </div>

                    <!-- Allergy Monitoring Table -->
                    <div class="bg-white rounded p-8 border shadow-sm">
                        <h3 class="text-xl font-black text-gray-900 mb-6">Monitoring Menu Alergi</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">
                                        <th class="pb-4">Sekolah</th>
                                        <th class="pb-4">Tanggal</th>
                                        <th class="pb-4">Menu Utama</th>
                                        <th class="pb-4">Menu Pengganti (Alergi)</th>
                                        <th class="pb-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($allCalendars as $cal)
                                        <tr>
                                            <td class="py-4 font-bold text-gray-700 text-sm">{{ $cal->school->name }}</td>
                                            <td class="py-4 text-sm text-gray-500">{{ $cal->date->format('d/m') }}</td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">{{ $cal->menu->name ?? '-' }}</span>
                                            </td>
                                            <td class="py-4">
                                                @if($cal->allergyMenu)
                                                    <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold">{{ $cal->allergyMenu->name }}</span>
                                                @else
                                                    <span class="text-xs text-gray-300 italic">Belum diatur</span>
                                                @endif
                                            </td>
                                            <td class="py-4 text-right">
                                                <button onclick="openAllergyModal({{ $cal->id }}, '{{ $cal->school->name }}', '{{ $cal->date->format('Y-m-d') }}')" class="p-2 hover:bg-rose-50 rounded-xl group transition-all">
                                                    <svg class="w-5 h-5 text-gray-300 group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Raw Material Requirements -->
                <div class="space-y-6">
                    <div class="bg-white rounded p-8 border shadow-sm relative overflow-hidden h-full">
                        <div class="flex flex-col gap-1 mb-8">
                            <h3 class="text-xl font-black text-gray-900">Kebutuhan Bahan Baku</h3>
                            <p class="text-sm font-medium text-gray-500">Estimasi berdasarkan assignment</p>
                        </div>

                        @if(empty($materialRequirements))
                            <div class="flex flex-col items-center justify-center py-12 text-center opacity-30">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <p class="text-sm font-bold">Assign menu untuk melihat bahan</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($materialRequirements as $id => $mat)
                                    @php $isShortage = $mat['needed'] > $mat['stock']; @endphp
                                    <div class="flex items-center justify-between group">
                                        <div class="space-y-0.5">
                                            <h4 class="text-sm font-bold text-gray-800">{{ $mat['name'] }}</h4>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">@ Rp {{ number_format($mat['price']) }}/{{ $mat['unit'] }}</p>
                                        </div>
                                        <div class="text-right space-y-1">
                                            <p class="text-sm font-black text-gray-900">{{ number_format($mat['needed'], 1) }} {{ $mat['unit'] }}</p>
                                            <div class="flex items-center justify-end gap-1.5">
                                                <span class="text-[9px] font-black uppercase text-gray-400">{{ number_format($mat['stock']) }} STOK</span>
                                                @if($isShortage)
                                                    <span class="px-1.5 py-0.5 bg-rose-50 text-rose-500 rounded text-[9px] font-black uppercase">Kurang {{ number_format($mat['needed'] - $mat['stock'], 1) }}</span>
                                                @else
                                                    <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-500 rounded text-[9px] font-black uppercase">Cukup</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Selection Modal -->
    <div id="menuModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="menuModalContent">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="modalDayName">Pilih Menu</h3>
                        <p class="text-sm font-medium text-gray-400" id="modalDateDisplay"></p>
                    </div>
                    <button onclick="closeMenuModal()" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-8">
                    @foreach($menuGroups as $type => $group)
                        <div class="space-y-4">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori: {{ $type }}</h4>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($group as $menu)
                                    <button type="button" onclick="selectMenuForDay({{ $menu->id }}, '{{ $menu->name }}', '{{ $type }}')" class="p-4 rounded border-2 hover:border-blue-500 hover:bg-blue-50 transition-all text-left group">
                                        <p class="text-sm font-bold text-gray-700 group-hover:text-blue-700">{{ $menu->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium">Bahan Baku Lengkap</p>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Allergy Modal -->
    <div id="allergyModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[40px] w-full max-w-md overflow-hidden shadow-2xl" id="allergyModalContent">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Atur Menu Alergi</h3>
                        <p class="text-sm font-medium text-gray-400" id="allergySchoolName"></p>
                    </div>
                    <button onclick="closeAllergyModal()" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('nutritionist.save-allergy') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="calendar_id" id="allergyCalendarId">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Menu Pengganti</label>
                        <select name="allergy_menu_id" required class="w-full rounded-2xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                            <option value="">Pilih Menu Pengganti...</option>
                            @foreach($menuGroups as $type => $group)
                                <optgroup label="{{ $type }}">
                                    @foreach($group as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan Alergi</label>
                        <textarea name="allergy_notes" rows="3" class="w-full rounded-2xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-3" placeholder="Contoh: Pengganti menu ayam bagi siswa alergi seafood..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white font-black text-sm rounded-2xl shadow-lg hover:bg-rose-700 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDayIndex = null;
        let days = @json($days);

        function openMenuModal(index, date) {
            currentDayIndex = index;
            document.getElementById('modalDayName').innerText = 'Pilih Menu ' + days[index];
            document.getElementById('modalDateDisplay').innerText = date;
            
            const modal = document.getElementById('menuModal');
            const content = document.getElementById('menuModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeMenuModal() {
            const content = document.getElementById('menuModalContent');
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                document.getElementById('menuModal').classList.add('hidden');
            }, 300);
        }

        function selectMenuForDay(id, name, type) {
            document.getElementById('menu-id-' + currentDayIndex).value = id;
            document.getElementById('menu-name-' + currentDayIndex).innerText = name;
            
            const btn = document.getElementById('btn-' + currentDayIndex);
            btn.innerHTML = `<span class="font-black text-[10px] uppercase">${type}</span>`;
            if (type === 'Basah') {
                btn.className = "w-full py-3 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-600 flex items-center justify-center transition-all";
            } else {
                btn.className = "w-full py-3 rounded-xl border-2 border-orange-500 bg-orange-50 text-orange-600 flex items-center justify-center transition-all";
            }
            closeMenuModal();
        }

        function clearDayAssignment(date) {
            const schoolName = '{{ $selectedSchool?->name ?? 'Sekolah' }}';
            if(confirm('Hapus assignment menu untuk tanggal ' + date + ' di ' + schoolName + '?')) {
                document.getElementById('clearDateInput').value = date;
                document.getElementById('clearForm').submit();
            }
        }

        function openAllergyModal(calId, schoolName, date) {
            document.getElementById('allergyCalendarId').value = calId;
            document.getElementById('allergySchoolName').innerText = schoolName + ' - ' + date;
            document.getElementById('allergyModal').classList.remove('hidden');
        }

        function closeAllergyModal() {
            document.getElementById('allergyModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
