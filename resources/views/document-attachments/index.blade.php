<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Dokumentasi Lampiran</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Kelola arsip dokumen dan lampiran project</p>
                </div>
                <a href="{{ route('document-attachments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Dokumen
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-widest">
                                <th class="px-6 py-4">Judul Dokumen</th>
                                <th class="px-6 py-4">File Terlampir</th>
                                <th class="px-6 py-4">Dibuat Oleh</th>
                                <th class="px-6 py-4">Waktu Upload</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($documents as $doc)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ $doc->title }}</p>
                                        <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $doc->description ?: '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $filesCount = is_array($doc->files) ? count($doc->files) : 0; @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $filesCount > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $filesCount }} File
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                                        {{ $doc->creator->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap text-xs">
                                        {{ $doc->created_at->isoFormat('D MMM Y HH:mm') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('document-attachments.edit', $doc) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-bold transition-colors">
                                                Detail / Edit
                                            </a>
                                            <form action="{{ route('document-attachments.destroy', $doc) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus seluruh dokumentasi ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-xs font-bold transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">Belum ada dokumentasi lampiran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($documents->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $documents->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
