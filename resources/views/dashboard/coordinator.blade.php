<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            Dashboard Koordinator - {{ $school->name }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- School Info Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">{{ $school->name }}</h3>
                    <p class="text-blue-100">{{ $school->address }}</p>
                    <p class="mt-2">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                            👥 {{ number_format($school->student_count) }} Siswa
                        </span>
                    </p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <p class="text-sm text-blue-100">Status</p>
                        <p class="text-2xl font-bold">
                            {{ $school->is_active ? '✅ Aktif' : '❌ Nonaktif' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">📅 Jadwal Menu Minggu Depan</h3>
            
            @if($upcomingCalendars->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Belum ada jadwal menu untuk minggu depan. Mohon hubungi Admin MBG untuk pengaturan jadwal.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($upcomingCalendars as $calendar)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 rounded-lg p-3 text-center min-w-[80px]">
                                    <p class="text-xs text-blue-600 font-medium">{{ $calendar->date->isoFormat('ddd') }}</p>
                                    <p class="text-2xl font-bold text-blue-700">{{ $calendar->date->format('d') }}</p>
                                    <p class="text-xs text-blue-600">{{ $calendar->date->isoFormat('MMM') }}</p>
                                </div>
                                <div>
                                    @if($calendar->day_status === 'receive')
                                        <p class="font-semibold text-gray-900 text-lg">
                                            {{ $calendar->menu->name ?? 'Menu belum ditentukan' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Menerima MBG
                                            </span>
                                            @if($calendar->menu)
                                                <span class="ml-2 text-gray-500">
                                                    {{ $calendar->menu->type === 'wet' ? '🍱 Menu Basah' : '📦 Menu Kering' }}
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Porsi: {{ $calendar->portion_count }} porsi
                                        </p>
                                    @else
                                        <p class="font-semibold text-gray-900 text-lg">Hari Libur</p>
                                        <p class="text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                🏖️ Tidak Menerima
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Isi Status Mingguan</h4>
                <p class="text-sm text-gray-600 mb-4">Update status penerimaan MBG untuk minggu depan</p>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Isi Status
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Lihat Semua Menu</h4>
                <p class="text-sm text-gray-600 mb-4">Daftar menu yang tersedia di sistem</p>
                <a href="{{ route('menus.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Lihat Menu
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Laporan Gizi</h4>
                <p class="text-sm text-gray-600 mb-4">Lihat laporan kandungan gizi untuk sekolah</p>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Lihat Laporan
                </button>
            </div>
        </div>

        <!-- Information Box -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Penting:</strong> Mohon mengisi status penerimaan MBG setiap minggu sebelum batas waktu yang ditentukan. 
                        Sistem akan mengirimkan reminder otomatis via WhatsApp jika status belum lengkap.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
