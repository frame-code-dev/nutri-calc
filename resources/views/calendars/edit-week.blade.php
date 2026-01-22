<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Update Jadwal
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 font-medium italic">
                        {{ $school->name }} • Minggu {{ $weekNumber }}, {{ $year }}
                    </p>
                </div>
                <a href="{{ route('calendars.index', ['school_id' => $school->id, 'week' => $weekNumber, 'year' => $year]) }}" 
                   class="text-sm font-bold text-gray-400 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Petunjuk Minimalis -->
            <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-100 flex items-start gap-4">
                <div class="bg-blue-500 p-1.5 rounded-lg text-white mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-sm text-blue-800 leading-relaxed">
                    <p class="font-bold mb-0.5 uppercase tracking-wider text-[10px]">Informasi Pengisian</p>
                    <p>Tentukan status kehadiran untuk setiap hari kerja. Sistem akan otomatis menyesuaikan jenis menu berdasarkan pilihan Anda.</p>
                </div>
            </div>

            <form action="{{ route('calendars.save-week') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="school_id" value="{{ $school->id }}">
                <input type="hidden" name="week" value="{{ $weekNumber }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <!-- Daily Forms -->
                <div class="space-y-6">
                    @foreach($weekDates as $index => $item)
                        @php
                            $date = $item['date'];
                            $calendar = $item['calendar'];
                            $currentStatus = old("dates.{$index}.day_status", $calendar?->day_status);
                        @endphp
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-6 md:p-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                                <!-- Date Info -->
                                <div class="flex items-center gap-4 min-w-[180px]">
                                    <div class="bg-gray-50 rounded-2xl p-3 text-center min-w-[70px]">
                                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">{{ $date->isoFormat('ddd') }}</p>
                                        <p class="text-2xl font-black text-gray-900">{{ $date->format('d') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-900">{{ $date->isoFormat('dddd') }}</p>
                                        <p class="text-xs font-semibold text-gray-400 italic">{{ $date->isoFormat('D MMMM YYYY') }}</p>
                                    </div>
                                </div>

                                <input type="hidden" name="dates[{{ $index }}][date]" value="{{ $date->toDateString() }}">

                                <!-- Status Selection Tiles -->
                                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Receive Option -->
                                    <div class="space-y-3 flex-1">
                                        <label class="status-option-label relative cursor-pointer group block">
                                            <input type="radio" 
                                                   name="dates[{{ $index }}][day_status]" 
                                                   value="receive" 
                                                   class="sr-only status-radio"
                                                   {{ $currentStatus === 'receive' ? 'checked' : '' }}
                                                   required>
                                            <div class="status-tile flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 bg-white hover:bg-gray-50/50 transition-all duration-300">
                                                <div class="status-icon-box p-2.5 rounded-xl bg-gray-50 text-gray-400 transition-all duration-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 transition-colors duration-300">Menerima</p>
                                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-black transition-colors duration-300">Siswa Makan</p>
                                                </div>
                                            </div>
                                        </label>
                                        <div class="flex gap-2 px-1">
                                            <div class="flex-1 bg-blue-50/50 rounded-xl p-2 border border-blue-100/50">
                                                <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest">Porsi Kecil</p>
                                                <p class="text-xs font-bold text-blue-700">{{ $school->small_portion_count }}</p>
                                            </div>
                                            <div class="flex-1 bg-indigo-50/50 rounded-xl p-2 border border-indigo-100/50">
                                                <p class="text-[8px] font-black text-indigo-400 uppercase tracking-widest">Porsi Besar</p>
                                                <p class="text-xs font-bold text-indigo-700">{{ $school->large_portion_count }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Holiday Option -->
                                    <label class="status-option-label relative cursor-pointer group self-start">
                                        <input type="radio" 
                                               name="dates[{{ $index }}][day_status]" 
                                               value="holiday" 
                                               class="sr-only status-radio"
                                               {{ $currentStatus === 'holiday' ? 'checked' : '' }}>
                                        <div class="status-tile flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 bg-white hover:bg-gray-50/50 transition-all duration-300">
                                            <div class="status-icon-box p-2.5 rounded-xl bg-gray-50 text-gray-400 transition-all duration-300">
                                                <span class="text-2xl grayscale opacity-40 transition-all duration-300 status-emoji">🏖️</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 transition-colors duration-300">Libur</p>
                                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-black transition-colors duration-300">Tidak Ada Makan</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-between bg-white/80 backdrop-blur-md sticky bottom-6 p-4 rounded-3xl border border-gray-100 shadow-xl z-10">
                    <p class="text-xs font-bold text-gray-400 italic ml-4">Pastikan data yang diinput sudah sesuai.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('calendars.index', ['school_id' => $school->id, 'week' => $weekNumber, 'year' => $year]) }}" 
                           class="px-6 py-3 rounded-2xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition-all active:scale-95">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-sm font-black shadow-lg shadow-blue-200 transition-all transform active:scale-95 flex items-center gap-2">
                             Simpan Jadwal
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .status-radio:checked + .status-tile {
            border-color: #2563eb;
            background-color: #eff6ff;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
        }

        .status-radio:checked + .status-tile .status-icon-box {
            background-color: #2563eb;
            color: white;
        }

        .status-radio:checked + .status-tile p:first-of-type {
            color: #1e40af;
        }

        .status-radio:checked + .status-tile p:last-of-type {
            color: #3b82f6;
        }

        .status-radio:checked + .status-tile .grayscale {
            filter: grayscale(0);
            opacity: 1;
        }

        .status-option-label:active .status-tile {
            transform: scale(0.98);
        }
    </style>
</x-app-layout>
