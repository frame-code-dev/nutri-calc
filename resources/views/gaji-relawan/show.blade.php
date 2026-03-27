<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ $period->nama_periode }}</h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $period->tanggal_mulai->format('d M Y') }} – {{ $period->tanggal_selesai->format('d M Y') }}
                    · Periode {{ $period->periode_roman }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('gaji-relawan.slip-pdf', $period) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-green-600 text-white text-xs font-semibold rounded-xl hover:bg-green-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Slip
                </a>
                <a href="{{ route('gaji-relawan.rekap-pdf', $period) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-500 text-white text-xs font-semibold rounded-xl hover:bg-amber-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Cetak Rekap
                </a>
                <a href="{{ route('gaji-relawan.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('gaji-relawan.save-absensi', $period) }}" id="formAbsensi">
        @csrf

        {{-- ─────── RELAWAN TETAP ─────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-5 py-3 border-b border-gray-100 bg-blue-50/60 flex items-center justify-between">
                <h3 class="font-bold text-blue-800 text-sm">Relawan Tetap</h3>
                <span class="text-xs text-blue-600 font-medium">{{ $detailsTetap->count() }} orang</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-center">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="px-2 py-1 text-left" colspan="3"></th>
                            @foreach($hariKolom as $minggu => $hariList)
                            <th class="px-2 py-1 text-center font-bold text-sm border-x border-blue-700" colspan="{{ count($hariList) + 1 }}">{{ $minggu }}</th>
                            @endforeach
                            <th class="px-2 py-1" colspan="4"></th>
                        </tr>
                        <tr class="bg-[#4472C4] text-white">
                            <th class="px-2 py-2 text-left w-6">NO</th>
                            <th class="px-2 py-2 text-left min-w-32">NAMA RELAWAN</th>
                            <th class="px-2 py-2 text-left min-w-28">JABATAN</th>
                            @foreach($hariKolom as $minggu => $hariList)
                                @foreach($hariList as $hari => $label)
                                    @php $hariNama = preg_replace('/\s*\(.*?\)/', '', $label); @endphp
                                    <th class="px-2 py-2 uppercase w-16 border-l border-blue-500">{{ strtoupper(substr($hariNama, 0, 3)) }}<br><span class="font-normal text-blue-200 text-[10px]">{{ $label }}</span></th>
                                @endforeach
                                <th class="px-2 py-2 uppercase w-16 border-r border-blue-500 text-green-100">KOMP.<br><span class="font-normal text-[10px]">{{ substr($minggu, -1) }}</span></th>
                            @endforeach
                            <th class="px-2 py-2 w-16">KEHADIRAN</th>
                            <th class="px-2 py-2 w-24">UPAH</th>
                            <th class="px-2 py-2 w-28 border-x border-blue-500">TOTAL UPAH</th>
                            <th class="px-2 py-2 w-16">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($detailsTetap as $idx => $detail)
                        <tr class="hover:bg-gray-50 {{ $detail->relawan->aktif ? '' : 'opacity-50' }}">
                            <td class="px-2 py-1.5 text-gray-500 text-left">{{ $detail->relawan->nomor_urut }}</td>
                            <td class="px-2 py-1.5 text-left font-medium text-gray-900">{{ $detail->relawan->nama }}</td>
                            <td class="px-2 py-1.5 text-left text-gray-600">{{ $detail->relawan->jabatan }}</td>
                            <input type="hidden" name="absensi[{{ $idx }}][detail_id]" value="{{ $detail->id }}">
                            @foreach($hariKolom as $minggu => $hariList)
                                @foreach($hariList as $hari => $label)
                                <td class="px-1 py-1 border-l border-gray-100 text-center">
                                    <input type="number" name="absensi[{{ $idx }}][hari][{{ $hari }}]"
                                           value="{{ $detail->hari_kerja[$hari] ?? '' }}"
                                           min="0" placeholder="0"
                                           class="w-14 text-center border border-gray-200 rounded-md px-1 py-1 text-xs focus:ring-1 focus:ring-blue-400 focus:border-blue-400 absensi-input"
                                           data-idx="{{ $idx }}">
                                    @php
                                        $kompHari = $detail->components->where('tanggal', $hari)->sum('jumlah');
                                    @endphp
                                    @if($kompHari > 0)
                                        <div class="text-[9px] text-green-600 font-bold mt-0.5">+{{ number_format($kompHari, 0, ',', '.') }}</div>
                                    @elseif($kompHari < 0)
                                        <div class="text-[9px] text-red-600 font-bold mt-0.5">{{ number_format($kompHari, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                @endforeach
                                @php
                                    $weekDates = array_keys($hariList);
                                    $kompWeek = $detail->components->whereIn('tanggal', $weekDates)->sum('jumlah');
                                @endphp
                                <td class="px-2 py-1.5 font-semibold text-xs border-r border-gray-100 {{ $kompWeek ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $kompWeek ? number_format($kompWeek, 0, ',', '.') : '-' }}
                                </td>
                            @endforeach
                            <td class="px-2 py-1.5 font-semibold text-gray-800 total-hari" id="th-{{ $idx }}">{{ $detail->total_hari }}</td>
                            <td class="px-1 py-1">
                                <input type="number" name="absensi[{{ $idx }}][upah]"
                                       value="{{ $detail->upah_per_hari }}"
                                       min="0" step="1000"
                                       class="w-24 text-center border border-gray-200 rounded-md px-1 py-1 text-xs focus:ring-1 focus:ring-blue-400 upah-input"
                                       data-idx="{{ $idx }}">
                            </td>
                            <td class="px-2 py-1.5 font-bold text-gray-900 total-upah" id="tu-{{ $idx }}" data-komp="{{ $detail->components->sum('jumlah') }}">
                                Rp{{ number_format($detail->total_upah, 0, ',', '.') }}
                            </td>
                            <td class="px-2 py-1.5">
                                <button type="button" onclick="openKomponen({{ $detail->id }}, '{{ addslashes($detail->relawan->nama) }}')"
                                        class="p-1 text-gray-400 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#4472C4] text-white font-bold">
                            @php
                                $colSpanTotal = 3;
                                foreach($hariKolom as $minggu => $hariList) {
                                    $colSpanTotal += count($hariList) + 1;
                                }
                            @endphp
                            <td colspan="{{ $colSpanTotal }}" class="px-4 py-2 text-right text-sm">TOTAL</td>
                            <td colspan="2" class="px-4 py-2 text-right text-sm"></td>
                            <td class="px-4 py-2 text-sm">Rp{{ number_format($totalUpahTetap, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ─────── TENAGA MAGANG ─────── --}}
        @if($detailsMagang->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-5 py-3 border-b border-gray-100 bg-amber-50/60 flex items-center justify-between">
                <h3 class="font-bold text-amber-800 text-sm">Tenaga Magang</h3>
                <span class="text-xs text-amber-600 font-medium">{{ $detailsMagang->count() }} orang</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-center">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="px-2 py-1 text-left" colspan="3"></th>
                            @foreach($hariKolom as $minggu => $hariList)
                            <th class="px-2 py-1 text-center font-bold text-sm border-x border-blue-700" colspan="{{ count($hariList) + 1 }}">{{ $minggu }}</th>
                            @endforeach
                            <th class="px-2 py-1" colspan="4"></th>
                        </tr>
                        <tr class="bg-[#4472C4] text-white">
                            <th class="px-2 py-2 text-left w-6">NO</th>
                            <th class="px-2 py-2 text-left min-w-32">NAMA RELAWAN</th>
                            <th class="px-2 py-2 text-left min-w-28">JABATAN</th>
                            @foreach($hariKolom as $minggu => $hariList)
                                @foreach($hariList as $hari => $label)
                                    @php $hariNama = preg_replace('/\s*\(.*?\)/', '', $label); @endphp
                                    <th class="px-2 py-2 uppercase w-16 border-l border-blue-500">{{ strtoupper(substr($hariNama, 0, 3)) }}<br><span class="font-normal text-blue-200 text-[10px]">{{ $label }}</span></th>
                                @endforeach
                                <th class="px-2 py-2 uppercase w-16 border-r border-blue-500 text-green-100">KOMP.<br><span class="font-normal text-[10px]">{{ substr($minggu, -1) }}</span></th>
                            @endforeach
                            <th class="px-2 py-2 w-16">KEHADIRAN</th>
                            <th class="px-2 py-2 w-24">UPAH</th>
                            <th class="px-2 py-2 w-28 border-x border-blue-500">TOTAL UPAH</th>
                            <th class="px-2 py-2 w-16">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php $offsetMagang = $detailsTetap->count(); @endphp
                        @foreach($detailsMagang as $idx => $detail)
                        @php $i = $offsetMagang + $idx; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-1.5 text-gray-500 text-left">{{ $detail->relawan->nomor_urut }}</td>
                            <td class="px-2 py-1.5 text-left font-medium text-gray-900">{{ $detail->relawan->nama }}</td>
                            <td class="px-2 py-1.5 text-left text-gray-600">{{ $detail->relawan->jabatan }}</td>
                            <input type="hidden" name="absensi[{{ $i }}][detail_id]" value="{{ $detail->id }}">
                            @foreach($hariKolom as $minggu => $hariList)
                                @foreach($hariList as $hari => $label)
                                <td class="px-1 py-1 border-l border-gray-100 text-center">
                                    <input type="number" name="absensi[{{ $i }}][hari][{{ $hari }}]"
                                           value="{{ $detail->hari_kerja[$hari] ?? '' }}"
                                           min="0" placeholder="0"
                                           class="w-14 text-center border border-gray-200 rounded-md px-1 py-1 text-xs focus:ring-1 focus:ring-blue-400 absensi-input"
                                           data-idx="{{ $i }}">
                                    @php
                                        $kompHari = $detail->components->where('tanggal', $hari)->sum('jumlah');
                                    @endphp
                                    @if($kompHari > 0)
                                        <div class="text-[9px] text-green-600 font-bold mt-0.5">+{{ number_format($kompHari, 0, ',', '.') }}</div>
                                    @elseif($kompHari < 0)
                                        <div class="text-[9px] text-red-600 font-bold mt-0.5">{{ number_format($kompHari, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                @endforeach
                                @php
                                    $weekDates = array_keys($hariList);
                                    $kompWeek = $detail->components->whereIn('tanggal', $weekDates)->sum('jumlah');
                                @endphp
                                <td class="px-2 py-1.5 font-semibold text-xs border-r border-gray-100 {{ $kompWeek ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $kompWeek ? number_format($kompWeek, 0, ',', '.') : '-' }}
                                </td>
                            @endforeach
                            <td class="px-2 py-1.5 font-semibold text-gray-800 total-hari" id="th-{{ $i }}">{{ $detail->total_hari }}</td>
                            <td class="px-1 py-1">
                                <input type="number" name="absensi[{{ $i }}][upah]"
                                       value="{{ $detail->upah_per_hari }}"
                                       min="0" step="1000"
                                       class="w-24 text-center border border-gray-200 rounded-md px-1 py-1 text-xs focus:ring-1 focus:ring-blue-400 upah-input"
                                       data-idx="{{ $i }}">
                            </td>
                            <td class="px-2 py-1.5 font-bold text-gray-900 total-upah" id="tu-{{ $i }}" data-komp="{{ $detail->components->sum('jumlah') }}">
                                Rp{{ number_format($detail->total_upah, 0, ',', '.') }}
                            </td>
                            <td class="px-2 py-1.5">
                                <button type="button" onclick="openKomponen({{ $detail->id }}, '{{ addslashes($detail->relawan->nama) }}')"
                                        class="p-1 text-gray-400 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#4472C4] text-white font-bold">
                            @php
                                $colSpanTotal = 3;
                                foreach($hariKolom as $minggu => $hariList) {
                                    $colSpanTotal += count($hariList) + 1;
                                }
                            @endphp
                            <td colspan="{{ $colSpanTotal }}" class="px-4 py-2 text-right text-sm">TOTAL</td>
                            <td colspan="2" class="px-4 py-2 text-right text-sm"></td>
                            <td class="px-4 py-2 text-sm">Rp{{ number_format($totalUpahMagang, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                💾 Simpan Absensi
            </button>
        </div>
    </form>

    {{-- ─────── MODAL KOMPONEN GAJI ─────── --}}
    <div id="modalKomponen" class="fixed inset-0 z-50 hidden" aria-modal="true">
        <div class="absolute inset-0 bg-gray-900/30 backdrop-blur-sm" onclick="closeKomponen()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900" id="modalTitle">Komponen Gaji</h3>
                    <button onclick="closeKomponen()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form id="formKomponen" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div id="komponenRows" class="space-y-2"></div>
                    <button type="button" onclick="addKomponenRow()"
                            class="text-sm text-blue-600 font-semibold hover:underline">+ Tambah Komponen</button>
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                            Simpan Komponen
                        </button>
                        <button type="button" onclick="closeKomponen()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ─── Live total hari & upah calculation ───────────────────────
        document.querySelectorAll('.absensi-input').forEach(input => {
            input.addEventListener('input', recalcRow);
        });
        document.querySelectorAll('.upah-input').forEach(input => {
            input.addEventListener('input', recalcRow);
        });

        function recalcRow(e) {
            const idx = e.target.dataset.idx;
            const hariInputs = document.querySelectorAll(`.absensi-input[data-idx="${idx}"]`);
            let totalHari = 0;
            let sumGrid = 0;
            hariInputs.forEach(inp => {
                const val = parseFloat(inp.value || 0);
                if (val > 0) totalHari++;
                sumGrid += val;
            });
            document.getElementById('th-' + idx).textContent = totalHari;

            const upah = parseFloat(document.querySelector(`.upah-input[data-idx="${idx}"]`)?.value || 0);
            const komp = parseFloat(document.getElementById('tu-' + idx).dataset.komp || 0);
            const totalUpah = sumGrid + komp;
            document.getElementById('tu-' + idx).textContent = 'Rp' + totalUpah.toLocaleString('id-ID');
        }

        // ─── Komponen modal ────────────────────────────────────────────
        let currentDetailId = null;

        function openKomponen(detailId, namaRelawan) {
            currentDetailId = detailId;
            document.getElementById('modalTitle').textContent = 'Komponen Gaji — ' + namaRelawan;
            document.getElementById('formKomponen').action = '/gaji-relawan/component/' + detailId;
            document.getElementById('komponenRows').innerHTML = '';
            addKomponenRow();
            document.getElementById('modalKomponen').classList.remove('hidden');
        }

        function closeKomponen() {
            document.getElementById('modalKomponen').classList.add('hidden');
            currentDetailId = null;
        }

        let kompIdx = 0;
        function addKomponenRow() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center';
            div.innerHTML = `
                <input type="date" name="komponen[${kompIdx}][tanggal]" 
                       class="w-32 border border-gray-200 rounded-lg px-2 py-1.5 text-sm focus:ring-1 focus:ring-blue-400">
                <input type="text" name="komponen[${kompIdx}][nama]" placeholder="Nama (e.g. Dana Kesehatan)"
                       class="flex-1 border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:ring-1 focus:ring-blue-400">
                <input type="number" name="komponen[${kompIdx}][jumlah]" placeholder="Jumlah" step="1000"
                       class="w-32 border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:ring-1 focus:ring-blue-400">
                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            document.getElementById('komponenRows').appendChild(div);
            kompIdx++;
        }
    </script>
    @endpush
</x-app-layout>
