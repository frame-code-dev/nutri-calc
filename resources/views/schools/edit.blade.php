<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                ✏️ Edit Sekolah
            </h2>
            <a href="{{ route('schools.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('schools.update', $school) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- School Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Sekolah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $school->name) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="3" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $school->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Portions & Teacher -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="teacher_count" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Guru <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="teacher_count" id="teacher_count" value="{{ old('teacher_count', $school->teacher_count) }}" min="0" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('teacher_count') border-red-500 @enderror">
                        @error('teacher_count')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="small_portion_count" class="block text-sm font-medium text-gray-700 mb-2">
                            Porsi Kecil <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="small_portion_count" id="small_portion_count" value="{{ old('small_portion_count', $school->small_portion_count) }}" min="0" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('small_portion_count') border-red-500 @enderror">
                        @error('small_portion_count')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="large_portion_count" class="block text-sm font-medium text-gray-700 mb-2">
                            Porsi Besar <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="large_portion_count" id="large_portion_count" value="{{ old('large_portion_count', $school->large_portion_count) }}" min="0" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('large_portion_count') border-red-500 @enderror">
                        @error('large_portion_count')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $school->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan sekolah ini</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('schools.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Sekolah
                    </button>
                </div>
            </form>

            <!-- Delete Form -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-red-600 mb-4">⚠️ Zona Bahaya</h3>
                <p class="text-sm text-gray-600 mb-4">Hapus sekolah ini secara permanen. Tindakan ini tidak dapat dibatalkan!</p>
                <form action="{{ route('schools.destroy', $school) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sekolah ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium">
                        🗑️ Hapus Sekolah
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
