<x-app-layout>
    <div class="py-10 bg-[#f8fafc] flex-1 min-h-screen">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-[1600px]">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                        <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
                        Setting Kloter & Distribusi
                    </h2>
                    <p class="text-sm font-bold text-gray-400 mt-2 uppercase tracking-[0.2em] ml-5">
                        Alokasi Porsi per Sekolah & Kloter
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('kloters.index') }}" class="px-6 py-3 bg-white border border-gray-100 rounded-2xl text-sm font-medium text-gray-400 hover:text-blue-600 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Kelola Nama Kloter
                    </a>
                    <a href="{{ route('distribution.index') }}" class="px-6 py-3 bg-white border border-gray-100 rounded-2xl text-sm font-medium text-gray-400 hover:text-blue-600 transition-all shadow-sm flex items-center gap-2">
                        Lihat Dashboard
                    </a>
                </div>
            </div>

            <!-- School Capacity Status Card -->
            <div class="bg-white rounded-md shadow-2xl shadow-blue-900/5 border border-white overflow-hidden mb-12">
                <div class="bg-blue-600 px-8 py-5">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2-2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Status Kapasitas Sekolah
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Sekolah</th>
                                <th class="px-8 py-4 text-[10px] font-medium text-blue-500 uppercase tracking-widest text-center">Target PK</th>
                                <th class="px-8 py-4 text-[10px] font-medium text-indigo-500 uppercase tracking-widest text-center">Target PB</th>
                                <th class="px-8 py-4 text-[10px] font-medium text-emerald-500 uppercase tracking-widest text-center">Target G</th>
                                <th class="px-8 py-4 text-[10px] font-medium text-gray-900 uppercase tracking-widest text-center">Status</th>
                                <th class="px-8 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($schools as $school)
                                <tr class="capacity-row" data-school-id="{{ $school->id }}" 
                                    data-target-pk="{{ $school->small_portion_count }}"
                                    data-target-pb="{{ $school->large_portion_count }}"
                                    data-target-g="{{ $school->teacher_count }}">
                                    <td class="px-8 py-4">
                                        <p class="text-sm font-bold text-gray-900">{{ $school->name }}</p>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="text-sm font-bold allocated-pk">0</span>
                                        <span class="text-gray-400">/</span>
                                        <span class="text-sm font-medium">{{ $school->small_portion_count }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="text-sm font-bold allocated-pb">0</span>
                                        <span class="text-gray-400">/</span>
                                        <span class="text-sm font-medium">{{ $school->large_portion_count }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="text-sm font-bold allocated-g">0</span>
                                        <span class="text-gray-400">/</span>
                                        <span class="text-sm font-medium">{{ $school->teacher_count }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="status-badge px-3 py-1 rounded-md text-[9px] font-medium uppercase tracking-widest">Checking...</span>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @foreach($kloters as $k)
                                                <button type="button" onclick="quickAddSchool({{ $school->id }}, {{ $k->id }})" title="Tambah ke {{ $k->name }}"
                                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all text-xs font-black border border-blue-100 shadow-sm">
                                                    {{ $loop->iteration }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="{{ route('distribution.settings.update') }}" method="POST" id="settingsForm">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-1 gap-8">
                    @foreach($kloters as $kloter)
                        <div class="bg-white rounded-md shadow-2xl shadow-blue-900/5 border border-white overflow-hidden kloter-card" data-kloter-id="{{ $kloter->id }}">
                            <div class="bg-gray-900 px-8 py-6 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-white uppercase tracking-widest">{{ $kloter->name }}</h3>
                                <button type="button" onclick="addDistributionRow({{ $kloter->id }})" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-medium uppercase tracking-widest rounded-xl transition-all">
                                    Tambah Alokasi
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto min-h-[200px]">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100">
                                            <th class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest">PJ / Unit</th>
                                            <th class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest">Sekolah</th>
                                            <th class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest">Label (Opsional)</th>
                                            <th class="px-6 py-4 text-[10px] font-medium text-blue-500 uppercase tracking-widest text-center w-20">PK</th>
                                            <th class="px-6 py-4 text-[10px] font-medium text-indigo-500 uppercase tracking-widest text-center w-20">PB</th>
                                            <th class="px-6 py-4 text-[10px] font-medium text-emerald-500 uppercase tracking-widest text-center w-20">G</th>
                                            <th class="px-6 py-4 w-10"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="kloter-rows-{{ $kloter->id }}" class="divide-y divide-gray-50">
                                        @foreach($kloter->distributions as $dIdx => $dist)
                                            <tr class="distribution-row group">
                                                <input type="hidden" name="distributions[{{ $kloter->id * 100 + $dIdx }}][kloter_id]" value="{{ $kloter->id }}">
                                                <td class="px-4 py-4 min-w-[120px]">
                                                    <select name="distributions[{{ $kloter->id * 100 + $dIdx }}][distribution_unit_id]" required class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500">
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}" {{ $dist->distribution_unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-4 min-w-[200px]">
                                                    <select name="distributions[{{ $kloter->id * 100 + $dIdx }}][school_id]" required class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500 school-selector">
                                                        <option value="">Pilih Sekolah</option>
                                                        @foreach($schools as $school)
                                                            <option value="{{ $school->id }}" {{ $dist->school_id == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="school-hint mt-1.5 px-2 py-1 bg-gray-50 rounded-lg text-[8px] font-bold text-gray-400 hidden transition-all border border-gray-100"></div>
                                                </td>
                                                <td class="px-4 py-4 min-w-[150px]">
                                                    <input type="text" name="distributions[{{ $kloter->id * 100 + $dIdx }}][name]" value="{{ $dist->name }}" placeholder="..." class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500">
                                                </td>
                                                <td class="px-2 py-4">
                                                    <input type="number" name="distributions[{{ $kloter->id * 100 + $dIdx }}][small_portion_count]" value="{{ $dist->small_portion_count ?? 0 }}" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input pk-input">
                                                </td>
                                                <td class="px-2 py-4">
                                                    <input type="number" name="distributions[{{ $kloter->id * 100 + $dIdx }}][large_portion_count]" value="{{ $dist->large_portion_count ?? 0 }}" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input pb-input">
                                                </td>
                                                <td class="px-2 py-4">
                                                    <input type="number" name="distributions[{{ $kloter->id * 100 + $dIdx }}][teacher_count]" value="{{ $dist->teacher_count ?? 0 }}" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input g-input">
                                                </td>
                                                <td class="px-4 py-4 text-right">
                                                    <button type="button" onclick="removeRow(this)" class="p-2 text-gray-200 hover:text-rose-500 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50/50 font-medium border-t border-gray-100">
                                            <td colspan="3" class="px-6 py-4 text-[10px] text-gray-400 uppercase tracking-widest">Total Batch</td>
                                            <td class="px-2 py-4 text-center text-xs text-blue-600 kloter-total-pk">0</td>
                                            <td class="px-2 py-4 text-center text-xs text-indigo-600 kloter-total-pb">0</td>
                                            <td class="px-2 py-4 text-center text-xs text-emerald-600 kloter-total-g">0</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 flex flex-col items-center gap-6 pb-20">
                    <div id="validationMessage" class="hidden px-8 py-4 bg-rose-50 border border-rose-100 rounded-3xl text-sm font-bold text-rose-600 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Portion totals do not match school capacities. Please check the summary above.</span>
                    </div>

                    <button type="submit" id="submitBtn" class="px-20 py-6 bg-blue-600 text-white font-medium rounded-2xl shadow-2xl shadow-blue-500/40 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all text-sm uppercase tracking-[0.2em]">
                        Simpan Semua Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let rowIdx = Date.now();
        const units = {!! json_encode($units) !!};
        const schools = {!! json_encode($schools) !!};

        function addDistributionRow(kloterId) {
            const tbody = document.getElementById('kloter-rows-' + kloterId);
            const unitOptions = units.map(u => `<option value="${u.id}">${u.name}</option>`).join('');
            const schoolOptions = schools.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
            
            const row = `
                <tr class="distribution-row group">
                    <input type="hidden" name="distributions[${rowIdx}][kloter_id]" value="${kloterId}">
                    <td class="px-4 py-4 min-w-[120px]">
                        <select name="distributions[${rowIdx}][distribution_unit_id]" required class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500">
                            ${unitOptions}
                        </select>
                    </td>
                    <td class="px-4 py-4 min-w-[200px]">
                        <select name="distributions[${rowIdx}][school_id]" required class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500 school-selector">
                            <option value="">Pilih Sekolah</option>
                            ${schoolOptions}
                        </select>
                        <div class="school-hint mt-1.5 px-2 py-1 bg-gray-50 rounded-lg text-[8px] font-bold text-gray-400 hidden transition-all border border-gray-100"></div>
                    </td>
                    <td class="px-4 py-4 min-w-[150px]">
                        <input type="text" name="distributions[${rowIdx}][name]" placeholder="..." class="w-full rounded-xl border-gray-100 bg-gray-50 text-[10px] font-medium uppercase focus:ring-0 focus:border-blue-500">
                    </td>
                    <td class="px-2 py-4">
                        <input type="number" name="distributions[${rowIdx}][small_portion_count]" value="0" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input pk-input">
                    </td>
                    <td class="px-2 py-4">
                        <input type="number" name="distributions[${rowIdx}][large_portion_count]" value="0" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input pb-input">
                    </td>
                    <td class="px-2 py-4">
                        <input type="number" name="distributions[${rowIdx}][teacher_count]" value="0" min="0" step="1" class="w-full text-center rounded-xl border-gray-100 bg-gray-50 text-xs font-medium focus:ring-0 focus:border-blue-500 portion-input g-input">
                    </td>
                    <td class="px-4 py-4 text-right">
                        <button type="button" onclick="removeRow(this)" class="p-2 text-gray-200 hover:text-rose-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
            rowIdx++;
            rebindEvents();
            validateAll();
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            validateAll();
        }

        function rebindEvents() {
            document.querySelectorAll('.school-selector, .portion-input').forEach(el => {
                el.removeEventListener('change', validateAll);
                el.addEventListener('change', validateAll);
                el.removeEventListener('input', validateAll);
                el.addEventListener('input', validateAll);
            });
        }

        function validateAll() {
            const schoolTotals = {};
            const kloterTotals = {};
            
            // Collect all allocated portions
            document.querySelectorAll('.kloter-card').forEach(card => {
                const kId = card.dataset.kloterId;
                kloterTotals[kId] = { pk: 0, pb: 0, g: 0 };
                
                card.querySelectorAll('.distribution-row').forEach(row => {
                    const schoolId = row.querySelector('.school-selector').value;
                    const pk = parseInt(row.querySelector('.pk-input').value) || 0;
                    const pb = parseInt(row.querySelector('.pb-input').value) || 0;
                    const g = parseInt(row.querySelector('.g-input').value) || 0;

                    if (schoolId) {
                        if (!schoolTotals[schoolId]) schoolTotals[schoolId] = { pk: 0, pb: 0, g: 0 };
                        schoolTotals[schoolId].pk += pk;
                        schoolTotals[schoolId].pb += pb;
                        schoolTotals[schoolId].g += g;
                    }

                    kloterTotals[kId].pk += pk;
                    kloterTotals[kId].pb += pb;
                    kloterTotals[kId].g += g;
                });

                // Update Kloter Footer
                card.querySelector('.kloter-total-pk').textContent = kloterTotals[kId].pk;
                card.querySelector('.kloter-total-pb').textContent = kloterTotals[kId].pb;
                card.querySelector('.kloter-total-g').textContent = kloterTotals[kId].g;
            });

            let allValid = true;

            // Update Capacity Table & Row Hints
            document.querySelectorAll('.capacity-row').forEach(row => {
                const sId = row.dataset.schoolId;
                const targetPk = parseInt(row.dataset.targetPk);
                const targetPb = parseInt(row.dataset.targetPb);
                const targetG = parseInt(row.dataset.targetG);
                
                const stats = schoolTotals[sId] || { pk: 0, pb: 0, g: 0 };
                
                row.querySelector('.allocated-pk').textContent = stats.pk;
                row.querySelector('.allocated-pb').textContent = stats.pb;
                row.querySelector('.allocated-g').textContent = stats.g;

                const badge = row.querySelector('.status-badge');
                if (stats.pk === targetPk && stats.pb === targetPb && stats.g === targetG) {
                    badge.textContent = 'Cocok';
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[9px] font-medium uppercase tracking-widest bg-emerald-100 text-emerald-600';
                } else if (stats.pk === 0 && stats.pb === 0 && stats.g === 0) {
                    badge.textContent = 'Belum Alokasi';
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[9px] font-medium uppercase tracking-widest bg-gray-100 text-gray-400';
                    allValid = false;
                } else {
                    badge.textContent = 'Belum Pas';
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[9px] font-medium uppercase tracking-widest bg-rose-100 text-rose-600';
                    allValid = false;
                }

                // Update hints in rows for THIS school
                document.querySelectorAll('.distribution-row').forEach(dRow => {
                    const selector = dRow.querySelector('.school-selector');
                    if (selector.value == sId) {
                        const hint = dRow.querySelector('.school-hint');
                        if (hint) {
                            hint.classList.remove('hidden');
                            
                            const isOver = stats.pk > targetPk || stats.pb > targetPb || stats.g > targetG;
                            const colorClass = isOver ? 'text-rose-500 bg-rose-50 border-rose-100' : 'text-blue-600 bg-blue-50 border-blue-100';
                            hint.className = `school-hint mt-1.5 px-2 py-1 rounded-lg text-[8px] font-bold ${colorClass} transition-all border`;
                            
                            hint.innerHTML = `
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex justify-between"><span>PK:</span> <span>${stats.pk} / ${targetPk}</span></div>
                                    <div class="flex justify-between"><span>PB:</span> <span>${stats.pb} / ${targetPb}</span></div>
                                    <div class="flex justify-between"><span>G:</span>  <span>${stats.g} / ${targetG}</span></div>
                                </div>
                            `;
                        }
                    }
                });
            });

            // Hide hints for rows with NO school selected
            document.querySelectorAll('.distribution-row').forEach(dRow => {
                const selector = dRow.querySelector('.school-selector');
                if (!selector.value) {
                    const hint = dRow.querySelector('.school-hint');
                    if (hint) {
                        hint.classList.add('hidden');
                        hint.innerHTML = '';
                    }
                }
            });

            const validationMsg = document.getElementById('validationMessage');
            
            if (allValid) {
                validationMsg.classList.add('hidden');
            } else {
                validationMsg.classList.remove('hidden');
            }
        }

        function quickAddSchool(schoolId, kloterId) {
            const school = schools.find(s => s.id == schoolId);
            if (!school) return;

            // Calculate current allocation to find remaining
            let currentAlloc = { pk: 0, pb: 0, g: 0 };
            document.querySelectorAll('.distribution-row').forEach(row => {
                if (row.querySelector('.school-selector').value == schoolId) {
                    currentAlloc.pk += parseInt(row.querySelector('.pk-input').value) || 0;
                    currentAlloc.pb += parseInt(row.querySelector('.pb-input').value) || 0;
                    currentAlloc.g += parseInt(row.querySelector('.g-input').value) || 0;
                }
            });

            const remainingPk = Math.max(0, school.small_portion_count - currentAlloc.pk);
            const remainingPb = Math.max(0, school.large_portion_count - currentAlloc.pb);
            const remainingG = Math.max(0, school.teacher_count - currentAlloc.g);

            if (remainingPk === 0 && remainingPb === 0 && remainingG === 0) {
                alert('Sekolah ini sudah teralokasi sepenuhnya.');
                return;
            }

            addDistributionRow(kloterId);
            
            const tbody = document.getElementById('kloter-rows-' + kloterId);
            const lastRow = tbody.lastElementChild;
            
            lastRow.querySelector('.school-selector').value = schoolId;
            lastRow.querySelector('.pk-input').value = remainingPk;
            lastRow.querySelector('.pb-input').value = remainingPb;
            lastRow.querySelector('.g-input').value = remainingG;
            
            validateAll();
            
            lastRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            lastRow.classList.add('bg-blue-50/50');
            setTimeout(() => lastRow.classList.remove('bg-blue-50/50'), 2000);
        }

        // Initial build
        rebindEvents();
        validateAll();
    </script>
    @endpush
</x-app-layout>
