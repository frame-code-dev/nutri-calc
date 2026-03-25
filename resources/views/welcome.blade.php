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
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#how-it-works"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group">
                        How It Works
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#menu-samples"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group">
                        Menu Samples
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ asset('manual_book.html') }}" target="_blank"
                        class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors relative group flex items-center gap-1">
                        📖 Panduan Manual
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
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

    {{-- ===== PANDUAN MENU SECTION ===== --}}
    <section id="panduan-menu" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-full text-emerald-700 text-sm font-bold mb-4">
                    📖 Panduan Lengkap Penggunaan
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Panduan Setiap Menu Aplikasi</h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto">Penjelasan detail dan informatif untuk setiap fitur yang tersedia di dalam sistem Management Gizi.</p>
            </div>

            {{-- Quick Nav --}}
            <div class="flex flex-wrap gap-2 justify-center mb-12">
                @foreach([['#pm-operasional','🍽️ Operasional'],['#pm-logistik','📦 Logistik'],['#pm-distribusi','🚚 Distribusi'],['#pm-laporan','📊 Laporan'],['#pm-sdm','👷 SDM'],['#pm-admin','🔐 Administrator']] as [$href,$label])
                <a href="{{ $href }}" class="px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-semibold text-slate-600 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">{{ $label }}</a>
                @endforeach
            </div>

            {{-- GROUP: OPERASIONAL --}}
            <div id="pm-operasional" class="mb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-lg">🍽️</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Operasional</h3>
                        <p class="text-slate-500 text-sm">Pengelolaan menu, jadwal, kalender sekolah, dan monitoring mingguan</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">

                    {{-- Menu Makan --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-emerald-100 transition-colors">🍽️</div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Menu Makan</h4>
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">OPERASIONAL</span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Modul inti sistem — tempat membuat dan mengelola seluruh menu makanan dengan <strong>kalkulasi nilai gizi otomatis</strong>. Setiap bahan yang ditambahkan akan langsung dihitung kontribusi Energi, Protein, Lemak, Karbohidrat, dan Seratnya secara real-time.</p>
                        <div class="space-y-2">
                            @foreach(['Tambah menu baru dengan nama dan jenis (Basah/Kering)','Pilih bahan baku dan masukkan takaran per porsi (gram)','Sistem hitung otomatis: (gramasi ÷ 100) × gizi/100g','Download material list ke Word (.docx) satu klik','Versioning otomatis jika menu sudah terjadwal'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-emerald-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                        <div class="mt-5 p-4 bg-emerald-50 rounded-2xl">
                            <p class="text-xs font-bold text-emerald-700 mb-1">⭐ RUMUS GIZI OTOMATIS</p>
                            <code class="text-sm font-mono text-emerald-800 font-bold">Total = Σ (gram ÷ 100) × gizi_per_100g</code>
                        </div>
                    </div>

                    {{-- Siklus Menu --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-blue-100 transition-colors">🗓️</div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Siklus Menu</h4>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">OPERASIONAL</span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Tetapkan menu apa yang akan dikirim ke setiap sekolah untuk setiap hari dalam satu minggu (Senin–Sabtu). Tersedia fitur <strong>Terapkan ke Semua Sekolah</strong> serentak dan pilihan menu <strong>Random otomatis</strong>.</p>
                        <div class="space-y-2">
                            @foreach(['Pilih nomor minggu & tahun target','Pilih sekolah lalu tetapkan menu per hari','Hari aktif → menu Basah | Hari libur → menu Kering','Terapkan global ke semua sekolah sekaligus','Estimasi biaya bahan vs RAB tampil otomatis','Share jadwal ke koordinator dapur via WhatsApp'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-blue-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kalender Sekolah --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:shadow-teal-50 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-teal-100 transition-colors">📅</div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Kalender Sekolah</h4>
                                <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-full">OPERASIONAL</span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Tentukan status setiap hari untuk setiap sekolah: <strong>Receive</strong> (kirim makan), <strong>Holiday</strong> (libur), atau <strong>Pending</strong>. Juga mencatat jumlah porsi kecil (PK), porsi besar (PB), dan jumlah guru per hari.</p>
                        <div class="grid grid-cols-3 gap-3 mt-4">
                            <div class="text-center p-3 bg-emerald-50 rounded-2xl"><div class="text-lg mb-1">✅</div><div class="text-xs font-bold text-emerald-700">Receive</div><div class="text-[11px] text-slate-500">Makan dikirim</div></div>
                            <div class="text-center p-3 bg-orange-50 rounded-2xl"><div class="text-lg mb-1">🏖️</div><div class="text-xs font-bold text-orange-700">Holiday</div><div class="text-[11px] text-slate-500">Menu kering</div></div>
                            <div class="text-center p-3 bg-slate-50 rounded-2xl"><div class="text-lg mb-1">⏳</div><div class="text-xs font-bold text-slate-600">Pending</div><div class="text-[11px] text-slate-500">Belum diisi</div></div>
                        </div>
                        <div class="mt-4 space-y-2">
                            @foreach(['Bulk update status semua hari sekaligus','Kirim notifikasi jadwal ke koordinator sekolah via WA','Isi jumlah porsi PK + PB + guru per hari'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-teal-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Monitoring & Kunci --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-orange-100 transition-colors">📈</div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Monitoring & Kunci</h4>
                                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">OPERASIONAL</span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Pantau status penerimaan makanan <strong>semua sekolah</strong> dalam satu tampilan mingguan. Admin dapat <strong>mengunci (lock)</strong> data sekolah setelah periode selesai agar tidak bisa dimodifikasi lagi.</p>
                        <div class="space-y-2">
                            @foreach(['Tabel status semua sekolah: received / holiday / pending','Kunci data sekolah per minggu (lock/unlock)','Hanya Super Admin yang bisa membuka kunci','Kirim reminder WhatsApp ke sekolah yang belum konfirmasi','Riwayat monitoring tersimpan per minggu'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-orange-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- GROUP: LOGISTIK --}}
            <div id="pm-logistik" class="mb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-lg">📦</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Logistik</h3>
                        <p class="text-slate-500 text-sm">Pengelolaan stok gudang, belanja bahan, master bahan baku, supplier, dan kategori</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-6">

                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group col-span-1">
                        <div class="w-11 h-11 bg-amber-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-amber-100 transition-colors">📦</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Stok Gudang</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Catat setiap transaksi bahan baku: <strong>IN</strong> (diterima dari supplier) dan <strong>OUT</strong> (digunakan untuk produksi). Saldo dihitung otomatis real-time.</p>
                        <div class="space-y-1.5">
                            @foreach(['Catat stok masuk (IN) dari supplier','Catat stok keluar (OUT) untuk produksi','Saldo = Σ IN − Σ OUT otomatis','Ringkasan stok semua bahan','Alert stok rendah (< 10kg)'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-amber-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                        <div class="mt-4 p-3 bg-amber-50 rounded-xl"><code class="text-xs font-mono font-bold text-amber-800">Saldo = Σ IN − Σ OUT</code></div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group col-span-1">
                        <div class="w-11 h-11 bg-violet-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-violet-100 transition-colors">🛒</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Belanja Bahan</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Shopping list otomatis berdasarkan kebutuhan seluruh menu terjadwal. Sistem menghitung total kebutuhan dikurangi stok tersedia sehingga admin tahu persis apa yang harus dibeli.</p>
                        <div class="space-y-1.5">
                            @foreach(['Agregasi kebutuhan dari semua menu minggu ini','Dikurangi stok tersedia → hasil = yang harus dibeli','Manage Office Inventory (non-makanan)','Membantu procurement sebelum minggu produksi'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-violet-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group col-span-1">
                        <div class="w-11 h-11 bg-emerald-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-100 transition-colors">🧂</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Bahan Baku</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Master data semua bahan. Bahan berkategori <strong>Food</strong> wajib diisi nilai gizi per 100g (Energi, Protein, Lemak, KH, Serat) sebagai referensi kalkulasi menu otomatis.</p>
                        <div class="space-y-1.5">
                            @foreach(['Nama, kode, satuan, harga/unit','Kategori Food → wajib isi data gizi','Data gizi per 100g (5 nutrisi)','Toggle aktif/nonaktif','Tidak bisa hapus jika sudah dipakai menu'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-emerald-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-sky-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-sky-100 transition-colors">🏪</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Supplier</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Data pemasok bahan baku. Setiap transaksi stok IN dapat dikaitkan ke supplier tertentu untuk audit dan laporan pembelian yang akurat.</p>
                        <div class="space-y-1.5">
                            @foreach(['Nama toko/perusahaan pemasok','Alamat, telepon, email kontak','Kaitkan ke transaksi stok IN','Toggle aktif/nonaktif'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-sky-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-rose-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-rose-100 transition-colors">🏷️</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Kategori</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Pengelompokan bahan baku. Kategori <strong>Food</strong> secara otomatis mengaktifkan form isian nilai gizi saat tambah/edit bahan baku.</p>
                        <div class="space-y-1.5">
                            @foreach(['Kategori Food → aktifkan form gizi','Kategori lain: Bumbu, Kemasan, Alat, dll','Digunakan sebagai filter di daftar bahan baku','Bisa tambah kategori sesuai kebutuhan'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-rose-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- GROUP: DISTRIBUSI --}}
            <div id="pm-distribusi" class="mb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-lg">🚚</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Distribusi</h3>
                        <p class="text-slate-500 text-sm">Pengiriman makanan harian ke sekolah dan pengaturan kloter/batch</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-red-100 transition-colors">🚚</div>
                            <div><h4 class="text-lg font-bold text-slate-900">Pengiriman</h4><span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">DISTRIBUSI</span></div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Rekap pengiriman makanan harian dari dapur ke seluruh sekolah. Pantau status setiap sekolah, konfirmasi penerimaan, dan export surat jalan ke Word.</p>
                        <div class="space-y-2">
                            @foreach(['Lihat semua pengiriman hari ini per sekolah','Pantau status: dalam perjalanan / diterima','Koordinator sekolah konfirmasi penerimaan','Export Surat Jalan ke Word (.docx)','Rekap total paket yang dikirim per kloter'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-red-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-slate-200 transition-colors">⚙️</div>
                            <div><h4 class="text-lg font-bold text-slate-900">Setting Kloter</h4><span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">DISTRIBUSI</span></div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Atur pembagian sekolah ke dalam kloter (gelombang pengiriman). Misal Kloter 1 untuk zona utara, Kloter 2 zona selatan — memudahkan koordinasi sopir dan kurir.</p>
                        <div class="space-y-2">
                            @foreach(['Buat kloter pengiriman baru','Tambahkan sekolah ke kloter tertentu','Atur urutan pengiriman per kloter','Export PDF daftar pengiriman per kloter','Panduan sopir: nama sekolah & jumlah paket'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-slate-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- GROUP: LAPORAN --}}
            <div id="pm-laporan" class="mb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-lg">📊</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Laporan</h3>
                        <p class="text-slate-500 text-sm">Analisis gizi dan export laporan mingguan bahan baku</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-purple-100 transition-colors">🧪</div>
                            <div><h4 class="text-lg font-bold text-slate-900">Laporan Gizi</h4><span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">LAPORAN</span></div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Analisis mendalam kandungan gizi menu dan program. Tersedia 4 jenis laporan: detail per menu, rekap mingguan per sekolah, manfaat mingguan total, dan perbandingan antar menu.</p>
                        <div class="space-y-3">
                            @foreach([['🍽️','Laporan Per Menu','Breakdown gizi tiap bahan dalam satu menu'],['🏫','Laporan Mingguan Sekolah','Akumulasi gizi yang diterima per sekolah'],['📊','Manfaat Mingguan','Total nutrisi seluruh program semua sekolah'],['⚖️','Perbandingan Menu','Bandingkan nilai gizi 2+ menu berdampingan']] as [$icon,$title,$desc])
                            <div class="flex gap-3 p-3 bg-purple-50 rounded-xl">
                                <span class="text-lg">{{ $icon }}</span>
                                <div><div class="text-sm font-bold text-slate-800">{{ $title }}</div><div class="text-xs text-slate-500">{{ $desc }}</div></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 group-hover:bg-green-100 transition-colors">📋</div>
                            <div><h4 class="text-lg font-bold text-slate-900">Laporan Menu</h4><span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">LAPORAN</span></div>
                        </div>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">Export laporan bahan baku mingguan ke <strong>Excel (.xlsx)</strong>. Satu kolom per hari (Senin–Sabtu), berisi daftar seluruh bahan yang digunakan dari semua menu sekolah berstatus Receive.</p>
                        <div class="space-y-2 mb-5">
                            @foreach(['Pilih minggu & tahun lalu klik Export Excel','6 kolom otomatis (Senin–Sabtu)','Header hijau, auto-size kolom, siap cetak','Export Word: satu menu atau semua master menu','Bisa jadi referensi belanja & produksi mingguan'] as $item)
                            <div class="flex items-start gap-2 text-sm text-slate-600"><span class="text-green-500 mt-0.5 flex-shrink-0">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">📗 Export .xlsx</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">📘 Export .docx</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GROUP: SDM --}}
            <div id="pm-sdm" class="mb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center text-lg">👷</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">SDM — Sumber Daya Manusia</h3>
                        <p class="text-slate-500 text-sm">Data relawan dapur, penggajian bulanan, dan pengaturan tarif upah per jabatan</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-teal-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-teal-100 transition-colors">👷</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Data Relawan</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Master data semua relawan yang bertugas di dapur produksi MBG. Berisi data identitas dan rekening untuk keperluan penggajian.</p>
                        <div class="space-y-1.5">
                            @foreach(['Nama lengkap & NIK/KTP','Jabatan (Koordinator, Juru Masak, Helper, dll)','Nomor telepon WhatsApp','Nomor rekening bank','Status aktif/nonaktif'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-teal-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-yellow-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-yellow-100 transition-colors">💰</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Gaji Relawan</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Kelola penggajian bulanan: buat periode, isi absensi, tambah komponen bonus/potongan, cetak slip gaji PDF (4 slip/A4) dan rekap penggajian.</p>
                        <div class="space-y-1.5">
                            @foreach(['Buat periode gaji baru (misal: Maret 2026)','Input hari hadir setiap relawan','Hitung otomatis: Hadir × Upah Harian','Tambah komponen bonus/potongan fleksibel','Cetak 4 slip per halaman A4','Export rekap seluruh relawan PDF'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-yellow-600">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                        <div class="mt-3 p-3 bg-yellow-50 rounded-xl"><code class="text-xs font-mono font-bold text-yellow-800">Gaji = (Hadir × Upah) + Bonus − Potongan</code></div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-orange-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-orange-100 transition-colors">🔧</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Setting Upah</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Tetapkan besaran upah harian per jabatan. Nilai ini digunakan otomatis saat menghitung total gaji dalam periode penggajian.</p>
                        <div class="space-y-1.5">
                            @foreach(['Tambah jabatan & tarif harian (Rp)','Edit tarif kapan saja','Berlaku untuk periode gaji berikutnya','Contoh: Koordinator Rp 150rb, Helper Rp 80rb'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-orange-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- GROUP: ADMINISTRATOR --}}
            <div id="pm-admin" class="mb-4">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg">🔐</div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Administrator</h3>
                        <p class="text-slate-500 text-sm">Manajemen user & role, Master SPPG, dan data sekolah penerima program</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-blue-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-100 transition-colors">👤</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Manajemen User</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Kelola seluruh akun pengguna sistem beserta role dan hak aksesnya. Setiap role mendapat tampilan dashboard dan menu sidebar yang berbeda.</p>
                        <div class="space-y-1.5">
                            @foreach(['Tambah/edit/hapus akun user','Assign role: Super Admin, Admin MBG, Ahli Gizi, Koord. Sekolah, Koord. Dapur, Supplier','Assign ke SPPG/MBG tertentu','Export daftar user ke Excel','Reset password user'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-blue-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-indigo-100 transition-colors">🏛️</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Master SPPG</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">SPPG (Satuan Pelaksana Program Gizi) adalah unit MBG. Sistem multi-tenant: setiap Admin MBG hanya bisa mengakses data SPPG-nya sendiri. Super Admin melihat semua.</p>
                        <div class="space-y-1.5">
                            @foreach(['Kelola unit SPPG/MBG (Super Admin only)','Isolasi data antar SPPG otomatis','Tambah SPPG baru untuk ekspansi program','Toggle status aktif/nonaktif'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-indigo-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-11 h-11 bg-emerald-50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-100 transition-colors">🏫</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Data Sekolah</h4>
                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">Master data sekolah penerima program MBG. Menyimpan jumlah porsi kecil (PK), porsi besar (PB), dan jumlah guru yang digunakan sebagai dasar perhitungan total porsi harian.</p>
                        <div class="space-y-1.5">
                            @foreach(['Nama & alamat sekolah','Jumlah PK (porsi kecil) + PB (porsi besar)','Jumlah guru penerima','Assign koordinator sekolah','Notifikasi WA otomatis ke koordinator','Toggle aktif/nonaktif sekolah'] as $f)
                            <div class="flex gap-2 text-xs text-slate-600"><span class="text-emerald-500">•</span>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA dalam panduan --}}
            <div class="text-center mt-12 p-10 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl text-white">
                <h3 class="text-2xl font-extrabold mb-3">Siap Menggunakan Sistem?</h3>
                <p class="text-emerald-100 mb-6">Login dan mulai kelola distribusi makan bergizi untuk generasi emas Indonesia.</p>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-emerald-700 font-bold rounded-2xl hover:bg-emerald-50 transition-all">
                    Login ke Dashboard →
                </a>
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
