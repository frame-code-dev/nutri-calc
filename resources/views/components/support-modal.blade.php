@props(['bankDetails'])

<!-- Floating Button -->
<button onclick="openSupportModal()"
    class="inline-flex items-center justify-center px-8 py-3 bg-white border border-gray-900 text-gray-900 text-sm font-bold rounded-2xl hover:bg-gray-100 hover:shadow-xl hover:shadow-gray-200 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95"
    title="Support System">
    Support Me
</button>

<!-- Modal -->
<div id="supportModal" class="h-screen fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-xl max-h-[80vh] overflow-y-auto rounded-[32px] p-8 relative">
        <button onclick="closeSupportModal()"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">&times;</button>
        <h2 class="text-2xl font-bold mb-6">Support System</h2>

        <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2">
            @foreach ($bankDetails as $detail)
                <div
                    class="bg-gray-50 rounded-[28px] p-6 border border-gray-100 relative overflow-hidden group hover:border-emerald-300 transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.03] group-hover:opacity-10 transition-opacity">
                        <img src="{{ $detail['logo'] }}" alt="{{ $detail['bank'] }}" class="h-10 grayscale" />
                    </div>

                    <div class="relative z-10 text-left">
                        <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-[0.2em] mb-4">Transfer
                            {{ $detail['bank'] }}</p>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Nomor Rekening</p>
                                <div
                                    class="flex items-center justify-between bg-white px-4 py-3 rounded-2xl border border-gray-100 group-hover:border-emerald-200 transition-all">
                                    <p class="text-lg font-mono font-bold text-gray-900 tracking-wider">
                                        {{ $detail['number'] }}</p>
                                    <button onclick="copyToClipboard('{{ $detail['number'] }}')"
                                        class="text-emerald-600 hover:text-emerald-700 p-2 hover:bg-emerald-100 rounded-xl transition-all active:scale-90"
                                        title="Salin Nomor Rekening">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Nama Pemilik</p>
                                <p class="text-base font-bold text-gray-900 pl-1">{{ $detail['name'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
    function openSupportModal() {
        document.getElementById('supportModal').classList.remove('hidden');
    }

    function closeSupportModal() {
        document.getElementById('supportModal').classList.add('hidden');
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin: ' + text);
        }).catch(err => {
            alert('Gagal menyalin nomor rekening');
            console.error(err);
        });
    }
</script>

<style>
    /* Optional: custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #10b981;
        /* emerald-500 */
        border-radius: 10px;
    }
</style>
