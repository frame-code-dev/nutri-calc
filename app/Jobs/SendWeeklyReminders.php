<?php

namespace App\Jobs;

use App\Models\SchoolCoordinator;
use App\Models\SchoolCalendar;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWeeklyReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $weekNumber;
    protected $year;

    /**
     * Create a new job instance.
     */
    public function __construct(?int $weekNumber = null, ?int $year = null)
    {
        // Default to next week
        $nextWeek = Carbon::now()->addWeek();
        $this->weekNumber = $weekNumber ?? $nextWeek->isoWeek;
        $this->year = $year ?? $nextWeek->year;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsappService): void
    {
        Log::info("Checking weekly status for week {$this->weekNumber}/{$this->year}");

        // Get all active school coordinators
        $coordinators = SchoolCoordinator::where('is_active', true)
            ->whereHas('school', function ($query) {
                $query->where('is_active', true);
            })
            ->with('school')
            ->get();

        foreach ($coordinators as $coordinator) {
            // Check if school has completed weekly status
            $startOfWeek = Carbon::now()->setISODate($this->year, $this->weekNumber)->startOfWeek();
            
            $completedDays = SchoolCalendar::where('school_id', $coordinator->school_id)
                ->where('week_number', $this->weekNumber)
                ->where('year', $this->year)
                ->count();

            // If less than 5 days completed (Mon-Fri), send reminder
            if ($completedDays < 5) {
                Log::info("Sending reminder to {$coordinator->name} for {$coordinator->school->name}");
                
                $whatsappService->sendWeeklyReminder(
                    $coordinator,
                    $this->weekNumber,
                    $this->year
                );
            }
        }

        Log::info("Weekly reminder check completed");
    }
}
