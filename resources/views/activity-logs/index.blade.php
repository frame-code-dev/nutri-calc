<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Log Activity</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Pantau seluruh aktivitas pengguna di dalam sistem</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('activity-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aksi atau user..." class="w-full text-xs font-semibold text-gray-700 bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-2 px-4 shadow-sm">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="action" class="w-full text-xs font-semibold text-gray-700 bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-2 px-3 shadow-sm" onchange="this.form.submit()">
                            <option value="">Semua Aksi</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all whitespace-nowrap">
                        Terapkan Filter
                    </button>
                    @if(request()->anyFilled(['search', 'action']))
                        <a href="{{ route('activity-logs.index') }}" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl shadow-sm transition-all whitespace-nowrap text-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-widest">
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">User / IP</th>
                                <th class="px-6 py-4">Aksi</th>
                                <th class="px-6 py-4">Deskripsi / Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ $log->created_at->isoFormat('D MMM Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                                        <p class="text-xs text-blue-500 font-mono">{{ $log->ip_address }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($log->action === 'created')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                Created
                                            </span>
                                        @elseif($log->action === 'updated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                Updated
                                            </span>
                                        @elseif($log->action === 'deleted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                                Deleted
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-700 text-sm">{{ $log->description }}</p>
                                        @if($log->model_type)
                                            <p class="text-[10px] text-gray-400 font-mono mt-1 break-all">{{ $log->model_type }} #{{ $log->model_id }}</p>
                                        @endif
                                        
                                        @if($log->changes)
                                            <div x-data="{ expanded: false }" class="mt-2">
                                                <button @click="expanded=!expanded" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1 focus:outline-none">
                                                    Lihat Perubahan Data
                                                    <svg class="w-3 h-3 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                                <div x-show="expanded" x-cloak class="mt-2 p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-mono overflow-x-auto max-w-xl custom-scrollbar" style="display: none;">
                                                    @if(isset($log->changes['old']) && isset($log->changes['new']))
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <span class="font-bold text-gray-500 block mb-1 uppercase tracking-widest text-[9px]">Sebelum (Old)</span>
                                                                <pre class="text-[10px] text-rose-600 whitespace-pre-wrap">{{ json_encode($log->changes['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                            </div>
                                                            <div>
                                                                <span class="font-bold text-gray-500 block mb-1 uppercase tracking-widest text-[9px]">Sesudah (New)</span>
                                                                <pre class="text-[10px] text-emerald-600 whitespace-pre-wrap">{{ json_encode($log->changes['new'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <pre class="text-[10px] text-gray-600 whitespace-pre-wrap">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">Belum ada Log Activity.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
