<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Perbandingan Menu</h2>
                <p class="mt-1 text-sm text-gray-600">Membandingkan {{ count($nutritionComparison) }} menu</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('nutrition-reports.compare-menus', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('nutrition-reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Nutrition Comparison Chart -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Perbandingan Kandungan Gizi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50">
                                Nutrisi
                            </th>
                            @foreach($nutritionComparison as $comparison)
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="font-semibold text-gray-900">{{ $comparison['menu']->name }}</div>
                                    <div class="mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $comparison['menu']->type === 'wet' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $comparison['menu']->type === 'wet' ? 'Basah' : 'Kering' }}
                                        </span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Energy Row -->
                        <tr class="hover:bg-yellow-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                    Energi (kcal)
                                </div>
                            </td>
                            @php
                                $energyValues = array_column(array_column($nutritionComparison, 'nutrition'), 'energy');
                                $maxEnergy = max($energyValues);
                                $minEnergy = min($energyValues);
                            @endphp
                            @foreach($nutritionComparison as $comparison)
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $isMax = $comparison['nutrition']['energy'] == $maxEnergy && count($nutritionComparison) > 1;
                                        $isMin = $comparison['nutrition']['energy'] == $minEnergy && count($nutritionComparison) > 1;
                                    @endphp
                                    <div class="text-2xl font-bold {{ $isMax ? 'text-yellow-700' : 'text-gray-900' }}">
                                        {{ number_format($comparison['nutrition']['energy'], 0) }}
                                        @if($isMax)
                                            <svg class="w-5 h-5 inline text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Protein Row -->
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    Protein (g)
                                </div>
                            </td>
                            @php
                                $proteinValues = array_column(array_column($nutritionComparison, 'nutrition'), 'protein');
                                $maxProtein = max($proteinValues);
                            @endphp
                            @foreach($nutritionComparison as $comparison)
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold {{ $comparison['nutrition']['protein'] == $maxProtein && count($nutritionComparison) > 1 ? 'text-red-700' : 'text-gray-900' }}">
                                        {{ number_format($comparison['nutrition']['protein'], 1) }}
                                        @if($comparison['nutrition']['protein'] == $maxProtein && count($nutritionComparison) > 1)
                                            <svg class="w-5 h-5 inline text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Fat Row -->
                        <tr class="hover:bg-orange-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-orange-500 mr-2"></div>
                                    Lemak (g)
                                </div>
                            </td>
                            @php
                                $fatValues = array_column(array_column($nutritionComparison, 'nutrition'), 'fat');
                                $maxFat = max($fatValues);
                            @endphp
                            @foreach($nutritionComparison as $comparison)
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold {{ $comparison['nutrition']['fat'] == $maxFat && count($nutritionComparison) > 1 ? 'text-orange-700' : 'text-gray-900' }}">
                                        {{ number_format($comparison['nutrition']['fat'], 1) }}
                                        @if($comparison['nutrition']['fat'] == $maxFat && count($nutritionComparison) > 1)
                                            <svg class="w-5 h-5 inline text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Carbohydrate Row -->
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                    Karbohidrat (g)
                                </div>
                            </td>
                            @php
                                $carbValues = array_column(array_column($nutritionComparison, 'nutrition'), 'carbohydrate');
                                $maxCarb = max($carbValues);
                            @endphp
                            @foreach($nutritionComparison as $comparison)
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold {{ $comparison['nutrition']['carbohydrate'] == $maxCarb && count($nutritionComparison) > 1 ? 'text-blue-700' : 'text-gray-900' }}">
                                        {{ number_format($comparison['nutrition']['carbohydrate'], 1) }}
                                        @if($comparison['nutrition']['carbohydrate'] == $maxCarb && count($nutritionComparison) > 1)
                                            <svg class="w-5 h-5 inline text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Fiber Row -->
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                    Serat (g)
                                </div>
                            </td>
                            @php
                                $fiberValues = array_column(array_column($nutritionComparison, 'nutrition'), 'fiber');
                                $maxFiber = max($fiberValues);
                            @endphp
                            @foreach($nutritionComparison as $comparison)
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold {{ $comparison['nutrition']['fiber'] == $maxFiber && count($nutritionComparison) > 1 ? 'text-green-700' : 'text-gray-900' }}">
                                        {{ number_format($comparison['nutrition']['fiber'], 1) }}
                                        @if($comparison['nutrition']['fiber'] == $maxFiber && count($nutritionComparison) > 1)
                                            <svg class="w-5 h-5 inline text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-blue-700">
                    <strong>Info:</strong> Nilai tertinggi untuk setiap nutrisi ditandai dengan warna yang lebih gelap dan icon panah.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
