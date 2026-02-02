<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('users.index') }}" class="hover:text-blue-600 transition-colors">Users</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>Edit</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Edit User</h2>
            </div>

            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">

                    <!-- Basic Info Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span
                                class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">01</span>
                            Account Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="col-span-1">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full
                                    Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" required autofocus
                                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                        placeholder="e.g. John Doe">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="col-span-1">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email
                                    Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" required
                                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                        placeholder="e.g. john@example.com">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone
                                    Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                        placeholder="e.g. 628123456789">
                                </div>
                                <p class="mt-2 text-xs text-gray-500 italic">Gunakan format internasional (cth:
                                    62812...) untuk WhatsApp.</p>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Role -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">User
                                    Role</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    @role('Super Admin')
                                        <select id="role" name="role" required
                                            class="block w-full pl-10 pr-10 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow appearance-none">
                                            <option value="">Select a role for this user...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ (old('role') ?? $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endrole
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Security Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span
                                class="bg-amber-100 text-amber-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">02</span>
                            Change Password
                        </h3>

                        <div class="bg-amber-50/50 p-6 rounded-2xl border border-amber-100">
                            <div class="flex items-start mb-4">
                                <svg class="h-5 w-5 text-amber-400 mt-0.5 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-amber-700">Leave the password fields blank if you do not want to
                                    change the user's password.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password -->
                                <div class="col-span-1">
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New
                                        Password</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            autocomplete="new-password"
                                            class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow"
                                            placeholder="••••••••">
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-span-1">
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Confirm New
                                        Password</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="password" name="password_confirmation"
                                            id="password_confirmation"
                                            class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow"
                                            placeholder="••••••••">
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('users.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-white hover:border-gray-300 transition-all shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-500/30">
                        Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
