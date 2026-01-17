<?php

namespace App\Http\Controllers;

use App\Models\WeeklyLock;
use App\Models\School;
use App\Models\SchoolCalendar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WeeklyLockController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display weekly locks management
     */
    public function index(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Get lock for this week
        $lock = WeeklyLock::where('week_number', $weekNumber)
            ->where('year', $year)
            ->first();

        // Get all active schools
        $schools = School::where('is_active', true)->get();

        // Check completion status for each school
        $schoolsStatus = [];
        foreach ($schools as $school) {
            $calendars = SchoolCalendar::where('school_id', $school->id)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->count();

            $schoolsStatus[] = [
                'school' => $school,
                'filled' => $calendars,
                'is_complete' => $calendars >= 5,
            ];
        }

        // Overall completion
        $totalSchools = count($schoolsStatus);
        $completedSchools = collect($schoolsStatus)->where('is_complete', true)->count();
        $canLock = $completedSchools === $totalSchools && $totalSchools > 0;

        return view('weekly-locks.index', compact(
            'weekNumber',
            'year',
            'lock',
            'schoolsStatus',
            'totalSchools',
            'completedSchools',
            'canLock'
        ));
    }

    /**
     * Lock a specific week
     */
    public function lock(Request $request)
    {
        $validated = $request->validate([
            'week_number' => 'required|integer|min:1|max:53',
            'year' => 'required|integer|min:2024|max:2030',
        ]);

        $weekNumber = $validated['week_number'];
        $year = $validated['year'];

        // Check if already locked
        $existingLock = WeeklyLock::where('week_number', $weekNumber)
            ->where('year', $year)
            ->first();

        if ($existingLock && $existingLock->is_locked) {
            return back()->with('error', 'Minggu ini sudah terkunci!');
        }

        // Validate all schools have complete calendars
        $schools = School::where('is_active', true)->get();
        $incompleteSchools = [];

        foreach ($schools as $school) {
            $calendars = SchoolCalendar::where('school_id', $school->id)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->count();

            if ($calendars < 5) {
                $incompleteSchools[] = $school->name;
            }
        }

        if (count($incompleteSchools) > 0) {
            $schoolList = implode(', ', $incompleteSchools);
            return back()->with('error', "Tidak dapat mengunci! Sekolah berikut belum lengkap: {$schoolList}");
        }

        DB::beginTransaction();
        try {
            // Create or update lock
            $lock = WeeklyLock::updateOrCreate(
                [
                    'week_number' => $weekNumber,
                    'year' => $year,
                ],
                [
                    'is_locked' => true,
                    'locked_by' => auth()->id(),
                    'locked_at' => now(),
                ]
            );

            // TODO: Trigger stock reduction based on menus
            // This would be implemented in Phase 11

            DB::commit();

            return back()->with('success', "Minggu {$weekNumber}/{$year} berhasil dikunci! Semua perubahan sekarang diblokir.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengunci minggu: ' . $e->getMessage());
        }
    }

    /**
     * Unlock a specific week (Super Admin only)
     */
    public function unlock(Request $request)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Hanya Super Admin yang dapat membuka kunci!');
        }

        $validated = $request->validate([
            'week_number' => 'required|integer|min:1|max:53',
            'year' => 'required|integer|min:2024|max:2030',
        ]);

        $weekNumber = $validated['week_number'];
        $year = $validated['year'];

        $lock = WeeklyLock::where('week_number', $weekNumber)
            ->where('year', $year)
            ->first();

        if (!$lock) {
            return back()->with('error', 'Lock tidak ditemukan!');
        }

        DB::beginTransaction();
        try {
            $lock->update([
                'is_locked' => false,
                'unlocked_by' => auth()->id(),
                'unlocked_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', "Minggu {$weekNumber}/{$year} berhasil dibuka kembali!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuka kunci: ' . $e->getMessage());
        }
    }

    /**
     * View all locks history
     */
    public function history(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        $locks = WeeklyLock::where('year', $year)
            ->with(['lockedBy', 'unlockedBy'])
            ->orderBy('week_number', 'desc')
            ->paginate(20);

        return view('weekly-locks.history', compact('locks', 'year'));
    }
}
