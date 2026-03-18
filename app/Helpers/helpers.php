<?php

if (!function_exists('terbilang')) {
    /**
     * Convert a number to Indonesian words.
     */
    function terbilang(float $angka): string
    {
        $angka  = (int) round($angka);
        $bilangan = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
            'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
            'Sebelas',
        ];

        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return terbilang((int)($angka / 10)) . ' Puluh' . (($angka % 10 !== 0) ? ' ' . terbilang($angka % 10) : '');
        } elseif ($angka < 200) {
            return 'Seratus' . (($angka - 100 !== 0) ? ' ' . terbilang($angka - 100) : '');
        } elseif ($angka < 1000) {
            return terbilang((int)($angka / 100)) . ' Ratus' . (($angka % 100 !== 0) ? ' ' . terbilang($angka % 100) : '');
        } elseif ($angka < 2000) {
            return 'Seribu' . (($angka - 1000 !== 0) ? ' ' . terbilang($angka - 1000) : '');
        } elseif ($angka < 1000000) {
            return terbilang((int)($angka / 1000)) . ' Ribu' . (($angka % 1000 !== 0) ? ' ' . terbilang($angka % 1000) : '');
        } elseif ($angka < 1000000000) {
            return terbilang((int)($angka / 1000000)) . ' Juta' . (($angka % 1000000 !== 0) ? ' ' . terbilang($angka % 1000000) : '');
        } elseif ($angka < 1000000000000) {
            return terbilang((int)($angka / 1000000000)) . ' Miliar' . (($angka % 1000000000 !== 0) ? ' ' . terbilang($angka % 1000000000) : '');
        }
        return 'Nilai terlalu besar';
    }

    /**
     * Convert a number to Indonesian Rupiah words.
     * e.g. 600000 → "Enam Ratus Ribu Rupiah"
     */
    function terbilangRupiah(float $angka): string
    {
        $angka = (int) round($angka);
        if ($angka == 0) return 'Nol Rupiah';
        return terbilang($angka) . ' Rupiah';
    }
}
