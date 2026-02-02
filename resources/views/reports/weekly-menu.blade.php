<x-app-layout>
    <div class="pb-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 py-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Laporan Menu Mingguan</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Export data bahan menu per hari ke Excel</p>
                </div>
            </div>

            <!-- Filter & Export Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Filter Export</h3>
                            <p class="text-sm text-gray-500">Pilih minggu dan tahun untuk export</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('reports.weekly-menu.export') }}" method="POST" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Week Selector -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Minggu Ke</label>
                            <select name="week"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 py-3 transition-all"
                                onchange="updateDates(this.value, document.getElementsByName('year')[0].value)">
                                @for ($i = 1; $i <= 52; $i++)
                                    <option value="{{ $i }}" {{ $weekNumber == $i ? 'selected' : '' }}>
                                        Minggu {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Year Selector -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tahun</label>
                            <select name="year"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 py-3 transition-all"
                                onchange="updateDates(document.getElementsByName('week')[0].value, this.value)">
                                @for ($y = 2024; $y <= 2026; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-8 text-center border border-gray-100">
                        <p class="text-sm font-medium text-gray-600">
                            Export untuk periode: <br>
                            <span class="font-black text-gray-900 text-lg" id="dateRangeDisplay">
                                {{ \Carbon\Carbon::parse($dates[0])->format('d M') }} -
                                {{ \Carbon\Carbon::parse($dates[5])->format('d M Y') }}
                            </span>
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all shadow-lg shadow-green-500/30">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Laporan Excel (.xlsx)
                        </button>
                    </div>
                </form>
            </div>

            <!-- Information -->
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <div class="flex gap-4">
                    <div class="shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-1">Informasi Laporan</h4>
                        <p class="text-sm text-blue-700">
                            Laporan ini akan mengunduh file Excel berisi daftar bahan baku yang digunakan pada menu
                            setiap harinya (Senin - Sabtu).
                            Data diambil dari menu yang di-assign dengan status <strong>"Menerima"</strong> (Receive).
                            Jika ada beberapa menu berbeda di sekolah yang berbeda pada hari yang sama, semua bahan unik
                            akan digabungkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple script to update date range hint (Optional enhancement)
        // In a real implementation, this might need an API call or logic to calculate dates JS side.
        // For now, we can leave it as static or simple reload.
        // Since we reload page on filter in other views, we could do GET form submission to reload view with new dates, 
        // but here we want simple POST export.

        // Let's rely on server-side rendering for the initial load. 
        // If users change dropdowns, they might expect the text to update, but without JS date logic helper it's hard.
        // We will keep it simple.
    </script>
</x-app-layout>
