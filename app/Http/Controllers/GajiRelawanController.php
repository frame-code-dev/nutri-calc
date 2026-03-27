<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use App\Models\SalaryPeriod;
use App\Models\SalaryDetail;
use App\Models\SalaryComponent;
use App\Models\SalarySetting;
use App\Models\MasterSppg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GajiRelawanController extends Controller
{
    // ─────────────────────────────────────────
    // INDEX — Daftar periode gaji
    // ─────────────────────────────────────────
    public function index()
    {
        $periods = SalaryPeriod::orderByDesc('tanggal_mulai')->get();
        return view('gaji-relawan.index', compact('periods'));
    }

    // ─────────────────────────────────────────
    // CREATE / STORE — Buat periode baru
    // ─────────────────────────────────────────
    public function create()
    {
        $sppgs = MasterSppg::all();
        return view('gaji-relawan.create', compact('sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sppg_id'         => 'nullable|exists:master_sppgs,id',
            'nama_periode'    => 'required|string|max:255',
            'tipe'            => 'required|in:mingguan,bulanan',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'periode_ke'      => 'required|integer|min:1|max:12',
            'penandatangan_1' => 'nullable|string|max:255',
            'penandatangan_2' => 'nullable|string|max:255',
            'instansi'        => 'nullable|string|max:255',
        ]);

        $relawans = Relawan::aktif()->orderBy('nomor_urut')->get();
        $sppgId = $validated['sppg_id'] ?? null;

        // Validasi apakah ada upah yang 0 atau belum disetting
        $missingWages = [];
        foreach ($relawans as $relawan) {
            $setting = SalarySetting::where('jabatan', $relawan->jabatan)
                ->where('sppg_id', $sppgId)
                ->first();

            if (!$setting) {
                $setting = SalarySetting::where('jabatan', $relawan->jabatan)
                    ->whereNull('sppg_id')
                    ->first();
            }

            if (!$setting || $setting->upah_per_hari <= 0) {
                $missingWages[] = $relawan->nama . ' (' . $relawan->jabatan . ')';
            }
        }

        if (count($missingWages) > 0) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal membuat periode. Terdapat relawan dengan Upah per Hari Rp0 atau belum diatur: ' . implode(', ', $missingWages) . '. Silakan atur terlebih dahulu di menu Setting Upah.'
            ]);
        }

        // Siapkan array kunci hari default
        $defaultHariKeys = [];
        if ($validated['tipe'] === 'mingguan') {
            $curr = \Carbon\Carbon::parse($validated['tanggal_mulai']);
            $endD = \Carbon\Carbon::parse($validated['tanggal_selesai']);
            while ($curr->lte($endD)) {
                if (!$curr->isSunday()) {
                    $defaultHariKeys[] = $curr->format('Y-m-d');
                }
                $curr->addDay();
            }
        } else {
            $defaultHariKeys = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        }

        DB::transaction(function () use ($validated, $relawans, $sppgId, $defaultHariKeys) {
            $period = SalaryPeriod::create($validated);

            foreach ($relawans as $relawan) {
                $setting = SalarySetting::where('jabatan', $relawan->jabatan)
                    ->where('sppg_id', $sppgId)
                    ->first();

                if (!$setting) {
                    $setting = SalarySetting::where('jabatan', $relawan->jabatan)
                        ->whereNull('sppg_id')
                        ->first();
                }

                $upah = $setting->upah_per_hari;
                
                $hariKerjaUser = [];
                foreach ($defaultHariKeys as $dateKey) {
                    $hariKerjaUser[$dateKey] = $upah; // Nilai default adalah nilai upah
                }
                
                $totalHariRaw = collect($hariKerjaUser)->filter(fn($v) => (float)$v > 0)->count();
                $totalUpahRaw = collect($hariKerjaUser)->map(fn($v) => (float)$v)->sum();

                SalaryDetail::create([
                    'period_id'     => $period->id,
                    'relawan_id'    => $relawan->id,
                    'hari_kerja'    => $hariKerjaUser,
                    'total_hari'    => $totalHariRaw,
                    'upah_per_hari' => $upah,
                    'total_upah'    => $totalUpahRaw,
                ]);
            }
        });

        return redirect()->route('gaji-relawan.index')
            ->with('success', 'Periode gaji berhasil dibuat.');
    }

    // ─────────────────────────────────────────
    // SHOW — Detail absensi & gaji
    // ─────────────────────────────────────────
    public function show(SalaryPeriod $gajiRelawan)
    {
        $period = $gajiRelawan;
        $period->load([
            'details.relawan',
            'details.components',
        ]);

        // Tanggal kolom (Senin-Sabtu) dari periode
        $hariKolom = $this->getHariKolom($period);

        // Pisahkan tetap dan magang
        $detailsTetap  = $period->details->filter(fn($d) => $d->relawan->tipe === 'tetap')
            ->sortBy('relawan.nomor_urut');
        $detailsMagang = $period->details->filter(fn($d) => $d->relawan->tipe === 'magang')
            ->sortBy('relawan.nomor_urut');

        $totalUpahTetap  = $detailsTetap->sum('total_upah');
        $totalUpahMagang = $detailsMagang->sum('total_upah');

        return view('gaji-relawan.show', compact(
            'period',
            'hariKolom',
            'detailsTetap',
            'detailsMagang',
            'totalUpahTetap',
            'totalUpahMagang'
        ));
    }

    // ─────────────────────────────────────────
    // SAVE ABSENSI
    // ─────────────────────────────────────────
    public function saveAbsensi(Request $request, SalaryPeriod $gajiRelawan)
    {
        $period = $gajiRelawan;

        $request->validate([
            'absensi'               => 'required|array',
            'absensi.*.detail_id'   => 'required|exists:salary_details,id',
            'absensi.*.hari'        => 'required|array',
            'absensi.*.upah'        => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->absensi as $item) {
                $detail = SalaryDetail::findOrFail($item['detail_id']);

                // Hitung total hari: jumlahkan semua nominal input absensi yang dimasukkan (misal isi 100 maka total hari +100)
                $hariKerja  = $item['hari'];
                $totalHari = collect($hariKerja)->filter(fn($v) => (float)$v > 0)->count();

                $detail->hari_kerja    = $hariKerja;
                $detail->total_hari    = $totalHari;
                $detail->upah_per_hari = $item['upah'];
                $detail->save();
                $detail->recalculate();
            }
        });

        return redirect()->route('gaji-relawan.show', $period)
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    // ─────────────────────────────────────────
    // SAVE COMPONENT (tunjangan / bonus manual)
    // ─────────────────────────────────────────
    public function saveComponent(Request $request, SalaryDetail $detail)
    {
        $request->validate([
            'komponen'          => 'required|array|min:1',
            'komponen.*.nama'   => 'required|string|max:255',
            'komponen.*.jumlah' => 'required|numeric',
            'komponen.*.tanggal'=> 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $detail) {
            // Hapus komponen lama lalu buat baru
            $detail->components()->delete();

            foreach ($request->komponen as $k) {
                SalaryComponent::create([
                    'detail_id' => $detail->id,
                    'nama'      => $k['nama'],
                    'jumlah'    => $k['jumlah'],
                    'tanggal'   => !empty($k['tanggal']) ? $k['tanggal'] : null,
                ]);
            }
            $detail->recalculate();
        });

        return redirect()->back()->with('success', 'Komponen gaji berhasil disimpan.');
    }

    public function deleteComponent(SalaryComponent $component)
    {
        $detail = $component->detail;
        $component->delete();
        $detail->recalculate();

        return redirect()->back()->with('success', 'Komponen berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    // CETAK SLIP PDF (4 per halaman A4)
    // ─────────────────────────────────────────
    public function slipPdf(SalaryPeriod $gajiRelawan)
    {
        $period = $gajiRelawan;
        $period->load(['details.relawan', 'details.components']);

        $details = $period->details
            ->sortBy('relawan.tipe')
            ->sortBy('relawan.nomor_urut')
            ->values();

        return view('gaji-relawan.slip-pdf', compact('period', 'details'));
    }

    public function slipSinglePdf(SalaryPeriod $gajiRelawan, Relawan $relawan)
    {
        $period = $gajiRelawan;
        $detail = SalaryDetail::with('components')
            ->where('period_id', $period->id)
            ->where('relawan_id', $relawan->id)
            ->firstOrFail();

        $details = collect([$detail]);

        return view('gaji-relawan.slip-pdf', compact('period', 'details'));
    }

    // ─────────────────────────────────────────
    // CETAK REKAP PDF
    // ─────────────────────────────────────────
    public function rekapPdf(SalaryPeriod $gajiRelawan)
    {
        $period = $gajiRelawan;
        $period->load(['details.relawan', 'details.components']);

        $detailsTetap  = $period->details->filter(fn($d) => $d->relawan->tipe === 'tetap')
            ->sortBy('relawan.nomor_urut')->values();
        $detailsMagang = $period->details->filter(fn($d) => $d->relawan->tipe === 'magang')
            ->sortBy('relawan.nomor_urut')->values();

        $totalTetap  = $detailsTetap->sum('total_upah');
        $totalMagang = $detailsMagang->sum('total_upah');

        $hariKolom = $this->getHariKolom($period);

        return view('gaji-relawan.rekap-pdf', compact(
            'period',
            'detailsTetap',
            'detailsMagang',
            'totalTetap',
            'totalMagang',
            'hariKolom'
        ));
    }

    // ─────────────────────────────────────────
    // HELPER: Ambil kolom hari dari periode
    // ─────────────────────────────────────────
    private function getHariKolom(SalaryPeriod $period): array
    {
        $start = $period->tanggal_mulai;
        $end   = $period->tanggal_selesai;
        $kolom = [];

        if ($period->tipe === 'mingguan') {
            // Kelompokkan per 6 hari kerja (tanpa Minggu)
            $weekIndex = 1;
            $current = $start->copy();
            $daysCount = 0;

            while ($current->lte($end)) {
                if (!$current->isSunday()) {
                    $key = $current->format('Y-m-d');
                    $kolom['MINGGU KE ' . $weekIndex][$key] = $current->translatedFormat('D d-M');
                    $daysCount++;
                    if ($daysCount == 6) {
                        $weekIndex++;
                        $daysCount = 0;
                    }
                }
                $current->addDay();
            }
        } else {
            // Bulanan: tampilkan label hari saja tanpa tanggal
            $namaHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            foreach ($namaHari as $hari) {
                $kolom['BULANAN'][$hari] = ucfirst($hari);
            }
        }

        return $kolom;
    }
}
