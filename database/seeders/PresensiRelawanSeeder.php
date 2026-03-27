<?php

namespace Database\Seeders;

use App\Models\MasterSppg;
use App\Models\Relawan;
use Illuminate\Database\Seeder;

class PresensiRelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Ambil atau buat SPPG default
        $sppg = MasterSppg::first();
        if (! $sppg) {
            $sppg = MasterSppg::create([
                'name' => 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02',
                'alamat' => '-',
                'status' => 'Aktif',
            ]);
        }

        $relawans = [
            ['nama' => 'Rizky Putra Dinasti', 'jabatan' => 'Asisten Lapangan'],
            ['nama' => 'Asep Bagas S', 'jabatan' => 'Koordinator Persiapan Bahan Makanan'],
            ['nama' => 'Nurul Fatimah', 'jabatan' => 'Persiapan Bahan Makanan'],
            ['nama' => 'Yuliati', 'jabatan' => 'Persiapan Bahan Makanan'],
            ['nama' => 'Wiwin Herlina', 'jabatan' => 'Persiapan Bahan Makanan'],
            ['nama' => 'Deni Nova Novita', 'jabatan' => 'Persiapan Bahan Makanan'],
            ['nama' => 'Achmad Al Amin', 'jabatan' => 'Chef'],
            ['nama' => 'Ninin Budi', 'jabatan' => 'Koordinator Produksi/Masak'],
            ['nama' => 'Nur Hasanah', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'Ernawati', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'Anik Atiningsih', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'Halimatus Sa\'diyah', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'Restu Hadi P', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'M. Munir Arifin', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'M. Ridwan Alamsyah', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'Devi Putri Vinulia', 'jabatan' => 'Produksi/Masak'],
            ['nama' => 'M. Rohwandi Zenka Firdaus, S.Ikom', 'jabatan' => 'Admin'],
            ['nama' => 'Wahyuni Intan P', 'jabatan' => 'Koordinator Pemorsian'],
            ['nama' => 'Vira Putri Wijayanti', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Putri Pratiwi', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Dianira Marsela', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Riyana', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Yosi Triyana Pradana', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Lia Rosida', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Novan Tulmantius', 'jabatan' => 'Pemorsian'],
            ['nama' => 'Febriyana Della Aurelia', 'jabatan' => 'Pemorsian'],
            ['nama' => 'M. Taufiq Hidayat', 'jabatan' => 'Koordinator Packing'],
            ['nama' => 'Yoga Dwi Febriyanto', 'jabatan' => 'Packing'],
            ['nama' => 'Chandra Lutfianto', 'jabatan' => 'Koordinator Distribusi'],
            ['nama' => 'Bayu Ahmad Marzuki', 'jabatan' => 'Distribusi'],
            ['nama' => 'M. Sofiyanto', 'jabatan' => 'Distribusi'],
            ['nama' => 'Muhammad Arifiyanto', 'jabatan' => 'Distribusi'],
            ['nama' => 'Abd Munir', 'jabatan' => 'Koordinator Cuci Ompreng'],
            ['nama' => 'Ratih Arsiwidati', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Elok Nurizky Rahmad', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Ariel Raihan Efendi', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Nurhasanah', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Hermanto', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Riyan Trio Firdaus', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Aldi Akbar R', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Suparman', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Muhammad Dico Fahrul', 'jabatan' => 'Cuci Ompreng'],
            ['nama' => 'Lutfiyah Indriana', 'jabatan' => 'Koordinator Kebersihan'],
            ['nama' => 'Badrus Sholeh', 'jabatan' => 'Kebersihan'],
            ['nama' => 'Untung', 'jabatan' => 'Keamanan'],
        ];

        foreach ($relawans as $index => $data) {
            Relawan::firstOrCreate(
                [
                    'nama' => $data['nama'],
                    'jabatan' => $data['jabatan'],
                ],
                [
                    'sppg_id' => $sppg->id,
                    'tipe' => 'tetap',
                    'aktif' => true,
                    'nomor_urut' => $index + 1,
                ]
            );
        }
    }
}
