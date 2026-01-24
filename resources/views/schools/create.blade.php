<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('schools.index') }}" class="hover:text-blue-600 transition-colors">Sekolah</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span>Tambah Baru</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Sekolah Baru</h2>
            </div>
            
            <a href="{{ route('schools.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('schools.store') }}" method="POST">
            @csrf

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    
                    <!-- School Info Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">01</span>
                            Informasi Sekolah
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                           class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                           placeholder="contoh: SDN Merdeka 01">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <textarea name="address" id="address" rows="3" required
                                           class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                           placeholder="Jalan, Kecamatan, Kota">{{ old('address') }}</textarea>
                                </div>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Capacity Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span class="bg-green-100 text-green-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">02</span>
                            Kapasitas & Distribusi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-green-50/50 p-6 rounded-2xl border border-green-100">
                             <!-- Teacher Count -->
                             <div>
                                <label for="teacher_count" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Guru</label>
                                <div class="relative">
                                    <input type="number" name="teacher_count" id="teacher_count" value="{{ old('teacher_count', 0) }}" min="0" required
                                           class="block w-full px-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow text-center font-bold text-lg"
                                           placeholder="0">
                                </div>
                                <p class="text-xs text-center mt-2 text-gray-500">Total Pengajar</p>
                                <x-input-error :messages="$errors->get('teacher_count')" class="mt-2" />
                            </div>

                            <!-- Small Portion -->
                            <div>
                                <label for="small_portion_count" class="block text-sm font-semibold text-gray-700 mb-2">Porsi Kecil</label>
                                <div class="relative">
                                    <input type="number" name="small_portion_count" id="small_portion_count" value="{{ old('small_portion_count', 0) }}" min="0" required
                                           class="block w-full px-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow text-center font-bold text-lg"
                                           placeholder="0">
                                </div>
                                <p class="text-xs text-center mt-2 text-gray-500">Siswa Kelas Rendah</p>
                                <x-input-error :messages="$errors->get('small_portion_count')" class="mt-2" />
                            </div>

                            <!-- Large Portion -->
                            <div>
                                <label for="large_portion_count" class="block text-sm font-semibold text-gray-700 mb-2">Porsi Besar</label>
                                <div class="relative">
                                    <input type="number" name="large_portion_count" id="large_portion_count" value="{{ old('large_portion_count', 0) }}" min="0" required
                                           class="block w-full px-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow text-center font-bold text-lg"
                                           placeholder="0">
                                </div>
                                <p class="text-xs text-center mt-2 text-gray-500">Siswa Kelas Tinggi + Guru</p>
                                <x-input-error :messages="$errors->get('large_portion_count')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                     <!-- Status Section -->
                     <div>
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">Status Aktif</h3>
                                    <p class="text-xs text-gray-500">Sekolah aktif akan muncul dalam perencanaan menu dan distribusi.</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('schools.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-white hover:border-gray-300 transition-all shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-500/30">
                        Simpan Sekolah
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
