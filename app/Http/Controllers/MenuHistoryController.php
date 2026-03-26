<?php

namespace App\Http\Controllers;

use App\Models\MenuHistory;
use App\Models\MenuHistoryDay;
use App\Models\Rab;
use App\Models\RabDetail;
use App\Models\SchoolCalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuHistoryController extends Controller
{
    // ─────────────────────────────────────────────
    // LIST
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $histories = MenuHistory::with(['days', 'createdBy'])
            ->when($request->year,  fn($q) => $q->where('year', $request->year))
            ->when($request->month, fn($q) => $q->whereMonth('start_date', $request->month))
            ->orderByDesc('start_date')
            ->paginate(20);

        return view('menu-histories.index', [
            'histories'  => $histories,
            'filterYear' => $request->year ?? now()->year,
            'filterMonth'=> $request->month,
        ]);
    }

    // ─────────────────────────────────────────────
    // DETAIL
    // ─────────────────────────────────────────────
    public function show(MenuHistory $menuHistory)
    {
        $menuHistory->load(['days.menu', 'days.uploadedBy', 'sppg']);

        // Calculate Daily RABs dynamically per SPPG based on SchoolCalendars
        $dailyRabs = [];
        foreach ($menuHistory->days as $day) {
            $calendars = SchoolCalendar::where('date', $day->date)
                ->where('sppg_id', $menuHistory->sppg_id)
                ->where('day_status', 'receive')
                ->get();

            $porsiBesar = $calendars->sum('large_portion_count');
            // some schools might just put it in small_portion_count or teacher_count
            $porsiKecil = $calendars->sum('small_portion_count');
            
            $totalPortions = $calendars->sum('portion_count');
            
            // If the user's school only has large/small portions mixed in portion_count, 
            // recalculate exactly based on small_portion_count vs large_portion_count
            // Pagu: Besar * 10k, Kecil * 8k
            $pagu = ($porsiBesar * 10000) + ($porsiKecil * 8000);

            $ingredients = [];
            $totalBelanja = 0;

            if ($day->menu) {
                foreach ($day->menu->allMenuItems() as $item) {
                    $raw = $item->rawMaterial;
                    $qty = $item->quantity_per_portion * $totalPortions;
                    $subtotal = $qty * $raw->price_per_unit;

                    if (!isset($ingredients[$raw->id])) {
                        $ingredients[$raw->id] = [
                            'name' => $raw->name,
                            'unit' => $raw->unit,
                            'price' => $raw->price_per_unit,
                            'qty' => 0,
                            'subtotal' => 0
                        ];
                    }
                    $ingredients[$raw->id]['qty'] += $qty;
                    $ingredients[$raw->id]['subtotal'] += $subtotal;
                    $totalBelanja += $subtotal;
                }
            }

            $selisih = $pagu - $totalBelanja;
            $marginPerPorsi = $totalPortions > 0 ? ($selisih / $totalPortions) : 0;

            $hargaPM = 10000 - $marginPerPorsi;
            $hargaPK = 8000 - $marginPerPorsi;

            $dailyRabs[$day->id] = [
                'day' => $day,
                'porsiBesar' => $porsiBesar,
                'porsiKecil' => $porsiKecil,
                'totalPortions' => $totalPortions,
                'pagu' => $pagu,
                'ingredients' => $ingredients,
                'totalBelanja' => $totalBelanja,
                'selisih' => $selisih,
                'hargaPM' => $hargaPM,
                'hargaPK' => $hargaPK,
            ];
        }

        return view('menu-histories.show', compact('menuHistory', 'dailyRabs'));
    }

    public function printRab(MenuHistory $menuHistory, MenuHistoryDay $day)
    {
        $calendars = SchoolCalendar::where('date', $day->date)
            ->where('sppg_id', $menuHistory->sppg_id)
            ->where('day_status', 'receive')
            ->get();

        $porsiBesar = $calendars->sum('large_portion_count');
        $porsiKecil = $calendars->sum('small_portion_count');
        $totalPortions = $calendars->sum('portion_count');

        $pagu = ($porsiBesar * 10000) + ($porsiKecil * 8000);

        $ingredients = [];
        $totalBelanja = 0;

        if ($day->menu) {
            foreach ($day->menu->allMenuItems() as $item) {
                $raw = $item->rawMaterial;
                $qty = $item->quantity_per_portion * $totalPortions;
                $subtotal = $qty * $raw->price_per_unit;

                if (!isset($ingredients[$raw->id])) {
                    $ingredients[$raw->id] = [
                        'name' => $raw->name,
                        'unit' => $raw->unit,
                        'price' => $raw->price_per_unit,
                        'qty' => 0,
                        'subtotal' => 0
                    ];
                }
                $ingredients[$raw->id]['qty'] += $qty;
                $ingredients[$raw->id]['subtotal'] += $subtotal;
                $totalBelanja += $subtotal;
            }
        }

        $selisih = $pagu - $totalBelanja;
        $marginPerPorsi = $totalPortions > 0 ? ($selisih / $totalPortions) : 0;

        $hargaPM = 10000 - $marginPerPorsi;
        $hargaPK = 8000 - $marginPerPorsi;

        $data = [
            'menuHistory' => $menuHistory,
            'day' => $day,
            'porsiBesar' => $porsiBesar,
            'porsiKecil' => $porsiKecil,
            'totalPortions' => $totalPortions,
            'pagu' => $pagu,
            'ingredients' => collect($ingredients)->values(), // convert to collection
            'totalBelanja' => $totalBelanja,
            'selisih' => $selisih,
            'hargaPM' => $hargaPM,
            'hargaPK' => $hargaPK,
        ];

        return view('menu-histories.print-rab', $data);
    }

    // ─────────────────────────────────────────────
    // UPLOAD FOTO → pending → selesai
    // ─────────────────────────────────────────────
    public function downloadWord(MenuHistory $menuHistory)
    {
        $menuHistory->load(['days.menu']);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        foreach ($menuHistory->days as $day) {
            $section = $phpWord->addSection();

            $section->addText("MENU PAKET MAKAN BERGIZI GRATIS", ['bold' => true, 'size' => 12]);
            $dateStr = strtoupper($day->day_name) . ', ' . strtoupper($day->date->isoFormat('D MMMM Y'));
            $section->addText($dateStr, ['bold' => true, 'size' => 12]);
            $section->addText(""); // empty line

            if ($day->menu) {
                if ($day->menu->category === 'packet') {
                    $items = $day->menu->components()->pluck('name')->toArray();
                } else {
                    $items = [$day->menu->name];
                }

                foreach ($items as $item) {
                    $section->addListItem($item, 0, null, \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER);
                }
            }

            $section->addText("");

            if ($day->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($day->photo_path)) {
                $imagePath = \Illuminate\Support\Facades\Storage::disk('public')->path($day->photo_path);
                $section->addImage($imagePath, [
                    'width' => 450,
                ]);
            }
        }

        $fileName = 'Menu_Harian_' . str_replace('/', '_', $menuHistory->nomor) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function uploadPhoto(Request $request, MenuHistoryDay $day)
    {
        $request->validate([
            'photo' => 'nullable|image|max:5120',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($request->hasFile('photo')) {
            // delete old if exists
            if ($day->photo_path) {
                Storage::disk('public')->delete($day->photo_path);
            }
            $path = $request->file('photo')->store('menu-histories', 'public');
            $day->photo_path = $path;
            $day->status = 'selesai';
            $day->uploaded_by = auth()->id();
            $day->uploaded_at = now();
        }

        if ($request->has('notes')) {
            // Allow storing notes even without photo
            $day->notes = $request->notes;
        }

        $day->save();
        return back()->with('success', 'Foto/Catatan berhasil diupdate!');
    }

    public function uploadNota(Request $request, MenuHistoryDay $day)
    {
        $request->validate([
            'nota_photos' => 'nullable|array',
            'nota_photos.*' => 'image|max:5120',
            'nota_notes' => 'nullable|string|max:1000'
        ]);

        $paths = is_array($day->nota_paths) ? $day->nota_paths : [];

        if ($request->hasFile('nota_photos')) {
            foreach ($request->file('nota_photos') as $file) {
                $paths[] = $file->store('menu-histories/nota', 'public');
            }
            $day->nota_paths = $paths;
            $day->nota_status = 'selesai';
        }

        if ($request->has('nota_notes')) {
            $day->nota_notes = $request->nota_notes;
        }

        $day->save();
        return back()->with('success', 'Nota harian berhasil diupdate!');
    }

    public function deleteNotaPhoto(MenuHistoryDay $day, $index)
    {
        $paths = is_array($day->nota_paths) ? $day->nota_paths : [];
        if (isset($paths[$index])) {
            Storage::disk('public')->delete($paths[$index]);
            unset($paths[$index]);
            $day->nota_paths = array_values($paths);
            if (empty($day->nota_paths)) {
                $day->nota_status = 'pending';
            }
            $day->save();
        }
        return back()->with('success', 'Foto nota berhasil dihapus!');
    }
}
