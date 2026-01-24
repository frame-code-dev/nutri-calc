<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('schools.index') }}" class="hover:text-blue-600 transition-colors">Sekolah</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span>Detail</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $school->name }}</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('schools.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('schools.edit', $school) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Sekolah
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Info & Stats -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </span>
                                Informasi Utama
                            </h3>
                            @if($school->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 ring-1 ring-inset ring-green-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-1.5"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 ring-1 ring-inset ring-red-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Sekolah</h4>
                                <p class="text-gray-900 font-medium text-lg">{{ $school->name }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Alamat</h4>
                                <p class="text-gray-900">{{ $school->address }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-100">
                             <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Kapasitas & Distribusi</h4>
                             <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                    <p class="text-3xl font-bold text-blue-700">{{ $school->teacher_count }}</p>
                                    <p class="text-xs font-medium text-blue-600 mt-1">Jumlah Guru</p>
                                </div>
                                <div class="bg-green-50/50 p-4 rounded-xl border border-green-100">
                                    <p class="text-3xl font-bold text-green-700">{{ $school->small_portion_count }}</p>
                                    <p class="text-xs font-medium text-green-600 mt-1">Porsi Kecil (Kelas Rendah)</p>
                                </div>
                                <div class="bg-orange-50/50 p-4 rounded-xl border border-orange-100">
                                    <p class="text-3xl font-bold text-orange-700">{{ $school->large_portion_count }}</p>
                                    <p class="text-xs font-medium text-orange-600 mt-1">Porsi Besar (Kelas Tinggi/Guru)</p>
                                </div>
                             </div>
                             <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Total Kebutuhan Harian</span>
                                <span class="text-xl font-bold text-gray-900">{{ $school->teacher_count + $school->small_portion_count + $school->large_portion_count }} Porsi</span>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                         <div class="flex items-center mb-4">
                            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 mr-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Jadwal</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $school->calendars->count() }}</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: 70%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Hari terjadwal dalam sistem</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center mb-4">
                           <div class="p-2 bg-purple-100 rounded-lg text-purple-600 mr-3">
                               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                               </svg>
                           </div>
                           <div>
                               <p class="text-sm font-medium text-gray-600">Total Distribusi</p>
                               <p class="text-2xl font-bold text-gray-900">{{ number_format($school->calendars->sum('portion_count')) }}</p>
                           </div>
                       </div>
                       <div class="w-full bg-gray-200 rounded-full h-1.5">
                           <div class="bg-purple-600 h-1.5 rounded-full" style="width: 45%"></div>
                       </div>
                       <p class="text-xs text-gray-500 mt-2">Porsi telah didistribusikan</p>
                   </div>
                </div>
            </div>

            <!-- Right Column: Coordinators & Actions -->
            <div class="space-y-6">
                <!-- Coordinators -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Koordinator</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Kelola</button>
                    </div>
                    <div class="p-6">
                        @if($school->coordinators->isEmpty())
                            <div class="text-center py-6">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Belum ada koordinator.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($school->coordinators as $coordinator)
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                {{ substr($coordinator->user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $coordinator->user->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $coordinator->whatsapp_number }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Aksi Cepat</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <a href="{{ route('calendars.index', ['school_id' => $school->id]) }}" class="w-full flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-medium text-gray-900">Lihat Kalender</span>
                                <span class="block text-xs text-gray-500">Cek jadwal distribusi</span>
                            </div>
                        </a>
                        
                        <a href="#" class="w-full flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                             <div class="p-2 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-100 transition-colors mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-medium text-gray-900">Laporan</span>
                                <span class="block text-xs text-gray-500">Lihat laporan bulanan</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
