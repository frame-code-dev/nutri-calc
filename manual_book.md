---
title: "Buku Panduan Pengguna"
subtitle: "Management Gizi (MBG) System"
author: "Dokumentasi Resmi"
date: "2026"
geometry: "margin=2.5cm"
---

# 📖 Buku Panduan: Management Gizi (MBG) System

<div style="text-align: center; margin-top: 50px; margin-bottom: 50px;">
  <h2>Sistem Cerdas Pengelolaan Distribusi Makanan Bergizi Gratis</h2>
  <p>Dilengkapi Kalkulasi Gizi Otomatis, Manajemen Stok, dan Skala Multi-Sekolah</p>
</div>

---

## 📑 Daftar Isi

1. **Pendahuluan**
   - 1.1 Tentang MBG System
   - 1.2 Fitur Unggulan
2. **Hak Akses & Pengguna**
3. **Persiapan & Instalasi Sistem**
4. **Panduan Penggunaan (User Guide)**
   - 4.1 Login & Dashboard
   - 4.2 Manajemen Bahan Baku & Stok
   - 4.3 Manajemen Pembuatan Menu (Fitur Kalkulasi Gizi)
   - 4.4 Manajemen Sekolah
5. **Simulasi & Studi Kasus**
6. **Troubleshooting & Bantuan**

---

## 1. Pendahuluan

### 1.1 Tentang MBG System
**MBG (Makan Bergizi Gratis) System** adalah sebuah aplikasi berbasis web modern yang dibangun untuk menyederhanakan, mengotomatisasi, dan memastikan tingkat keakuratan gizi pada proses distribusi makan siang gratis di sekolah-sekolah. Dibangun menggunakan teknologi terdepan (Laravel 12, Tailwind CSS), aplikasi ini menawarkan efisiensi penuh di setiap rantai pasokan.

### 1.2 Fitur Unggulan
- 🌟 **Automatic Nutritional Calculation:** Fitur "Bintang" yang mampu menghitung kadar energi, protein, lemak, karbohidrat, dan serat secara otomatis berdasarkan gramasi bahan baku per produk.
- 🏫 **Manajemen Multi-Sekolah:** Mendukung pendataan koordinator, jadwal, siswa, dan pengiriman makanan secara masif ke banyak sekolah sekaligus.
- 📦 **Manajemen Stok Real-Time:** Memonitor setiap bahan baku yang Masuk (In) dan Keluar (Out) untuk dapur produksi.
- 📱 **Desain Responsif & Interaktif:** Dibangun dengan tampilan antarmuka yang intuitif sehingga mudah digunakan di HP, Tablet, maupun PC.

---

## 2. Hak Akses & Pengguna

Sistem dirancang dengan keamanan multi-level. Terdapat 5 peran utama:

| Peran (Role) | Akses Utama & Tanggung Jawab | Email Simulasi |
| :--- | :--- | :--- |
| **Super Admin** | Akses penuh seluruh sistem, pengaturan master data, dan kontrol akses. | `superadmin@mbg.id` |
| **Admin MBG** | Mengelola menu, bahan baku, sekolah, dan operasional harian. | `admin@mbg.id` |
| **Koord. Sekolah**| Melakukan konfirmasi penerimaan, memantau jadwal kiriman. | `budi.koordinator@mbg.id` |
| **Koord. Dapur** | Mengatur ketersediaan stok, pengeluaran bahan untuk menu. | `fatimah.dapur@mbg.id` |
| **Supplier** | Menyediakan pasokan bahan baku secara berkala. | `supplier1@mbg.id` |

*(Catatan: Password standar untuk simulasi adalah `password`)*

---

## 3. Persiapan & Instalasi Sistem

*(Ditujukan untuk Administrator IT / Developer)*

Aplikasi ini sangat mudah untuk di-deploy baik di server lokal (XAMPP/Laragon) maupun di Cloud.

1. **Clone & Masuk ke Direktori:**
   Buka terminal/CMD dan arahkan ke folder `mbg-system`.
2. **Install Dependensi:**
   Jalankan `composer install` dan `npm install`.
3. **Konfigurasi Lingkungan (.env):**
   Copy `.env.example` menjadi `.env`. Sesuaikan kredensial Database di dalam file tersebut (contoh databasenya: `mbg_system`). Generate key dengan `php artisan key:generate`.
4. **Migrasi & Dummy Data:**
   Jalankan perintah ini untuk membangun tabel dan sampel data gizi:
   `php artisan migrate --seed`
5. **Jalankan Aplikasi:**
   Jalankan `npm run dev` dan `php artisan serve`. Buka `http://localhost:8000` di browser Anda.

---

## 4. Panduan Penggunaan (User Guide)

### 4.1 Login & Dashboard
Buka halaman utama aplikasi. Klik menu **Login**. Masukkan Email dan Password sesuai dengan Hak Akses Anda (lihat Bab 2). Setelah berhasil, Anda akan dialihkan ke halaman utama/dashboard dengan ringkasan status terkini (jumlah menu aktif, data sekolah, dan stok bahan).

### 4.2 Manajemen Bahan Baku & Stok
Sistem stok menggunakan metode *In-Out balance*.
- **Data Bahan Baku (Raw Material):** Setiap bahan (misal: Beras, Daging Ayam) dikelola per-gram/ml beserta kandungan nutrisi standarnya per 100g.
- **Transaksi Stok:** Koordinator Dapur dapat mencatat bahan masuk dari supplier, atau bahan yang keluar untuk dimasak.

### 4.3 Manajemen Pembuatan Menu (Fitur Kalkulasi Gizi)
Ini adalah menu terpenting untuk memastikan setiap porsi makan siang memenuhi standar nasional.
1. Masuk ke modul **Menu**.
2. Klik **Tambah Menu Baru** (Isikan Nama Menu, Jenis: Basah/Kering).
3. **Tambahkan Komposisi (Menu Items):** Pilih bahan (Misal: Ayam Goreng) lalu masukkan takarannya dalam satuan gram (Misal: 150g).
4. **Hasil Otomatis:** Sistem akan langsung mengkalikan jumlah gram tersebut dengan tabel referensi gizi per 100g secara real-time. Anda akan melihat kartu interaktif bertuliskan total Kalori, Protein, Lemak, dll.

### 4.4 Manajemen Sekolah
Admin dapat mendaftarkan sekolah-sekolah yang menerima program.
- Sistem mencatat jumlah siswa per sekolah.
- Menetapkan satu guru/staff sebagai **Koordinator Sekolah**.
- (Fase Selanjutnya) Fitur *Weekly Lock* untuk mengunci jadwal pengiriman makanan minggu depan.

---

## 5. Simulasi & Studi Kasus

**Studi Kasus: Pembuatan Menu "Ayam Riza"**
- **Bahan 1:** Ayam Goreng (150g). Sistem menghitung energi: `(150/100) x 239 kkal = 358.5 kkal`.
- **Bahan 2:** Nasi Putih (200g). `(200/100) x 130 kkal = 260 kkal`.
- **Bahan 3:** Sayur Kol (100g). `(100/100) x 25 kkal = 25 kkal`.
- **Bahan 4:** Susu UHT (200ml). `(200/100) x 61 kkal = 122 kkal`.

**Total Otomatis di Layar:** 765.5 Kkal. Semua proses matematika rumit diatas disembunyikan dalam antarmuka yang canggih dan sangat mudah dipahami.

---

## 6. Troubleshooting & Bantuan

- **Gagal Login (Error 401/403):** Pastikan email dan sandi sudah benar. Jika role tidak terbaca, jalankan `php artisan optimize:clear` di terminal server.
- **Kesalahan Kalkulasi Gizi:** Jika dirasa angkanya tidak wajar, periksa menu Master **Data Gizi Bahan Baku**. Pastikan nilai nutrisi yang diinput adalah patokan untuk seberat **100 gram/ml**.
- **Fitur Notifikasi WhatsApp:** Membutuhkan setup koneksi API Fonnte pada file `.env`. (Masih dalam tahap finalisasi).

---

> Buku Panduan ini bersifat dinamis dan akan terus diperbarui mengikuti perkembangan versi aplikasi MBG System. Terima kasih telah mendukung program Makan Bergizi Gratis demi masa depan anak bangsa!
