<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-6">Create Master SPPG</h2>

            <form action="{{ route('master-sppg.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                {{-- Instagram --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Instagram</label>
                    <input type="text" name="instagram"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                {{-- TikTok --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">TikTok</label>
                    <input type="text" name="tiktok"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                {{-- Assign Users --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Assign Users
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border rounded p-3">
                        @foreach ($users as $user)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                    class="rounded text-blue-600">
                                <span>{{ $user->name }} ({{ $user->email }})</span>
                            </label>
                        @endforeach
                    </div>


                    <p class="text-sm text-gray-500 mt-1">
                        Hold Ctrl (Windows) / Cmd (Mac) untuk pilih lebih dari satu.
                    </p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
