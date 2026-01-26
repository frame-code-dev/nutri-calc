<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchoolCalendarController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display calendar for a school
     */
    public function index(Request $request)
    {
        // Get school based on user role
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Get week and year from request or use next week
        $startDate = $request->get('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->addWeek()->startOfWeek(Carbon::MONDAY);
        
        // Always snap to the Monday of that week
        $startOfWeek = $startDate->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $startOfWeek->copy()->addDays(5); // Saturday
        
        $weekNumber = $startOfWeek->isoWeek;
        $year = $startOfWeek->isoWeekYear(); // Use ISO year for week consistency
        
        $school = School::where('is_active', true)->first();
        if ($request->school_id) {
            $school = School::find($request->school_id) ?? $school;
        }

        if ($user->hasRole('Koordinator Sekolah')) {
            // Get coordinator's school
            $coordinator = $user->schoolCoordinator;
            if (!$coordinator) {
                abort(403, 'Anda belum terdaftar sebagai koordinator sekolah.');
            }
            $school = $coordinator->school;

            // Get calendars for this week for this specific school
            $calendars = SchoolCalendar::with('menu')
                ->where('school_id', $school->id)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->orderBy('date')
                ->get();

            // Calendars for this week for this specific school
            $weekDates = [];
            for ($i = 0; $i < 6; $i++) { // Mon-Sat
                $date = $startOfWeek->copy()->addDays($i);
                $calendar = $calendars->first(fn($c) => $c->date->toDateString() === $date->toDateString());
                $weekDates[] = [
                    'date' => $date,
                    'calendar' => $calendar,
                ];
            }

            // Check completion status
            $completionStatus = [
                'filled' => $calendars->count(),
                'total' => 6,
                'percentage' => ($calendars->count() / 6) * 100,
                'is_complete' => $calendars->count() >= 6,
            ];

            // Check if locked
            $isLocked = \App\Models\SchoolWeeklyStatus::where('school_id', $school->id)
                ->where('week', $weekNumber)
                ->where('year', $year)
                ->where('is_locked', true)
                ->exists();

            $menus = \App\Models\Menu::where('is_active', true)->orderBy('name')->get();

            return view('calendars.index', compact(
                'school',
                'weekNumber',
                'year',
                'weekDates',
                'completionStatus',
                'isLocked',
                'menus',
                'startOfWeek',
                'endOfWeek'
            ));
        } else {
            // Admin/Super Admin view all schools
            $schools = School::with(['coordinator', 'weeklyStatuses' => function($query) use ($weekNumber, $year) {
                $query->where('week', $weekNumber)->where('year', $year);
            }])->where('is_active', true)->orderBy('name')->get();


            // Fetch generic menu schedule for the week
            $menuSchedules = \App\Models\MenuSchedule::whereBetween('date', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])->with('menu')->get()->keyBy(function($m) {
                return $m->date->toDateString();
            });

            // Fetch calendars for all schools in this week
            $allCalendars = SchoolCalendar::whereBetween('date', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])->get()->groupBy('school_id');

            $weekDays = [];
            for ($i = 0; $i < 6; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $menu = $menuSchedules->get($date->toDateString());
                $weekDays[] = [
                    'date' => $date,
                    'menu' => $menu?->menu
                ];
            }

            $currentYear = $year;
            return view('calendars.index', compact(
                'schools',
                'weekNumber',
                'year',
                'weekDays',
                'allCalendars',
                'school',
                'startOfWeek',
                'endOfWeek',
                'currentYear'
            ));
        }
    }

    /**
     * Show the form for creating/editing weekly calendar
     */
    public function editWeek(Request $request)
    {
        $user = auth()->user();
        
        // Validation: Only Coordinators can fill schedule
        if (!$user->hasRole('Koordinator Sekolah')) {
            abort(403, 'Hanya Koordinator Sekolah yang dapat mengisi jadwal.');
        }

        $coordinator = $user->schoolCoordinator;
        if (!$coordinator) {
            abort(403, 'Anda belum terdaftar sebagai koordinator sekolah.');
        }
        $school = $coordinator->school;

        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Check if week is locked
        $isLocked = \App\Models\SchoolWeeklyStatus::where('school_id', $school->id)
            ->where('week', $weekNumber)
            ->where('year', $year)
            ->where('is_locked', true)
            ->exists();

        if ($isLocked) {
            return redirect()->route('calendars.index', [
                'school_id' => $school->id,
                'week' => $weekNumber,
                'year' => $year,
            ])->with('error', 'Minggu ini sudah dikunci oleh admin! Anda tidak dapat mengubah data.');
        }

        // Generate week dates
        $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek(Carbon::MONDAY);
        $weekDates = [];
        
        for ($i = 0; $i < 6; $i++) { // Mon-Sat
            $date = $startOfWeek->copy()->addDays($i);
            $calendar = SchoolCalendar::where('school_id', $school->id)
                ->where('date', $date->toDateString())
                ->first();
            
            $weekDates[] = [
                'date' => $date,
                'calendar' => $calendar,
            ];
        }

        $schools = School::where('is_active', true)->orderBy('name')->get();

        return view('calendars.edit-week', compact(
            'school',
            'schools',
            'weekNumber',
            'year',
            'weekDates'
        ));
    }

    /**
     * Save weekly calendar data
     */
    public function saveWeek(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('Koordinator Sekolah')) {
            abort(403, 'Hanya Koordinator Sekolah yang dapat menyimpan jadwal.');
        }

        $coordinator = $user->schoolCoordinator;
        if (!$coordinator) {
            abort(403, 'Anda belum terdaftar sebagai koordinator sekolah.');
        }

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'week' => 'required|integer',
            'year' => 'required|integer',
            'dates' => 'required|array',
            'dates.*.date' => 'required|date',
            'dates.*.day_status' => 'required|in:receive,holiday',
        ]);

        if ($request->school_id != $coordinator->school_id) {
            abort(403, 'Anda tidak memiliki akses ke sekolah ini.');
        }

        $school = $coordinator->school;
        $weekNumber = $request->week;
        $year = $request->year;

        // Check if locked using SchoolWeeklyStatus
        $isLocked = \App\Models\SchoolWeeklyStatus::where('school_id', $school->id)
            ->where('week', $weekNumber)
            ->where('year', $year)
            ->where('is_locked', true)
            ->exists();

        if ($isLocked) {
            return back()->with('error', 'Minggu ini sudah dikunci oleh Admin MBG!');
        }

        foreach ($request->dates as $item) {
            // Pull menu assignment from global MenuSchedule (Siklus Menu)
            $globalMenu = \App\Models\MenuSchedule::where('date', $item['date'])->first();

            SchoolCalendar::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'date' => $item['date'],
                ],
                [
                    'week_number' => $weekNumber,
                    'year' => $year,
                    'day_status' => $item['day_status'],
                    'portion_count' => $item['day_status'] === 'receive' ? $school->student_count : 0,
                    'small_portion_count' => $item['day_status'] === 'receive' ? $school->small_portion_count : 0,
                    'large_portion_count' => $item['day_status'] === 'receive' ? $school->large_portion_count : 0,
                    'menu_id' => $globalMenu ? $globalMenu->menu_id : null,
                ]
            );
        }

        return redirect()->route('calendars.index', [
            'school_id' => $school->id,
            'week' => $weekNumber,
            'year' => $year,
        ])->with('success', 'Jadwal mingguan berhasil disimpan.');
    }

    /**
     * Update individual school status for a date (Admin Only)
     */
    public function updateStatus(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin MBG'])) {
            abort(403);
        }

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'date' => 'required|date',
            'day_status' => 'required|in:receive,holiday,delete',
        ]);

        $school = School::findOrFail($request->school_id);
        $date = Carbon::parse($request->date);
        $weekNumber = $date->isoWeek;
        $year = $date->year;

        if ($request->day_status === 'delete') {
            SchoolCalendar::where('school_id', $school->id)
                ->where('date', $date->toDateString())
                ->delete();
            
            return back()->with('success', 'Status jadwal berhasil dihapus.');
        }

        // Pull menu from global schedule
        $globalMenu = \App\Models\MenuSchedule::where('date', $date->toDateString())->first();

        SchoolCalendar::updateOrCreate(
            [
                'school_id' => $school->id,
                'date' => $date->toDateString(),
            ],
            [
                'week_number' => $weekNumber,
                'year' => $year,
                'day_status' => $request->day_status,
                'portion_count' => $request->day_status === 'receive' ? $school->student_count : 0,
                'small_portion_count' => $request->day_status === 'receive' ? $school->small_portion_count : 0,
                'large_portion_count' => $request->day_status === 'receive' ? $school->large_portion_count : 0,
                'menu_id' => $globalMenu ? $globalMenu->menu_id : null,
            ]
        );

        return back()->with('success', 'Status jadwal berhasil diperbarui.');
    }

    /**
     * Bulk update status for all schools for a date (Admin Only)
     */
    public function bulkUpdateStatus(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin MBG'])) {
            abort(403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'day_status' => 'required|in:receive,holiday',
        ]);

        $date = Carbon::parse($request->date);
        $weekNumber = $date->isoWeek;
        $year = $date->year;

        $schools = School::where('is_active', true)->get();
        $globalMenu = \App\Models\MenuSchedule::where('date', $date->toDateString())->first();

        foreach ($schools as $school) {
            SchoolCalendar::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'date' => $date->toDateString(),
                ],
                [
                    'week_number' => $weekNumber,
                    'year' => $year,
                    'day_status' => $request->day_status,
                    'portion_count' => $request->day_status === 'receive' ? $school->student_count : 0,
                    'small_portion_count' => $request->day_status === 'receive' ? $school->small_portion_count : 0,
                    'large_portion_count' => $request->day_status === 'receive' ? $school->large_portion_count : 0,
                    'menu_id' => $globalMenu ? $globalMenu->menu_id : null,
                ]
            );
        }

        return back()->with('success', 'Status jadwal massal berhasil diperbarui.');
    }

    /**
     * Delete a calendar entry
     */
    public function destroy(SchoolCalendar $calendar)
    {
        if (!auth()->user()->hasRole('Koordinator Sekolah')) {
            abort(403, 'Hanya Koordinator Sekolah yang dapat menghapus jadwal.');
        }

        // Check if locked
        $schoolId = $calendar->school_id;
        $weekNumber = $calendar->week_number;
        $year = $calendar->year;

        $isLocked = \App\Models\SchoolWeeklyStatus::where('school_id', $schoolId)
            ->where('week', $weekNumber)
            ->where('year', $year)
            ->where('is_locked', true)
            ->exists();

        if ($isLocked) {
            return back()->with('error', 'Minggu ini sudah dikunci, tidak bisa menghapus!');
        }

        $calendar->delete();

        return back()->with('success', 'Data kalender berhasil dihapus!');
    }

    /**
     * Send production notification manually (H-1)
     */
    public function sendNotification(Request $request)
    {
        // Only Admin/Koordinator can trigger
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin MBG', 'Koordinator Sekolah'])) {
            abort(403);
        }

        // Default to tomorrow if no date specified
        $date = $request->get('date', Carbon::tomorrow()->toDateString());

        // Dispatch job
        \App\Jobs\SendProductionNotifications::dispatch($date);

        return back()->with('success', 'Notifikasi produksi H-1 sedang diproses untuk dikirim.');
    }
}
