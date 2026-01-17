<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                🔒 Manajemen Kunci Mingguan
            </h2>
            <a href="{{ route('weekly-locks.history') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium">
                📜 Riwayat Lock
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Week Selector -->
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" action="{{ route('weekly-locks.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minggu</label>
                    <input type="number" name="week" min="1" max="53" value="{{ $weekNumber }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" name="year" min="2024" max="2030" value="{{ $year }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex items-end md:col-span-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        🔍 Lihat Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Lock Status Card -->
        <div class="bg-gradient-to-r {{ $lock && $lock->is_locked ? 'from-red-500 to-red-600' : 'from-green-500 to-green-600' }} rounded-lg shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-3">
                        @if($lock && $lock->is_locked)
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold">🔒 TERKUNCI</h3>
                                <p class="text-white text-opacity-90 mt-1">Minggu {{ $weekNumber }}, Tahun {{ $year }}</p>
                            </div>
                        @else
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold">🔓 TERBUKA</h3>
                                <p class="text-white text-opacity-90 mt-1">Minggu {{ $weekNumber }}, Tahun {{ $year }}</p>
                            </div>
                        @endif
                    </div>

                    @if($lock && $lock->is_locked)
                        <div class="text-sm text-white text-opacity-75 mt-3 space-y-1">
                            <p><strong>Dikunci oleh:</strong> {{ $lock->lockedBy->name ?? 'System' }}</p>
                            <p><strong>Waktu:</strong> {{ $lock->locked_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Lock Actions -->
                <div class="text-right">
                    @if($lock && $lock->is_locked)
                        @can('manage weekly locks')
                            @if(auth()->user()->hasRole('Super Admin'))
                                <form action="{{ route('weekly-locks.unlock') }}" method="POST" onsubmit="return confirm('Yakin ingin membuka kunci minggu ini? Koordinator akan bisa mengubah data lagi!')">
                                    @csrf
                                    <input type="hidden" name="week_number" value="{{ $weekNumber }}">
                                    <input type="hidden" name="year" value="{{ $year }}">
                                    <button type="submit" class="bg-white hover:bg-gray-100 text-red-600 px-8 py-4 rounded-lg font-bold text-lg">
                                        🔓 Buka Kunci
                                    </button>
                                </form>
                            @else
                                <div class="text-white text-opacity-75 text-sm">
                                    Hanya Super Admin<br>yang dapat membuka kunci
                                </div>
                            @endif
                        @endcan
                    @else
                        @can('manage weekly locks')
                            <form action="{{ route('weekly-locks.lock') }}" method="POST" onsubmit="return confirm('Yakin ingin mengunci minggu ini? Setelah dikunci, koordinator tidak bisa mengubah data!')">
                                @csrf
                                <input type="hidden" name="week_number" value="{{ $weekNumber }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <button type="submit" 
                                        class="bg-white hover:bg-gray-100 {{ $canLock ? 'text-green-600' : 'text-gray-400 cursor-not-allowed' }} px-8 py-4 rounded-lg font-bold text-lg"
                                        {{ $canLock ? '' : 'disabled' }}>
                                    🔒 Kunci Minggu Ini
                                </button>
                            </form>
                        @endcan
                    @endif
                </div>
            </div>
        </div>

        <!-- Completion Summary -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">📊 Status Kelengkapan Sekolah</h3>
                <div class="text-sm">
                    <span class="font-bold text-2xl {{ $canLock ? 'text-green-600' : 'text-orange-600' }}">
                        {{ $completedSchools }}/{{ $totalSchools }}
                    </span>
                    <span class="text-gray-600">sekolah lengkap</span>
                </div>
            </div>

            @if(!$canLock && $totalSchools > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Tidak dapat mengunci!</strong> Pastikan semua sekolah sudah melengkapi jadwal 5 hari (Senin-Jumat).
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Schools List -->
            <div class="space-y-3">
                @foreach($schoolsStatus as $status)
                    <div class="flex items-center justify-between p-4 {{ $status['is_complete'] ? 'bg-green-50' : 'bg-red-50' }} rounded-lg border {{ $status['is_complete'] ? 'border-green-200' : 'border-red-200' }}">
                        <div class="flex items-center space-x-3">
                            @if($status['is_complete'])
                                <div class="bg-green-500 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="bg-red-500 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $status['school']->name }}</p>
                                <p class="text-sm text-gray-600">{{ number_format($status['school']->student_count) }} siswa</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold {{ $status['is_complete'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $status['filled'] }}/5 hari
                            </p>
                            <a href="{{ route('calendars.index', ['school_id' => $status['school']->id, 'week' => $weekNumber, 'year' => $year]) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
