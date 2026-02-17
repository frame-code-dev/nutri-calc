<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-6">Edit Master SPPG</h2>

            <form action="{{ route('master-sppg.update', $masterSppg->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $masterSppg->name) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Instagram --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $masterSppg->instagram) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- TikTok --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">TikTok</label>
                    <input type="text" name="tiktok" value="{{ old('tiktok', $masterSppg->tiktok) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Assign Users --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Assign Users
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto border rounded p-3">
                        @foreach ($users as $user)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                    class="rounded text-blue-600"
                                    {{ in_array($user->id, $assignedUsers) ? 'checked' : '' }}>
                                <span>
                                    {{ $user->name }} ({{ $user->email }})
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
