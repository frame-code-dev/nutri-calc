<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class MasterMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Struktur Menu MBG:
     *
     * MASTER KOMPONEN (category = 'master')
     *   └─ Memiliki MenuItems (komposisi bahan baku + quantity_per_portion)
     *   └─ Nutrisi dihitung otomatis via Menu::calculateNutrition()
     *
     * MENU PAKET (category = 'packet')
     *   └─ Menggabungkan beberapa komponen master
     *   └─ Komponen master dalam paket ditandai dgn parent_id = packet.id
     *
     * Seeder ini membuat:
     *   - 4 Menu Paket contoh lengkap, masing-masing berisi komponen master
     *   - Setiap komponen master memiliki komposisi bahan agar nutrisi tampil di UI
     */
    public function run(): void
    {
        // ── A. Seed semua master komponen sederhana (tanpa bahan, sudah ada) ──
        $simpleMenus = [
            ['name' => 'Nasi Hainan', 'type' => 'dry'],
            ['name' => 'Nasi kebuli', 'type' => 'dry'],
            ['name' => 'Nasi Daun Jeruk', 'type' => 'dry'],
            ['name' => 'Nasi Kuning', 'type' => 'dry'],
            ['name' => 'Nasi Pandan', 'type' => 'dry'],
            ['name' => 'Nasi Goreng', 'type' => 'dry'],
            ['name' => 'Mie Ayam', 'type' => 'dry'],
            ['name' => 'Mie Sweet', 'type' => 'dry'],
            ['name' => 'Macaroni Pasta', 'type' => 'dry'],
            ['name' => 'Bakmie Jawa', 'type' => 'dry'],
            ['name' => 'Burger', 'type' => 'dry'],
            ['name' => 'Kentang Goreng', 'type' => 'dry'],
            ['name' => 'Parsley Potatoes', 'type' => 'dry'],
            ['name' => 'Jasuke', 'type' => 'dry'],
            ['name' => 'Beef Teriyaki', 'type' => 'dry'],
            ['name' => 'Ayam Teriyaki', 'type' => 'dry'],
            ['name' => 'Ayam Koloke', 'type' => 'dry'],
            ['name' => 'Ayam Kecap', 'type' => 'dry'],
            ['name' => 'Ayam Goreng Mentega', 'type' => 'dry'],
            ['name' => 'Ayam Suwir', 'type' => 'dry'],
            ['name' => 'Oseng Bakso', 'type' => 'dry'],
            ['name' => 'Chicken Katsu', 'type' => 'dry'],
            ['name' => 'Ayam Kremes', 'type' => 'dry'],
            ['name' => 'Ayam pop', 'type' => 'dry'],
            ['name' => 'Ayam Crispy', 'type' => 'dry'],
            ['name' => 'Ayam Patty', 'type' => 'dry'],
            ['name' => 'Fire Chicken', 'type' => 'dry'],
            ['name' => 'Sate Ayam', 'type' => 'dry'],
            ['name' => 'Kaki Naga', 'type' => 'dry'],
            ['name' => 'Ayam Rendang', 'type' => 'dry'],
            ['name' => 'Ayam Bolognese', 'type' => 'dry'],
            ['name' => 'Bakso Bolognese', 'type' => 'dry'],
            ['name' => 'Chicken Steak', 'type' => 'dry'],
            ['name' => 'Ayam Geprek', 'type' => 'dry'],
            ['name' => 'Ayam Goreng', 'type' => 'dry'],
            ['name' => 'Dimsum ayam', 'type' => 'dry'],
            ['name' => 'Ayam Bakar', 'type' => 'dry'],
            ['name' => 'Pangsit Ayam', 'type' => 'dry'],
            ['name' => 'Abon Ayam', 'type' => 'dry'],
            ['name' => 'Telur Balado', 'type' => 'dry'],
            ['name' => 'Telur Ceplok', 'type' => 'dry'],
            ['name' => 'Nugget telur', 'type' => 'dry'],
            ['name' => 'Fuyunghai', 'type' => 'dry'],
            ['name' => 'Telur Dabu-dabu', 'type' => 'dry'],
            ['name' => 'Telur Bacem', 'type' => 'dry'],
            ['name' => 'Telur kecap', 'type' => 'dry'],
            ['name' => 'Lele Krispy', 'type' => 'dry'],
            ['name' => 'Tahu Bacem', 'type' => 'dry'],
            ['name' => 'Kubis Tahu', 'type' => 'dry'],
            ['name' => 'Tahu Crispy', 'type' => 'dry'],
            ['name' => 'Tempe Krispy', 'type' => 'dry'],
            ['name' => 'Tahu Goreng', 'type' => 'dry'],
            ['name' => 'Tempe Goreng', 'type' => 'dry'],
            ['name' => 'Kering Tempe', 'type' => 'dry'],
            ['name' => 'Tahu Orek', 'type' => 'dry'],
            ['name' => 'Tempe Orek', 'type' => 'dry'],
            ['name' => 'Stik Tempe', 'type' => 'dry'],
            ['name' => 'Nugget Tahu', 'type' => 'dry'],
            ['name' => 'Kripik Tempe', 'type' => 'dry'],
            ['name' => 'Tahu Bulat', 'type' => 'dry'],
            ['name' => 'Ayam Curry', 'type' => 'wet'],
            ['name' => 'Soto Ayam', 'type' => 'wet'],
            ['name' => 'Saus BBQ', 'type' => 'wet'],
            ['name' => 'Sapo tahu', 'type' => 'wet'],
            ['name' => 'Capjay', 'type' => 'wet'],
            ['name' => 'Mix vegetable', 'type' => 'wet'],
            ['name' => 'Tumis Labu Siam', 'type' => 'wet'],
            ['name' => 'Setup Sayur', 'type' => 'wet'],
            ['name' => 'Tempe Kriwil', 'type' => 'wet'],
            ['name' => 'Pakcoy Saus Tiram', 'type' => 'wet'],
            ['name' => 'Tumis Buncis Broccoli', 'type' => 'wet'],
            ['name' => 'Acar Wortel Timun', 'type' => 'wet'],
            ['name' => 'Sambal Bawang', 'type' => 'wet'],
            ['name' => 'Buncis bb Bawang putih', 'type' => 'wet'],
            ['name' => 'Tumis Jamur Tiram Pakcoy', 'type' => 'wet'],
            ['name' => 'Cah buncis Baby corn', 'type' => 'wet'],
            ['name' => 'Bihun Goreng', 'type' => 'dry'],
            ['name' => 'Tumis Jamur Kuping Pakcoy', 'type' => 'wet'],
            ['name' => 'Mix Vegetable', 'type' => 'wet'],
            ['name' => 'Tumis Pakcoy', 'type' => 'wet'],
            ['name' => 'Sayur Pecel', 'type' => 'wet'],
            ['name' => 'Tumis Toge Wortel', 'type' => 'wet'],
            ['name' => 'Tumis Besai', 'type' => 'wet'],
            ['name' => 'Cah Kangkung Toge', 'type' => 'wet'],
            ['name' => 'Setup Sayuran', 'type' => 'wet'],
            ['name' => 'Tumis Buncis Brokoli', 'type' => 'wet'],
        ];

        foreach ($simpleMenus as $m) {
            Menu::firstOrCreate(
                ['name' => $m['name']],
                ['type' => $m['type'], 'category' => 'master', 'is_active' => true, 'description' => 'Master menu component.']
            );
        }

        // ── B. 4 Menu Paket dengan Komponen Master + Komposisi Bahan ──────────
        //
        // Setiap paket terdiri dari beberapa komponen master (category='master').
        // Setiap komponen master memiliki daftar bahan baku (MenuItems).
        // parent_id pada komponen master menunjuk ke ID menu paket.
        //
        // Struktur data:
        // 'packet' => [ nama, type, deskripsi ]
        // 'components' => [
        //   [ nama komponen, type, deskripsi, items => [ [bahan, qty, unit, group] ] ]
        // ]
        // ─────────────────────────────────────────────────────────────────────
        $packets = [

            // ═══════════════════════════════════════════════════════════════
            // PAKET 1: Nasi Ayam Goreng + Tumis Kangkung
            // Est. nutrisi: ~550 kkal, protein ~28g, lemak ~18g, KH ~70g
            // ═══════════════════════════════════════════════════════════════
            [
                'packet' => [
                    'name'        => 'Paket Nasi Ayam Goreng',
                    'type'        => 'dry',
                    'description' => 'Paket makan bergizi: nasi putih + ayam goreng bumbu kuning + tumis kangkung. Seimbang tinggi protein.',
                ],
                'components' => [
                    [
                        'name'        => 'Nasi Putih',
                        'type'        => 'dry',
                        'description' => 'Nasi putih pulen, sumber karbohidrat utama. 100g beras menghasilkan ±200g nasi.',
                        'items'       => [
                            ['bahan' => 'Beras',        'qty' => 100, 'unit' => 'gram', 'group' => 'Karbohidrat'],
                        ],
                    ],
                    [
                        'name'        => 'Ayam Goreng Bumbu Kuning',
                        'type'        => 'dry',
                        'description' => 'Ayam paha atas diungkep dengan bumbu kuning (lengkuas, kunyit, kemiri) lalu digoreng.',
                        'items'       => [
                            ['bahan' => 'Ayam',         'qty' => 80,  'unit' => 'gram', 'group' => 'Protein'],
                            ['bahan' => 'Minyak',       'qty' => 10,  'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang merah', 'qty' => 5,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                    [
                        'name'        => 'Tumis Kangkung',
                        'type'        => 'wet',
                        'description' => 'Kangkung segar ditumis dengan bawang putih dan sedikit terasi. Sumber zat besi dan vitamin C.',
                        'items'       => [
                            ['bahan' => 'Kangkung',     'qty' => 75,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Wortel',       'qty' => 20,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Minyak',       'qty' => 5,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════
            // PAKET 2: Nasi Telur Bacem + Sop Tahu Putih
            // Est. nutrisi: ~520 kkal, protein ~24g, lemak ~15g, KH ~72g
            // ═══════════════════════════════════════════════════════════════
            [
                'packet' => [
                    'name'        => 'Paket Nasi Telur Bacem Sop Tahu',
                    'type'        => 'wet',
                    'description' => 'Paket makan bergizi: nasi putih + telur bacem kecap + sop tahu putih bening. Rendah lemak, tinggi protein.',
                ],
                'components' => [
                    [
                        'name'        => 'Nasi Putih',   // sudah dibuat di paket 1, firstOrCreate
                        'type'        => 'dry',
                        'description' => 'Nasi putih pulen, sumber karbohidrat utama. 100g beras menghasilkan ±200g nasi.',
                        'items'       => [
                            ['bahan' => 'Beras',        'qty' => 100, 'unit' => 'gram', 'group' => 'Karbohidrat'],
                        ],
                    ],
                    [
                        'name'        => 'Telur Bacem Kecap',
                        'type'        => 'dry',
                        'description' => 'Telur ayam direbus lalu dibacem dalam bumbu kecap manis, bawang, dan lengkuas.',
                        'items'       => [
                            ['bahan' => 'Telur',        'qty' => 55,  'unit' => 'gram', 'group' => 'Protein'],
                            ['bahan' => 'Kecap manis',  'qty' => 10,  'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang merah', 'qty' => 4,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 2,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                    [
                        'name'        => 'Sop Tahu Putih',
                        'type'        => 'wet',
                        'description' => 'Sup bening dengan tahu putih, wortel, buncis, dan daun bawang. Ringan dan bergizi.',
                        'items'       => [
                            ['bahan' => 'Tahu',         'qty' => 60,  'unit' => 'gram', 'group' => 'Protein'],
                            ['bahan' => 'Wortel',       'qty' => 30,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Buncis',       'qty' => 30,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Bawang merah', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 2,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════
            // PAKET 3: Nasi Tempe Orek + Sop Wortel Kentang
            // Est. nutrisi: ~530 kkal, protein ~22g, lemak ~14g, KH ~78g
            // ═══════════════════════════════════════════════════════════════
            [
                'packet' => [
                    'name'        => 'Paket Nasi Tempe Sop Sayur',
                    'type'        => 'wet',
                    'description' => 'Paket makan bergizi: nasi putih + tempe orek manis + sop sayur bening. Tinggi serat dan protein nabati.',
                ],
                'components' => [
                    [
                        'name'        => 'Nasi Putih',
                        'type'        => 'dry',
                        'description' => 'Nasi putih pulen, sumber karbohidrat utama. 100g beras menghasilkan ±200g nasi.',
                        'items'       => [
                            ['bahan' => 'Beras',        'qty' => 100, 'unit' => 'gram', 'group' => 'Karbohidrat'],
                        ],
                    ],
                    [
                        'name'        => 'Tempe Orek Manis',
                        'type'        => 'dry',
                        'description' => 'Tempe diiris tipis lalu ditumis dengan kecap manis, cabai, dan bawang. Tekstur agak kering dan gurih.',
                        'items'       => [
                            ['bahan' => 'Tempe',        'qty' => 75,  'unit' => 'gram', 'group' => 'Protein'],
                            ['bahan' => 'Minyak',       'qty' => 8,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Kecap manis',  'qty' => 10,  'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang merah', 'qty' => 4,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 2,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                    [
                        'name'        => 'Sop Wortel Kentang',
                        'type'        => 'wet',
                        'description' => 'Sop bening wortel, kentang, dan kubis. Sumber vitamin A, serat, dan karbohidrat kompleks.',
                        'items'       => [
                            ['bahan' => 'Wortel',       'qty' => 40,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Kentang',      'qty' => 40,  'unit' => 'gram', 'group' => 'Karbohidrat'],
                            ['bahan' => 'Kubis',        'qty' => 30,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Bawang merah', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 2,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════
            // PAKET 4: Nasi Lele Goreng + Tumis Pakcoy Wortel
            // Est. nutrisi: ~560 kkal, protein ~30g, lemak ~20g, KH ~65g
            // ═══════════════════════════════════════════════════════════════
            [
                'packet' => [
                    'name'        => 'Paket Nasi Lele Pakcoy',
                    'type'        => 'dry',
                    'description' => 'Paket makan bergizi: nasi putih + lele goreng renyah + tumis pakcoy wortel. Tinggi Omega-3 dan vitamin.',
                ],
                'components' => [
                    [
                        'name'        => 'Nasi Putih',
                        'type'        => 'dry',
                        'description' => 'Nasi putih pulen, sumber karbohidrat utama. 100g beras menghasilkan ±200g nasi.',
                        'items'       => [
                            ['bahan' => 'Beras',        'qty' => 100, 'unit' => 'gram', 'group' => 'Karbohidrat'],
                        ],
                    ],
                    [
                        'name'        => 'Lele Goreng Renyah',
                        'type'        => 'dry',
                        'description' => 'Ikan lele segar dimarinasi dengan bumbu bawang kunyit, lalu digoreng hingga renyah.',
                        'items'       => [
                            ['bahan' => 'Lele',         'qty' => 90,  'unit' => 'gram', 'group' => 'Protein'],
                            ['bahan' => 'Minyak',       'qty' => 12,  'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Tomat',        'qty' => 15,  'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                    [
                        'name'        => 'Tumis Pakcoy Wortel',
                        'type'        => 'wet',
                        'description' => 'Pakcoy dan wortel ditumis cepat dengan bawang putih dan saus tiram. Renyah, segar, kaya vitamin.',
                        'items'       => [
                            ['bahan' => 'Pakcoy',       'qty' => 70,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Wortel',       'qty' => 30,  'unit' => 'gram', 'group' => 'Sayuran'],
                            ['bahan' => 'Minyak',       'qty' => 5,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                            ['bahan' => 'Bawang putih', 'qty' => 3,   'unit' => 'gram', 'group' => 'Bumbu & Minyak'],
                        ],
                    ],
                ],
            ],
        ];

        // ── Proses setiap paket ───────────────────────────────────────────────
        foreach ($packets as $packetData) {
            // 1. Buat Menu Paket
            $packet = Menu::firstOrCreate(
                ['name' => $packetData['packet']['name']],
                [
                    'type'        => $packetData['packet']['type'],
                    'category'    => 'packet',
                    'is_active'   => true,
                    'description' => $packetData['packet']['description'],
                ]
            );

            $this->command->info("📦 Paket: {$packet->name}");

            // 2. Buat setiap komponen master dan hubungkan ke paket via parent_id
            foreach ($packetData['components'] as $componentData) {
                $component = Menu::firstOrCreate(
                    ['name' => $componentData['name']],
                    [
                        'type'        => $componentData['type'],
                        'category'    => 'master',
                        'is_active'   => true,
                        'description' => $componentData['description'],
                        'parent_id'   => $packet->id,
                    ]
                );

                // Hapus items lama agar tidak duplikat saat re-seed
                $component->menuItems()->delete();

                $addedCount = 0;
                foreach ($componentData['items'] as $item) {
                    // Cari bahan baku (exact match dulu, lalu LIKE)
                    $rawMaterial = RawMaterial::whereRaw('LOWER(name) = ?', [strtolower($item['bahan'])])->first()
                        ?? RawMaterial::whereRaw('LOWER(name) LIKE ?', [strtolower($item['bahan']).'%'])->first();

                    if ($rawMaterial) {
                        MenuItem::create([
                            'menu_id'              => $component->id,
                            'raw_material_id'      => $rawMaterial->id,
                            'quantity_per_portion' => $item['qty'],
                            'unit'                 => $item['unit'],
                            'quantity_input'       => $item['qty'],
                            'conversion_factor'    => 1.0,
                            'group_name'           => $item['group'],
                        ]);
                        $addedCount++;
                    } else {
                        $this->command->warn("    ⚠ Bahan '{$item['bahan']}' tidak ditemukan untuk komponen: {$component->name}");
                    }
                }

                $this->command->info("   ✅ Komponen '{$component->name}' – {$addedCount} bahan ditambahkan.");
            }
        }

        $this->command->info('');
        $this->command->info('🎉 MasterMenuSeeder selesai!');
    }
}
