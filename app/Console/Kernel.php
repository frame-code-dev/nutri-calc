<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send weekly reminders every Wednesday at 10:00 AM
        // Reminder for next week's status
        $schedule->job(new \App\Jobs\SendWeeklyReminders())
            ->wednesdays()
            ->at('10:00')
            ->name('weekly-reminders')
            ->onOneServer();

        // Send production notifications every day at 3:00 PM (H-1)
        // For tomorrow's production
        $schedule->job(new \App\Jobs\SendProductionNotifications())
            ->dailyAt('15:00')
            ->name('production-notifications')
            ->onOneServer();

        // Optional: Clear old notification logs (keep last 90 days)
        $schedule->call(function () {
            \App\Models\NotificationLog::where('created_at', '<', now()->subDays(90))->delete();
        })
            ->monthly()
            ->name('cleanup-old-notifications');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
