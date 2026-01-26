<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                        Kalender MBG
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Kelola dan tinjau jadwal menu mingguan sekolah.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin MBG']))
                        <form action="{{ route('calendars.send-notification') }}" method="POST"
                            onsubmit="return confirm('Kirim notifikasi produksi H-1 ke Koordinator Dapur?');">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all duration-200">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                Notif H-1
                            </button>
                        </form>
                    @endif

                    @role('Koordinator Sekolah')
                        @if (!($isLocked ?? false))
                            <a href="{{ route('calendars.edit-week', ['school_id' => $school->id, 'week' => $weekNumber, 'year' => $year]) }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Update Jadwal
                            </a>
                        @else
                            <div
                                class="inline-flex items-center px-6 py-3 border border-gray-200 text-sm font-bold rounded-xl bg-gray-50 text-gray-400 cursor-not-allowed">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Jadwal Terkunci
                            </div>
                        @endif
                    @endrole
                </div>
            </div>

            <!-- Filter Card -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 overflow-hidden relative">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                    </svg>
                </div>

                <form method="GET" action="{{ route('calendars.index') }}"
                    class="flex flex-wrap items-center gap-6 relative">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin MBG']))
                        <div class="flex-1 min-w-[240px]">
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Sekolah</label>
                            <select name="school_id"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2.5 transition-all duration-200"
                                onchange="this.form.submit()">
                                @foreach ($schools as $s)
                                    <option value="{{ $s->id }}" {{ $school->id == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Pilih
                            Minggu</label>
                        <select id="week_selector" onchange="applyWeek(this.value)"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 text-sm font-bold focus:border-blue-500 focus:ring-blue-500 py-2.5 transition-all duration-200">
                            @for ($w = 1; $w <= 53; $w++)
                                @php
                                    $wDate = \Carbon\Carbon::now()
                                        ->setISODate($currentYear, $w)
                                        ->startOfWeek(\Carbon\Carbon::MONDAY);
                                @endphp
                                <option value="{{ $wDate->toDateString() }}"
                                    {{ $weekNumber == $w ? 'selected' : '' }}>
                                    Minggu {{ $w }} ({{ $wDate->isoFormat('D MMM') }} -
                                    {{ $wDate->copy()->addDays(5)->isoFormat('D MMM') }})
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="w-48">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Mulai
                            Tanggal</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ $startOfWeek->toDateString() }}"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 text-sm focus:border-blue-500 focus:ring-blue-500 py-2.5 transition-all duration-200"
                            onchange="updateEndDate(this.value)">
                    </div>

                    <div class="w-48">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Hingga
                            (Sabtu)</label>
                        <div
                            class="w-full rounded-xl border-gray-100 bg-gray-100/50 text-gray-400 text-sm font-medium py-2.5 px-4 h-[42px] flex items-center border border-dashed whitespace-nowrap overflow-hidden">
                            {{ $endOfWeek->isoFormat('D MMM Y') }}
                        </div>
                    </div>

                    <div class="flex items-end pt-4 md:pt-0">
                        <button type="submit"
                            class="p-3 bg-gray-900 hover:bg-black text-white rounded-xl shadow-lg transition-all duration-300 transform active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            @role('Koordinator Sekolah')
                <!-- Completion Status (Coordinator Only) -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 overflow-hidden relative">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="flex items-center gap-6">
                            <div class="relative flex-shrink-0">
                                <svg class="h-24 w-24 transform -rotate-90">
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8"
                                        fill="transparent" class="text-gray-100" />
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8"
                                        fill="transparent" stroke-dasharray="251.2"
                                        stroke-dashoffset="{{ 251.2 - (251.2 * $completionStatus['percentage']) / 100 }}"
                                        class="{{ $completionStatus['is_complete'] ? 'text-green-500' : 'text-orange-500' }} transition-all duration-1000 ease-in-out" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span
                                        class="text-xl font-black text-gray-800">{{ round($completionStatus['percentage']) }}%</span>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-gray-900">
                                    {{ $completionStatus['is_complete'] ? 'Lengkap!' : 'Hampir Selesai' }}
                                </h3>
                                <p class="text-gray-500 font-medium">
                                    <span class="text-gray-900 font-bold">{{ $completionStatus['filled'] }}</span> dari
                                    <span class="text-gray-900 font-bold">{{ $completionStatus['total'] }}</span> hari
                                    telah terdata.
                                </p>
                            </div>
                        </div>

                        @if (!$completionStatus['is_complete'])
                            <div class="px-6 py-4 bg-orange-50 rounded-2xl border border-orange-100">
                                <div class="flex items-center gap-3">
                                    <div class="bg-orange-500 p-2 rounded-lg text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-orange-800">Perlu Perhatian</p>
                                        <p class="text-xs text-orange-600">Lengkapi data untuk mengaktifkan pengiriman.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="px-6 py-4 bg-green-50 rounded-2xl border border-green-100">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-500 p-2 rounded-lg text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-green-800">Selesai</p>
                                        <p class="text-xs text-green-600">Semua jadwal telah terisi dengan benar.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Calendar List (Coordinator Only) -->
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($weekDates as $item)
                        @php
                            $date = $item['date'];
                            $calendar = $item['calendar'];
                        @endphp
                        <div
                            class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 overflow-hidden">
                            <div class="flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-gray-50">
                                <!-- Date Col -->
                                <div
                                    class="w-full md:w-48 p-6 flex items-center md:flex-col justify-between md:justify-center bg-gray-50/50">
                                    <div class="text-left md:text-center">
                                        <p class="text-xs font-black text-blue-400 uppercase tracking-widest">
                                            {{ $date->isoFormat('dddd') }}</p>
                                        <p class="text-4xl font-black text-gray-900 my-1">{{ $date->format('d') }}</p>
                                        <p class="text-xs font-bold text-gray-500">{{ $date->isoFormat('MMMM Y') }}</p>
                                    </div>

                                    @if ($calendar)
                                        <div class="md:mt-4">
                                            @if ($calendar->day_status === 'receive')
                                                <span
                                                    class="inline-block px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-wider rounded-full">Active</span>
                                            @else
                                                <span
                                                    class="inline-block px-3 py-1 bg-gray-200 text-gray-600 text-[10px] font-black uppercase tracking-wider rounded-full">Holiday</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="md:mt-4">
                                            <span
                                                class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-[10px] font-black uppercase tracking-wider rounded-full italic pulse">Pending</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content Col -->
                                <div class="flex-1 p-8">
                                    @if ($calendar)
                                        @if ($calendar->day_status === 'receive')
                                            <div class="flex flex-col md:flex-row justify-between gap-6">
                                                <div class="space-y-4">
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="p-1 px-2 bg-blue-600 text-white text-[10px] font-black rounded uppercase">MBG
                                                            Delivery</span>
                                                        <h4 class="text-xl font-bold text-gray-900">
                                                            {{ $calendar->menu->name ?? 'Menu Belum Ditentukan' }}</h4>
                                                    </div>

                                                    <div class="flex flex-wrap gap-4 text-sm font-medium text-gray-500">
                                                        <div class="flex items-center gap-1.5">
                                                            <svg class="w-4 h-4 text-blue-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                                </path>
                                                            </svg>
                                                            {{ ($calendar->menu->type ?? '') === 'wet' ? 'Menu Basah' : 'Menu Kering' }}
                                                        </div>
                                                        <div class="flex items-center gap-1.5">
                                                            <svg class="w-4 h-4 text-blue-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                                </path>
                                                            </svg>
                                                            {{ number_format($calendar->portion_count) }} Porsi
                                                        </div>
                                                    </div>
                                                </div>

                                                @role('Koordinator Sekolah')
                                                    <div class="flex items-start">
                                                        @if (!($isLocked ?? false))
                                                            <form action="{{ route('calendars.destroy', $calendar) }}"
                                                                method="POST" onsubmit="return confirm('Hapus data ini?')"
                                                                class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @endrole
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-4">
                                                    <div class="bg-gray-100 p-3 rounded-2xl">
                                                        <span class="text-2xl">🏖️</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900">Libur Sekolah</p>
                                                        <p class="text-sm text-gray-500 italic">Distribusi dialihkan ke
                                                            menu kering sekolah.</p>
                                                    </div>
                                                </div>

                                                @role('Koordinator Sekolah')
                                                    @if (!($isLocked ?? false))
                                                        <form action="{{ route('calendars.destroy', $calendar) }}"
                                                            method="POST" onsubmit="return confirm('Hapus data ini?')"
                                                            class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endrole
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-4 animate-pulse">
                                            <div
                                                class="bg-gray-100 p-3 rounded-2xl border-2 border-dashed border-gray-200">
                                                <span class="text-2xl grayscale opacity-50">🍱</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-400">Belum Ada Informasi</p>
                                                <p class="text-sm text-gray-400">Silakan isi jadwal minggu ini untuk
                                                    memperbarui.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Multi-School Table View (Admin Only) -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th
                                        class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                        Sekolah</th>
                                    @foreach ($weekDays as $day)
                                        <th class="p-6 text-center border-b border-gray-100">
                                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">
                                                {{ $day['date']->isoFormat('dddd') }}</p>
                                            <p
                                                class="text-[10px] font-bold text-blue-500 bg-blue-50 rounded px-2 py-0.5 inline-block mb-2">
                                                {{ $day['menu']?->name ?? 'No Menu' }}</p>

                                            <!-- Bulk Actions -->
                                            <div class="flex items-center justify-center gap-1 mt-1">
                                                <button type="button"
                                                    onclick="openBulkModal('{{ $day['date']->toDateString() }}', '{{ $day['date']->isoFormat('dddd, D MMMM') }}', 'receive')"
                                                    title="Mark all as Receive"
                                                    class="p-1.5 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg transition-all border border-green-100">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    onclick="openBulkModal('{{ $day['date']->toDateString() }}', '{{ $day['date']->isoFormat('dddd, D MMMM') }}', 'holiday')"
                                                    title="Mark all as Holiday"
                                                    class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-all border border-red-100">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($schools as $s)
                                    @php
                                        $calendars = $allCalendars->get($s->id, collect());
                                        $weeklyStatus = $s->weeklyStatuses->first();
                                        $isLocked = $weeklyStatus?->is_locked ?? false;
                                        $isComplete = $calendars->count() >= 6;

                                        $statusLabel = 'Draft';
                                        $statusColor = 'bg-gray-100 text-gray-600';
                                        if ($isLocked) {
                                            $statusLabel = 'Terkunci';
                                            $statusColor = 'bg-green-100 text-green-700';
                                        } elseif ($isComplete) {
                                            $statusLabel = 'Pending';
                                            $statusColor = 'bg-orange-100 text-orange-700';
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="p-6">
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $s->name }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span
                                                        class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">{{ $s->student_count }}
                                                        Siswa</span>
                                                    <span
                                                        class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $statusColor }}">{{ $statusLabel }}</span>
                                                </div>

                                                <div class="mt-3 flex items-center gap-2">
                                                    @if (!$isComplete && !$isLocked)
                                                        @if ($s->coordinator)
                                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $s->coordinator->whatsapp_number) }}?text=Halo%20{{ urlencode($s->coordinator->name) }},%20mohon%20untuk%20segera%20melengkapi%20jadwal%20kalender%20MBG%20minggu%20ke-{{ $weekNumber }}%20untuk%20{{ urlencode($s->name) }}."
                                                                target="_blank"
                                                                class="inline-flex items-center text-[10px] font-bold text-blue-600 hover:text-blue-800 gap-1 transition-colors">
                                                                <svg class="w-3 h-3" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.408 0 12.044c0 2.123.554 4.197 1.606 6.034L0 24l6.135-1.61a11.81 11.81 0 005.915 1.612h.01c6.636 0 12.046-5.41 12.05-12.046a11.848 11.848 0 00-3.535-8.503">
                                                                    </path>
                                                                </svg>
                                                                Hubungi
                                                            </a>
                                                        @endif
                                                    @elseif($isComplete && !$isLocked)
                                                        <form action="{{ route('monitoring.lock-school') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="school_id"
                                                                value="{{ $s->id }}">
                                                            <input type="hidden" name="week"
                                                                value="{{ $weekNumber }}">
                                                            <input type="hidden" name="year"
                                                                value="{{ $year }}">
                                                            <button type="submit"
                                                                class="inline-flex items-center text-[10px] font-black text-white bg-gray-900 px-2 py-0.5 rounded shadow hover:bg-black transition-all gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                                    </path>
                                                                </svg>
                                                                Kunci Sekolah
                                                            </button>
                                                        </form>
                                                    @elseif($isLocked)
                                                        <form action="{{ route('monitoring.unlock-school') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="school_id"
                                                                value="{{ $s->id }}">
                                                            <input type="hidden" name="week"
                                                                value="{{ $weekNumber }}">
                                                            <input type="hidden" name="year"
                                                                value="{{ $year }}">
                                                            <button type="submit"
                                                                class="inline-flex items-center text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100 hover:bg-red-100 transition-all gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z">
                                                                    </path>
                                                                </svg>
                                                                Buka Kunci
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        @foreach ($weekDays as $day)
                                            @php
                                                $cal = $calendars->first(
                                                    fn($c) => $c->date->toDateString() === $day['date']->toDateString(),
                                                );
                                                $status = 'belum';
                                                if ($cal) {
                                                    $status = $cal->day_status;
                                                }
                                            @endphp
                                            <td class="p-6 text-center">
                                                <button type="button"
                                                    onclick="openStatusModal('{{ $s->id }}', '{{ $s->name }}', '{{ $day['date']->toDateString() }}', '{{ $day['date']->isoFormat('dddd, D MMMM') }}', '{{ $status }}')"
                                                    class="group/status relative focus:outline-none">
                                                    @if ($status === 'receive')
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center group-hover/status:bg-green-200 transition-colors">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </div>
                                                            <span
                                                                class="text-[9px] font-black text-green-700 uppercase">Menerima</span>
                                                        </div>
                                                    @elseif($status === 'holiday')
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center group-hover/status:bg-red-100 transition-colors">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </div>
                                                            <span
                                                                class="text-[9px] font-black text-red-700 uppercase">Libur</span>
                                                        </div>
                                                    @else
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-gray-50 text-gray-300 flex items-center justify-center group-hover/status:bg-gray-100 transition-colors">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <span
                                                                class="text-[9px] font-black text-gray-400 uppercase">Belum</span>
                                                        </div>
                                                    @endif
                                                </button>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Menu Summary (Admin Only) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-black text-gray-900">Menu Minggu Ini</h3>
                        <div class="h-px flex-1 bg-gray-100 mx-6"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                        @foreach ($weekDays as $day)
                            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">
                                    {{ $day['date']->isoFormat('dddd') }}</p>
                                @if ($day['menu'])
                                    <p class="font-bold text-gray-900 leading-tight">{{ $day['menu']->name }}</p>
                                    <span
                                        class="inline-block mt-2 px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded uppercase">
                                        {{ $day['menu']->type === 'wet' ? 'Basah' : 'Kering' }}
                                    </span>
                                @else
                                    <p class="text-sm font-bold text-gray-300 italic">Belum dijadwalkan</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endrole
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] w-full max-w-sm overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300"
            id="statusModalContent">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-gray-900 tracking-tight">Update Status</h3>
                    <p class="text-xs font-medium text-gray-400" id="statusModalSub"></p>
                </div>
                <button onclick="closeStatusModal()"
                    class="w-8 h-8 flex items-center justify-center bg-gray-50 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('calendars.update-status') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="school_id" id="statusSchoolId">
                <input type="hidden" name="date" id="statusDate">

                <button type="submit" name="day_status" value="receive"
                    class="w-full p-4 rounded-2xl border-2 border-green-50 bg-green-50/50 hover:bg-green-50 hover:border-green-200 transition-all flex items-center gap-4 group">
                    <div
                        class="w-10 h-10 rounded-xl bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-green-900">Menerima MBG</p>
                        <p class="text-[10px] text-green-600 font-medium">Sekolah aktif menerima distribusi hari ini.
                        </p>
                    </div>
                </button>

                <button type="submit" name="day_status" value="holiday"
                    class="w-full p-4 rounded-2xl border-2 border-red-50 bg-red-50/50 hover:bg-red-50 hover:border-red-200 transition-all flex items-center gap-4 group">
                    <div
                        class="w-10 h-10 rounded-xl bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-red-900">Libur Sekolah</p>
                        <p class="text-[10px] text-red-600 font-medium">Sekolah sedang libur, tidak ada distribusi.</p>
                    </div>
                </button>

                <button type="submit" name="day_status" value="delete"
                    class="w-full p-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 hover:bg-gray-100 hover:border-gray-200 transition-all flex items-center gap-4 group mt-4">
                    <div class="w-10 h-10 rounded-xl bg-gray-400 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-gray-700">Hapus Data</p>
                        <p class="text-[10px] text-gray-400 font-medium">Kembalikan ke status belum terisi.</p>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <!-- Bulk Update Modal -->
    <div id="bulkModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] w-full max-w-sm overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300"
            id="bulkModalContent">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-900 text-white">
                <div>
                    <h3 class="text-xl font-black tracking-tight" id="bulkModalTitle">Bulk Action</h3>
                    <p class="text-xs font-medium text-gray-400" id="bulkModalSub"></p>
                </div>
                <button onclick="closeBulkModal()"
                    class="w-8 h-8 flex items-center justify-center bg-white/10 rounded-full hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('calendars.bulk-update-status') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="date" id="bulkDate">
                <input type="hidden" name="day_status" id="bulkStatus">

                <div class="text-center space-y-2">
                    <p class="text-gray-600">Anda yakin ingin mengubah <span class="font-bold text-gray-900">SEMUA
                            SEKOLAH</span> pada tanggal ini menjadi <span id="bulkStatusLabel"
                            class="font-black uppercase tracking-wider"></span>?</p>
                    <p class="text-xs text-red-500 font-medium italic">Aksi ini akan menimpa data yang sudah ada.</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeBulkModal()"
                        class="flex-1 py-3 border-2 border-gray-100 text-gray-500 font-bold text-sm rounded-xl hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" id="bulkSubmitBtn"
                        class="flex-2 px-8 py-3 bg-gray-900 text-white font-bold text-sm rounded-xl shadow-lg hover:bg-black transition-all">
                        Ya, Terapkan Masal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(schoolId, schoolName, date, dateStr, currentStatus) {
            document.getElementById('statusSchoolId').value = schoolId;
            document.getElementById('statusDate').value = date;
            document.getElementById('statusModalSub').innerText = schoolName + ' - ' + dateStr;

            const modal = document.getElementById('statusModal');
            const content = document.getElementById('statusModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeStatusModal() {
            const content = document.getElementById('statusModalContent');
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                document.getElementById('statusModal').classList.add('hidden');
            }, 300);
        }

        function openBulkModal(date, dateStr, status) {
            document.getElementById('bulkDate').value = date;
            document.getElementById('bulkStatus').value = status;
            document.getElementById('bulkModalSub').innerText = dateStr;

            const label = document.getElementById('bulkStatusLabel');
            const btn = document.getElementById('bulkSubmitBtn');

            if (status === 'receive') {
                label.innerText = 'MENERIMA MBG';
                label.className = 'font-black uppercase tracking-wider text-green-600';
                btn.className =
                    'flex-2 px-8 py-3 bg-green-600 text-white font-bold text-sm rounded-xl shadow-lg hover:bg-green-700 transition-all';
            } else {
                label.innerText = 'LIBUR SEKOLAH';
                label.className = 'font-black uppercase tracking-wider text-red-600';
                btn.className =
                    'flex-2 px-8 py-3 bg-red-600 text-white font-bold text-sm rounded-xl shadow-lg hover:bg-red-700 transition-all';
            }

            const modal = document.getElementById('bulkModal');
            const content = document.getElementById('bulkModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeBulkModal() {
            const content = document.getElementById('bulkModalContent');
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                document.getElementById('bulkModal').classList.add('hidden');
            }, 300);
        }

        function applyWeek(dateString) {
            document.getElementById('start_date').value = dateString;
            document.getElementById('start_date').form.submit();
        }

        function updateEndDate(startDate) {
            if (!startDate) return;
            const date = new Date(startDate);
            // Snap to Monday if not already
            const day = date.getDay(); // 0 is Sun, 1 is Mon
            if (day !== 1) {
                const diff = (day === 0 ? -6 : 1) - day;
                date.setDate(date.getDate() + diff);
                document.getElementById('start_date').value = date.toISOString().split('T')[0];
            }

            // Auto submit
            document.getElementById('start_date').form.submit();
        }
    </script>
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</x-app-layout>
