<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\WeeklyLock;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\SchoolWeeklyStatus;

class WeeklyMonitoringController extends Controller
{
    /**
     * Display weekly monitoring dashboard
     */
    public function index(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Get all schools
        $schools = School::with(['coordinator.user'])->where('is_active', true)->orderBy('name')->get();

        // Get calendars for this week
        $calendars = SchoolCalendar::where('week_number', $weekNumber)
            ->where('year', $year)
            ->get()
            ->groupBy('school_id');
            
        // Get Lock Statuses
        $lockStatuses = SchoolWeeklyStatus::where('week', $weekNumber)
            ->where('year', $year)
            ->get()
            ->keyBy('school_id');

        $monitoringData = $schools->map(function ($school) use ($calendars, $lockStatuses) {
            $schoolCalendars = $calendars->get($school->id, collect());
            $filledDays = $schoolCalendars->count();
            $lockStatus = $lockStatuses->get($school->id);
            return [
                'school' => $school,
                'filled_days' => $filledDays,
                'is_complete' => $filledDays >= 6,
                'status' => $schoolCalendars->first()?->day_status ?? 'pending',
                'coordinator_phone' => $school->coordinator?->user->phone ?? '-',
                'coordinator_name' => $school->coordinator?->user->name ?? 'Belum ada koordinator',
                'is_locked' => $lockStatus ? $lockStatus->is_locked : false,
            ];
        });

        return view('monitoring.index', compact('monitoringData', 'weekNumber', 'year'));
    }

    /**
     * Lock specific school for the week
     */
    public function lockSchool(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'week' => 'required|integer',
            'year' => 'required|integer',
        ]);

        SchoolWeeklyStatus::updateOrCreate(
            [
                'school_id' => $request->school_id,
                'week' => $request->week,
                'year' => $request->year,
            ],
            [
                'is_locked' => true,
                'locked_at' => now(),
                'locked_by' => auth()->id(),
            ]
        );

        return back()->with('success', 'Sekolah berhasil dikunci.');
    }

    /**
     * Unlock specific school for the week
     */
    public function unlockSchool(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'week' => 'required|integer',
            'year' => 'required|integer',
        ]);

        SchoolWeeklyStatus::updateOrCreate(
            [
                'school_id' => $request->school_id,
                'week' => $request->week,
                'year' => $request->year,
            ],
            [
                'is_locked' => false,
                'locked_at' => null,
                'locked_by' => null,
            ]
        );

        return back()->with('success', 'Kunci sekolah dibuka.');
    }

    /**
     * Send WA Reminder (Redirect to WA API)
     */
    public function waReminder(School $school, $week)
    {
        // Get coordinator phone
        // Assuming relationship: School -> hasOne SchoolCoordinator -> belongsTo User
        // User has 'phone' field (added in recent migration)
        $phone = $school->coordinator?->user->phone;
        
        if (!$phone) {
            return back()->with('error', 'Nomor telepon koordinator tidak tersedia.');
        }

        // Format phone (replace 08 with 628)
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $message = "Halo Koordinator {$school->name}, mohon segera lengkapi status katering MBG untuk Minggu ke-{$week}. Terima kasih.";
        $encodedMessage = urlencode($message);
        
        $waUrl = "https://wa.me/{$phone}?text={$encodedMessage}";
        
        return redirect()->away($waUrl);
    }
}
