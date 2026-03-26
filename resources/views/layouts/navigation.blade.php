<aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col font-sans">

    <!-- Logo -->
    <div class="flex items-center h-16 px-6 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <span class="text-lg font-bold text-gray-900 tracking-tight">Management Gizi</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        <!-- App Launcher -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.admin') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.admin') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }} transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            App Launcher
        </a>

        <!-- Dashboard Statistik -->
        @role('Super Admin|Admin MBG|Ahli Gizi')
        <a href="{{ route('dashboard.statistics') }}"
            class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard.statistics') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard.statistics') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }} transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Dashboard Statistik
        </a>
        @endrole

        <!-- Group: Operasional -->
        <div class="pt-4 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Operasional</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            @can('view menus')
                <a href="{{ route('menus.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('menus*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('menus*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Menu Makan
                </a>
            @endcan

            @role('Super Admin|Admin MBG|Ahli Gizi')
                <a href="{{ route('menu-schedules.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('menu-schedules*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('menu-schedules*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Siklus Menu
                </a>
                <a href="{{ route('menu-histories.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('menu-histories*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('menu-histories*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    History Menu
                </a>
                <a href="{{ route('calendars.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('calendars*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('calendars*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kalender Sekolah
                </a>
                <a href="{{ route('monitoring.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('monitoring*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('monitoring*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Monitoring & Kunci
                </a>
            @endrole
        </div>

        <!-- Group: Logistik -->
        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Logistik</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            @can('view stocks')
                <a href="{{ route('stocks.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('stocks*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('stocks*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    Stok Gudang
                </a>
            @endcan

            @role('Super Admin|Admin MBG|Ahli Gizi')
                <a href="{{ route('procurements.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('procurements*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('procurements*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Belanja Bahan
                </a>
            @endrole

            @can('view raw materials')
                <a href="{{ route('raw-materials.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('raw-materials*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('raw-materials*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Bahan Baku
                </a>
            @endcan

            @can('view suppliers')
                <a href="{{ route('suppliers.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('suppliers*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('suppliers*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Supplier
                </a>
            @endcan

            @can('view categories')
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('categories*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('categories*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    Kategori
                </a>
            @endcan
        </div>

        <!-- Group: Distribusi -->
        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Distribusi</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            @role('Super Admin|Admin MBG|Ahli Gizi')
                <a href="{{ route('distribution.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('distribution.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('distribution.index') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9a1 1 0 01-1-1v-5a1 1 0 011-1h2a1 1 0 011 1v5zm0 0h1m4 0h1a1 1 0 001-1v-4a1 1 0 00-1-1h-2l-1-1V5a1 1 0 00-1-1h-2" />
                    </svg>
                    Pengiriman
                </a>
                <a href="{{ route('distribution.settings') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('distribution.settings') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('distribution.settings') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Setting Kloter
                </a>
            @endrole
        </div>

        <!-- Group: Laporan -->
        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Laporan</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <a href="{{ route('nutrition-reports.index') }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('nutrition-reports*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('nutrition-reports*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Gizi
            </a>

            <a href="{{ route('reports.weekly-menu') }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('reports.weekly-menu*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.weekly-menu*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Menu
            </a>
        </div>

        <!-- Group: SDM / Gaji Relawan -->
        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">SDM</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            @role('Super Admin|Admin MBG')
                <a href="{{ route('relawans.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('relawans*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('relawans*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Data Relawan
                </a>

                <a href="{{ route('gaji-relawan.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('gaji-relawan*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('gaji-relawan*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Gaji Relawan
                </a>

                <a href="{{ route('salary-settings.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('salary-settings*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('salary-settings*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Setting Upah
                </a>
            @endrole
        </div>


        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Administrator</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            @role('Super Admin|Admin MBG')
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('users*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('users*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manajemen User
                </a>
            @endrole

            @role('Super Admin')
                <a href="{{ route('master-sppg.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('master-sppg*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('master-sppg*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Master SPPG
                </a>
            @endrole

            @can('view schools')
                <a href="{{ route('schools.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('schools*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('schools*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Penerima Manfaat
                </a>
            @endcan
        </div>

        <div class="pt-2 pb-2">
            <div class="px-3 mb-2 flex items-center gap-2">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sistem & Log</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <a href="{{ route('document-attachments.index') }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('document-attachments*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('document-attachments*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                </svg>
                Dokumentasi Lampiran
            </a>

            <a href="{{ route('activity-logs.index') }}"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('activity-logs*') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('activity-logs*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Log Activity
            </a>
        </div>
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex-shrink-0">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center w-full px-2 py-2 text-sm rounded-xl hover:bg-white hover:shadow-sm transition-all duration-200 text-left">
                <div class="flex items-center flex-1 min-w-0">
                    <div
                        class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-sm flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500 font-bold truncate uppercase tracking-widest">
                            {{ Auth::user()->roles->first()->name ?? 'User' }}</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 ml-2" :class="open ? 'rotate-180' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-2xl shadow-xl border border-gray-100 py-1 z-50 overflow-hidden">
                <div class="px-4 py-2 border-b border-gray-50">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Akun</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-sm text-gray-600 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-bold">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
