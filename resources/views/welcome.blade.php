<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBG System - Automatic Nutrition Calculator Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-50 min-h-screen text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="bg-green-500 rounded-xl p-2 shadow-lg shadow-green-200">
                       <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">MBG System</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-green-600 transition-colors">Features</a>
                    <a href="#how-it-works" class="text-sm font-medium text-gray-500 hover:text-green-600 transition-colors">How It Works</a>
                    <a href="#menu-samples" class="text-sm font-medium text-gray-500 hover:text-green-600 transition-colors">Menu Samples</a>
                </div>

                <!-- Login Button -->
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-green-500 text-sm font-semibold rounded-full text-green-600 bg-white hover:bg-green-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm hover:shadow-md">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
        <div class="text-center mb-16 pt-8">
            <div class="inline-block bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 shadow-sm border border-green-200">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    MBG System
                </span>
            </div>
            <h1 class="text-5xl font-bold text-gray-800 mb-4">
                Sistem Perhitungan Gizi <span class="text-green-600">Otomatis</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Demonstrasi sistem penghitungan kandungan gizi yang terintegrasi dengan komposisi menu.
                Setiap perubahan bahan akan otomatis menghitung ulang nilai gizi total.
            </p>
        </div>

        <!-- Demo Info Box -->
        <div id="how-it-works" class="scroll-mt-28 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-3xl p-8 mb-20 shadow-xl overflow-hidden relative">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="flex items-start gap-4">
                <svg class="w-12 h-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h2 class="text-2xl font-bold mb-3">Cara Kerja Sistem</h2>
                    <ol class="space-y-2 text-lg">
                        <li class="flex items-start gap-2">
                            <span class="font-bold">1.</span>
                            <span>Setiap <strong>bahan baku</strong> memiliki data nutrisi per 100 gram (energi, protein, lemak, karbohidrat, serat)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="font-bold">2.</span>
                            <span>Setiap <strong>menu</strong> terdiri dari beberapa bahan dengan jumlah tertentu per porsi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="font-bold">3.</span>
                            <span>Sistem <strong>otomatis menghitung</strong>: <code class="bg-blue-700 px-2 py-1 rounded">(jumlah_per_porsi / 100) × nutrisi_per_100g</code></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="font-bold">4.</span>
                            <span>Hasilnya dijumlahkan untuk semua bahan → <strong>Total Gizi Per Porsi</strong></span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Example Menu Cards -->
        <div id="menu-samples" class="scroll-mt-28">
            <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">Contoh Menu dengan Perhitungan Otomatis</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Menu 1: Ayam Riza -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-green-200">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6">
                    <h3 class="text-2xl font-bold">Menu Ayam Riza</h3>
                    <p class="text-orange-100 mt-1">Menu Basah • Tinggi Protein</p>
                </div>
                
                <div class="p-6">
                    <!-- Ingredients -->
                    <h4 class="font-bold text-gray-700 mb-3">Komposisi:</h4>
                    <ul class="space-y-2 mb-6">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Ayam Goreng</span>
                            <span class="font-semibold text-gray-900">150 gram</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Susu Sapi</span>
                            <span class="font-semibold text-gray-900">200 ml</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Sayur Kol</span>
                            <span class="font-semibold text-gray-900">100 gram</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Nasi Putih</span>
                            <span class="font-semibold text-gray-900">200 gram</span>
                        </li>
                    </ul>

                    <!-- Calculated Nutrition -->
                    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl p-5 border-2 border-green-300">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h5 class="font-bold text-gray-800">Otomatis Terhitung:</h5>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Energi</p>
                                <p class="text-2xl font-bold text-orange-600">701</p>
                                <p class="text-xs text-gray-500">kkal</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Protein</p>
                                <p class="text-2xl font-bold text-red-600">53.5</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Lemak</p>
                                <p class="text-2xl font-bold text-yellow-600">27.5</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Karbohidrat</p>
                                <p class="text-2xl font-bold text-blue-600">71.8</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu 2: Telur Sehat -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-yellow-200">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white p-6">
                    <h3 class="text-2xl font-bold">Menu Telur Sehat</h3>
                    <p class="text-yellow-100 mt-1">Menu Basah • Protein Hewani</p>
                </div>
                
                <div class="p-6">
                    <!-- Ingredients -->
                    <h4 class="font-bold text-gray-700 mb-3">Komposisi:</h4>
                    <ul class="space-y-2 mb-6">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Telur Ayam</span>
                            <span class="font-semibold text-gray-900">100 gram (2 butir)</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Wortel</span>
                            <span class="font-semibold text-gray-900">80 gram</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Nasi Putih</span>
                            <span class="font-semibold text-gray-900">200 gram</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700">Susu Sapi</span>
                            <span class="font-semibold text-gray-900">150 ml</span>
                        </li>
                    </ul>

                    <!-- Calculated Nutrition -->
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-5 border-2 border-yellow-300">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h5 class="font-bold text-gray-800">Otomatis Terhitung:</h5>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Energi</p>
                                <p class="text-2xl font-bold text-orange-600">508</p>
                                <p class="text-xs text-gray-500">kkal</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Protein</p>
                                <p class="text-2xl font-bold text-red-600">23.2</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Lemak</p>
                                <p class="text-2xl font-bold text-yellow-600">17.6</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-600 mb-1">Karbohidrat</p>
                                <p class="text-2xl font-bold text-blue-600">71.6</p>
                                <p class="text-xs text-gray-500">g</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Features -->
        <div id="features" class="scroll-mt-28 bg-white rounded-3xl shadow-xl p-10 mb-20 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Fitur Sistem MBG</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Perhitungan Otomatis</h3>
                    <p class="text-gray-600">Sistem menghitung gizi secara otomatis berdasarkan komposisi menu</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Real-time Update</h3>
                    <p class="text-gray-600">Perubahan bahan langsung update nilai gizi total</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Laporan Lengkap</h3>
                    <p class="text-gray-600">Per menu, per sekolah, hingga total mingguan</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-2xl p-12 shadow-2xl">
            <h2 class="text-4xl font-bold mb-4">Siap Digunakan!</h2>
            <p class="text-xl mb-8 text-green-50">
                Sistem MBG dengan perhitungan gizi otomatis sudah siap untuk dikembangkan lebih lanjut
            </p>
            <div class="flex gap-4 justify-center">
                <a href="/menus" class="bg-white text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-green-50 transition-colors shadow-lg">
                    Lihat Semua Menu →
                </a>
            </div>
        </div>
    </div>
</body>
</html>
