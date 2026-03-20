<x-app-layout hideSidebar="true">
    <div class="min-h-[80vh] flex flex-col items-center justify-center p-6 bg-slate-50/50">
        
        <!-- Odoo-style App Launcher -->
        <div class="w-full max-w-6xl mx-auto">
            
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">App Dashboard</h1>
                <p class="text-slate-500 mt-2">Pilih modul aplikasi untuk mulai bekerja</p>
            </div>

            <!-- Categories & Apps Grid -->
            <div class="space-y-12">
                
                <!-- Operasional -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pl-2 border-l-4 border-blue-500">Operasional</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        
                        <!-- Menu Makan -->
                        <a href="{{ route('menus.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 shadow-md shadow-blue-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="utensils" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Menu Makan</span>
                        </a>

                        <!-- Siklus Menu -->
                        <a href="{{ route('menu-schedules.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-500 shadow-md shadow-blue-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="refresh-cw" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Siklus Menu</span>
                        </a>

                        <!-- Kalender Sekolah -->
                        <a href="{{ route('calendars.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-sky-400 to-sky-500 shadow-md shadow-sky-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="calendar-days" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Kalender Sekolah</span>
                        </a>

                        <!-- Monitoring -->
                        <a href="{{ route('monitoring.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-md shadow-indigo-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="shield-check" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Monitoring & Kunci</span>
                        </a>

                        <!-- Master SPPG -->
                        <a href="{{ route('master-sppg.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-slate-600 to-slate-700 shadow-md shadow-slate-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="file-check-2" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Master SPPG</span>
                        </a>
                        
                    </div>
                </div>

                <!-- Logistik -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pl-2 border-l-4 border-emerald-500">Logistik</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        
                        <!-- Stok Gudang -->
                        <a href="{{ route('stocks.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-md shadow-emerald-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="warehouse" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Stok Gudang</span>
                        </a>

                        <!-- Belanja Bahan -->
                        <a href="{{ route('procurements.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 shadow-md shadow-green-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="shopping-cart" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Belanja Bahan</span>
                        </a>

                        <!-- Bahan Baku -->
                        <a href="{{ route('raw-materials.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-teal-600 shadow-md shadow-teal-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="apple" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Bahan Baku</span>
                        </a>

                        <!-- Supplier -->
                        <a href="{{ route('suppliers.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-cyan-600 shadow-md shadow-cyan-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="store" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Supplier</span>
                        </a>

                    </div>
                </div>

                <!-- Distribusi -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pl-2 border-l-4 border-violet-500">Distribusi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        
                        <!-- Pengiriman -->
                        <a href="{{ route('distribution.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-violet-500 to-violet-600 shadow-md shadow-violet-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="truck" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Pengiriman</span>
                        </a>

                        <!-- Setting Kloter -->
                        <a href="{{ route('kloters.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 shadow-md shadow-fuchsia-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="settings-2" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Setting Kloter</span>
                        </a>

                    </div>
                </div>

                <!-- Laporan -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pl-2 border-l-4 border-orange-500">Laporan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        
                        <!-- Laporan Gizi -->
                        <a href="{{ route('nutrition-reports.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-500 shadow-md shadow-orange-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="pie-chart" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Laporan Gizi</span>
                        </a>

                        <!-- Laporan Menu -->
                        @if(Route::has('reports.weekly-menu'))
                        <a href="{{ route('reports.weekly-menu') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 shadow-md shadow-amber-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="file-spreadsheet" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Laporan Menu</span>
                        </a>
                        @endif

                        <!-- Sekolah -->
                        <a href="{{ route('schools.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-rose-400 to-rose-500 shadow-md shadow-rose-200 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="school" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Data Sekolah</span>
                        </a>

                    </div>
                </div>

                <!-- SDM / Konfigurasi -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pl-2 border-l-4 border-slate-700">Manajemen SDM</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        
                        <!-- Relawan -->
                        <a href="{{ route('relawans.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-slate-700 to-slate-800 shadow-md shadow-slate-300 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="users" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Relawan</span>
                        </a>

                        <!-- Gaji Relawan -->
                        <a href="{{ route('gaji-relawan.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-slate-600 to-slate-700 shadow-md shadow-slate-300 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="wallet" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Gaji & Absen</span>
                        </a>

                        <!-- Pengaturan Upah -->
                        <a href="{{ route('salary-settings.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-slate-500 to-slate-600 shadow-md shadow-slate-300 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="badge-dollar-sign" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Upah Jabatan</span>
                        </a>

                        <!-- Pengguna -->
                        <a href="{{ route('users.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-20 h-20 bg-gradient-to-br from-zinc-800 to-zinc-900 shadow-md shadow-zinc-300 rounded-3xl flex items-center justify-center text-white group-hover:scale-105 transition-transform">
                                <i data-lucide="user-cog" class="w-10 h-10"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center leading-tight">Pengguna (Hak Akses)</span>
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
    <!-- Inject Lucide Icons script if not present globally -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>
    @endpush
</x-app-layout>
