<!-- Menu Selection Modal -->
<div id="menuModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="menuModalContent">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight" id="modalDayName">Pilih Menu</h3>
                <p class="text-xs font-medium text-gray-400" id="modalDateDisplay"></p>
            </div>
            <button onclick="closeMenuModal()" class="w-8 h-8 flex items-center justify-center bg-gray-50 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 max-h-[60vh] overflow-y-auto custom-scrollbar space-y-6">
            @foreach($menuGroups as $type => $group)
                <div class="space-y-3 menu-group-container" data-type="{{ strtolower($type) }}">
                    <div class="flex items-center gap-2">
                         <div class="w-2 h-2 rounded-full {{ strtolower($type) == 'wet' ? 'bg-blue-400' : 'bg-orange-400' }}"></div>
                         <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ strtolower($type) == 'wet' ? 'Menu Basah' : 'Menu Kering' }}</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($group as $menu)
                            <button type="button" onclick="selectMenuForDay({{ $menu->id }}, '{{ $menu->name }}', '{{ $type }}')" class="p-3 rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-all text-left group relative overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 group-hover:text-blue-700 relative z-10">{{ $menu->name }}</p>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Allergy Modal -->
<div id="allergyModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-md overflow-hidden shadow-2xl" id="allergyModalContent">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Atur Menu Alergi</h3>
                <p class="text-xs font-medium text-gray-400 truncate max-w-[200px]" id="allergySchoolName"></p>
            </div>
            <button onclick="closeAllergyModal()" class="w-8 h-8 flex items-center justify-center bg-gray-50 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('nutritionist.save-allergy') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="calendar_id" id="allergyCalendarId">
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Menu Pengganti</label>
                <div class="relative">
                    <select name="allergy_menu_id" required class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-3 pr-8 appearance-none">
                        <option value="">Pilih Menu Pengganti...</option>
                        @foreach($menuGroups as $type => $group)
                            <optgroup label="{{ $type == 'wet' ? 'Menu Basah' : 'Menu Kering' }}">
                                @foreach($group as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                         <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan</label>
                <textarea name="allergy_notes" rows="3" class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-3" placeholder="Contoh: Pengganti menu ayam siswa A..."></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold text-sm rounded-xl shadow-lg hover:bg-indigo-700 transition-all">
                    Simpan Menu Alergi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentDayIndex = null;
    let days = @json($days);

    function openMenuModal(index, date, status) {
        currentDayIndex = index;
        document.getElementById('modalDayName').innerText = 'Pilih Menu ' + days[index];
        document.getElementById('modalDateDisplay').innerText = date + (status === 'holiday' ? ' (LIBUR)' : '');
        
        // Filter menu groups if holiday
        const containers = document.querySelectorAll('.menu-group-container');
        containers.forEach(c => {
            if (status === 'holiday') {
                // Only show 'dry' (kering) category if holiday - or whatever rule applies
                // If you want free choice on holidays (which overrides holiday status on save), show all
                // For now, let's allow all, because assigning a menu implies un-holidaying it or special event
                c.classList.remove('hidden');
            } else {
                c.classList.remove('hidden');
            }
        });

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
        
        // Update Visuals
        const btn = document.getElementById('btn-' + currentDayIndex);
        
        // Colors
        let colorClasses = '';
        let typeLabel = '';
        let dotColor = '';
        
        if (type === 'wet') {
            colorClasses = 'border-blue-100 bg-blue-50 text-blue-700';
            typeLabel = 'Basah';
            dotColor = 'bg-blue-400';
        } else {
            colorClasses = 'border-orange-100 bg-orange-50 text-orange-700';
            typeLabel = 'Kering';
            dotColor = 'bg-orange-400';
        }
        
        btn.className = `w-full h-24 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 p-2 relative overflow-hidden ${colorClasses}`;
        
        btn.innerHTML = `
            <div class="absolute top-2 right-2 w-2 h-2 rounded-full ${dotColor}"></div>
            <span class="font-bold text-xs line-clamp-2 leading-tight">${name}</span>
            <span class="text-[9px] font-black uppercase opacity-60">${typeLabel}</span>
        `;

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
