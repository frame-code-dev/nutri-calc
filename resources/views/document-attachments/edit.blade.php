<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Header section -->
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Detail & Edit Dokumen</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Kelola lampiran untuk dokumen ini</p>
                </div>
                <a href="{{ route('document-attachments.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl transition-all shadow-sm">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Data Dokumen -->
                <div class="md:col-span-1 space-y-6">
                    <form action="{{ route('document-attachments.update', $documentAttachment) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-4">
                        @csrf @method('PUT')
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $documentAttachment->title) }}" required class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl">
                            @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan</label>
                            <textarea name="description" rows="4" class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl">{{ old('description', $documentAttachment->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tambah File Baru</label>
                            <input type="file" name="new_files[]" multiple class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-gray-200 rounded-xl p-1">
                            <p class="text-[10px] text-gray-400 mt-1">Biarkan kosong jika tidak ingin menambah file.</p>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- List File Terlampir -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-900">File Terlampir</h3>
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ is_array($documentAttachment->files) ? count($documentAttachment->files) : 0 }} File</span>
                        </div>
                        
                        <div class="p-4 space-y-3">
                            @if(is_array($documentAttachment->files) && count($documentAttachment->files) > 0)
                                @foreach($documentAttachment->files as $index => $file)
                                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center space-x-4 overflow-hidden">
                                            <div class="w-10 h-10 rounded-lg {{ in_array($file['type'] ?? '', ['png','jpg','jpeg']) ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if(in_array($file['type'] ?? '', ['png','jpg','jpeg']))
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-gray-900 truncate" title="{{ $file['name'] ?? '' }}">{{ $file['name'] ?? 'File terlampir' }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium uppercase">{{ number_format(($file['size'] ?? 0) / 1024, 0) }} KB &bull; {{ $file['type'] ?? 'DOC' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2 flex-shrink-0">
                                            <a href="{{ route('document-attachments.download', [$documentAttachment, $index]) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Download">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                            <form action="{{ route('document-attachments.update', $documentAttachment) }}" method="POST" class="inline" onsubmit="return confirm('Hapus file ini?');">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="title" value="{{ $documentAttachment->title }}">
                                                <input type="hidden" name="files_to_remove[]" value="{{ $index }}">
                                                <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus File">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-sm font-medium text-gray-500">Belum ada file terlampir.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
