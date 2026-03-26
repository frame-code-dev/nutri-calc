<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Header section -->
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Tambah Dokumen Baru</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Upload gambar, PDF, Excel, Word, dll.</p>
                </div>
                <a href="{{ route('document-attachments.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl transition-all shadow-sm">
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('document-attachments.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" placeholder="Contoh: Laporan Kegiatan Maret 2026">
                        @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan</label>
                        <textarea name="description" rows="3" class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" placeholder="Opsional: tambahkan keterangan lengkap mengenai lampiran ini">{{ old('description') }}</textarea>
                        @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload File</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl overflow-hidden hover:bg-gray-50 transition-colors focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex items-center justify-center text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                        <span>Pilih file untuk diupload</span>
                                        <input type="file" name="files[]" multiple class="sr-only" onchange="document.getElementById('fileList').textContent = this.files.length + ' file(s) selected'">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Bisa upload lebih dari satu. Max 10MB per file.</p>
                                <p id="fileList" class="text-xs font-bold text-indigo-600 mt-2"></p>
                            </div>
                        </div>
                        @error('files') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @error('files.*') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                            Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
