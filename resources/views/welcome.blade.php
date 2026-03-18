@php
    $bankDetails = [
        [
            'name' => 'Rifjan Jundila',
            'bank' => 'Mandiri',
            'number' => '1430032353797',
            'logo' =>
                'https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1200px-Bank_Mandiri_logo.svg.png',
        ],
        [
            'name' => 'Rifjan Jundila',
            'bank' => 'BRI',
            'number' => '619401026990533',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_Logo.svg',
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutric Calc System - Monitoring Gizi Otomatis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-900 antialiased overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div
                        class="bg-emerald-600 rounded-2xl p-2.5 shadow-lg shadow-emerald-200 transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="font-extrabold text-2xl tracking-tight bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">MBG
                        System</span>
                </div>

                <div class="hidden md:flex items-center space-x-10">
                    <a href="#features"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group">
                        Features
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#how-it-works"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group">
                        How It Works
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#menu-samples"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group">
                        Menu Samples
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <div class="flex items-center gap-2 md:gap-4">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-8 py-3 bg-emerald-600 text-white text-sm font-bold rounded-2xl hover:bg-emerald-700 hover:shadow-xl hover:shadow-emerald-200 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                        Log In
                    </a>
                    <x-support-modal :bankDetails="$bankDetails" />
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="pt-32 pb-20 overflow-hidden relative">
        <!-- Background Elements -->
        <div
            class="absolute top-0 right-0 -z-10 w-1/3 h-[800px] bg-gradient-to-l from-emerald-50/50 to-transparent blur-3xl">
        </div>
        <div
            class="absolute bottom-0 left-0 -z-10 w-1/4 h-[600px] bg-gradient-to-r from-blue-50/50 to-transparent blur-3xl">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-8">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-full text-emerald-700 text-sm font-bold animate-fade-in">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Monitoring Nutrisi #1
                </div>

                <h1
                    class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] animate-fade-up delay-1">
                    Cerdas Memantau <br>
                    <span class="text-emerald-600">Gizi Generasi Emas</span>
                </h1>

                <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-600 leading-relaxed animate-fade-up delay-2">
                    Platform otomatis terintegrasi untuk menghitung, memantau, dan melaporkan
                    asupan nutrisi pada program Makan Bergizi Gratis.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8 animate-fade-up delay-3">
                    <a href="#how-it-works"
                        class="px-10 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 hover:shadow-2xl hover:shadow-emerald-200 transition-all duration-300">
                        Coba Demo Sekarang
                    </a>
                    <a href="#features"
                        class="px-10 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all duration-300">
                        Pelajari Fitur
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview / Illustration -->
            <div class="mt-20 relative animate-fade-up" style="animation-delay: 0.8s">
                <div class="relative mx-auto max-w-5xl">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-100 rounded-full blur-3xl opacity-50">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-100 rounded-full blur-3xl opacity-50">
                    </div>
                    <div
                        class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 p-4 relative overflow-hidden group">
                        <div
                            class="bg-slate-50 rounded-[2rem] h-[400px] flex items-center justify-center border-2 border-dashed border-slate-200">
                            <!-- Simple Mockup UI -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-8 w-full">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 group-hover:scale-105 transition-transform duration-500"
                                        style="transition-delay: {{ $i * 100 }}ms">
                                        <div class="w-10 h-10 bg-emerald-50 rounded-xl mb-4"></div>
                                        <div class="h-4 bg-slate-100 rounded-full w-2/3 mb-2"></div>
                                        <div class="h-4 bg-slate-50 rounded-full w-1/2"></div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <!-- Floating Badges -->
                        <div
                            class="absolute top-20 -left-2 sm:left-10 bg-white p-4 rounded-2xl shadow-xl border border-emerald-50 animate-float">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400">STATUS</p>
                                    <p class="text-sm font-extrabold text-slate-800">Nutrisi Terpenuhi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- How It Works -->
    <section id="how-it-works" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg width="100%" height="100%">
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5" />
                </pattern>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-8 leading-tight">
                        Alur Kerja <br> <span class="text-emerald-400">Cerdas & Otomatis</span>
                    </h2>
                    <div class="space-y-10">
                        <div class="flex gap-6 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 font-extrabold text-xl border border-emerald-500/30 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                1</div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Master Data Bahan</h3>
                                <p class="text-slate-400">Informasi nutrisi per 100g disimpan secara mendalam untuk
                                    setiap bahan baku.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 font-extrabold text-xl border border-emerald-500/30 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                2</div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Komposisi Menu</h3>
                                <p class="text-slate-400">Racik menu dengan takaran porsi yang presisi sesuai standar
                                    operasional.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 font-extrabold text-xl border border-emerald-500/30 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                3</div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Auto-Calculation</h3>
                                <p class="text-slate-400">Sistem mengalkulasi total kalori, protein, lemak, dan
                                    karbohidrat secara instan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Interactive Formula Card -->
                <div class="bg-slate-800 rounded-[2.5rem] p-10 border border-slate-700 shadow-2xl relative">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl"></div>
                    <code class="text-emerald-400 text-lg block mb-6 font-mono">
                        TotalNutrisi = ∑ (Porsi / 100 * NutrisiBahan)
                    </code>
                    <div class="space-y-4">
                        <div class="h-2 bg-slate-700 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-700 rounded-full w-4/5"></div>
                        <div class="h-2 bg-slate-700 rounded-full w-3/4"></div>
                        <div class="pt-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-900/50 p-4 rounded-2xl border border-slate-700">
                                    <p class="text-2xl font-black text-emerald-400">100%</p>
                                    <p class="text-xs text-slate-500 font-bold uppercase">Akurasi Data</p>
                                </div>
                                <div class="bg-slate-900/50 p-4 rounded-2xl border border-slate-700">
                                    <p class="text-2xl font-black text-blue-400">&lt;1s</p>
                                    <p class="text-xs text-slate-500 font-bold uppercase">Waktu Hitung</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Samples -->
    <section id="menu-samples" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <h2 class="text-4xl font-extrabold tracking-tight mb-4">Sample Menu Pintar</h2>
                    <p class="text-slate-500 max-w-xl text-lg">Visualisasi bagaimana setiap komponen bahan
                        bertransformasi menjadi nilai nutrisi yang terukur.</p>
                </div>
                <a href="{{ route('login') }}"
                    class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-4 transition-all group">
                    Lihat Selebihnya di Dashboard
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                <!-- Menu 1 -->
                <div
                    class="group bg-[#F8FAFC] rounded-[2.5rem] p-8 hover:bg-white hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-500 border border-transparent hover:border-emerald-100 overflow-hidden relative">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-700">
                    </div>
                    <div class="relative">
                        <span
                            class="inline-block px-4 py-1.5 bg-orange-100 text-orange-700 rounded-full text-xs font-bold mb-6">TINGGI
                            PROTEIN</span>
                        <h3 class="text-3xl font-extrabold mb-8">Nasi Ayam Bakar Spesial</h3>

                        <div class="space-y-4 mb-10">
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Ayam Bakar</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">150g</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Nasi Putih</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">200g</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Tumis Buncis</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">100g</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-3">
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">ENERGY</p>
                                <p class="text-lg font-black text-emerald-600">645</p>
                                <p class="text-[10px] text-slate-400">kcal</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">PROT</p>
                                <p class="text-lg font-black text-blue-600">42g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">FAT</p>
                                <p class="text-lg font-black text-orange-600">18g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">CARB</p>
                                <p class="text-lg font-black text-teal-600">72g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu 2 -->
                <div
                    class="group bg-[#F8FAFC] rounded-[2.5rem] p-8 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 border border-transparent hover:border-blue-100 overflow-hidden relative">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-700">
                    </div>
                    <div class="relative">
                        <span
                            class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold mb-6">BALANCED
                            DIET</span>
                        <h3 class="text-3xl font-extrabold mb-8">Daging Teriyaki Sehat</h3>

                        <div class="space-y-4 mb-10">
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Daging Sapi</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">100g</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Salad Sayur</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">150g</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-slate-400">Kentang Rebus</span>
                                <span class="px-3 py-1 bg-white rounded-lg text-slate-700">200g</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-3">
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">ENERGY</p>
                                <p class="text-lg font-black text-emerald-600">512</p>
                                <p class="text-[10px] text-slate-400">kcal</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">PROT</p>
                                <p class="text-lg font-black text-blue-600">35g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">FAT</p>
                                <p class="text-lg font-black text-orange-600">12g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl text-center group-hover:shadow-md transition-shadow">
                                <p class="text-xs font-bold text-slate-400 mb-1">CARB</p>
                                <p class="text-lg font-black text-teal-600">58g</p>
                                <p class="text-[10px] text-slate-400">gram</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-600 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 rounded-full blur-[100px] -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-700 rounded-full blur-[100px] -ml-32 -mb-32">
            </div>

            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">Siap Optimalkan <br> Program
                    Anda?</h2>
                <p class="text-emerald-100 text-lg md:text-xl max-w-2xl mx-auto">
                    Bergabunglah bersama Management Gizi untuk manajemen gizi yang lebih presisi, efisien, dan berdampak
                    nyata bagi generasi mendatang.
                </p>
                <div class="flex justify-center pt-8">
                    <a href="{{ route('login') }}"
                        class="px-12 py-5 bg-white text-emerald-600 font-extrabold rounded-2xl hover:bg-emerald-50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-200">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6 text-slate-500 text-sm font-medium">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                </div>
                <span>© 2024 Management Gizi. All rights reserved.</span>
            </div>
            <div class="flex gap-8">
                <a href="#" class="hover:text-emerald-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-emerald-600 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-emerald-600 transition-colors">Support</a>
            </div>
        </div>
    </footer>

    <script>
        // Simple Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-xl', 'bg-white/90');
                nav.classList.remove('bg-white/70');
            } else {
                nav.classList.remove('shadow-xl', 'bg-white/90');
                nav.classList.add('bg-white/70');
            }
        });
    </script>
</body>

</html>
