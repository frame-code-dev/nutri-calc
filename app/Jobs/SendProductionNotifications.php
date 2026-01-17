<?php

namespace App\Jobs;

use App\Models\SchoolCalendar;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendProductionNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;

    /**
     * Create a new job instance.
     */
    public function __construct(?string $date = null)
    {
        // Default to tomorrow
        $this->date = $date ?? Carbon::tomorrow()->toDateString();
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsappService): void
    {
        Log::info("Sending production notifications for {$this->date}");

        // Get all calendars for tomorrow where status is 'receive'
        $calendars = SchoolCalendar::where('date', $this->date)
            ->where('day_status', 'receive')
            ->with('school', 'menu.menuItems.rawMaterial')
            ->get();

        if ($calendars->isEmpty()) {
            Log::info("No production scheduled for {$this->date}");
            return;
        }

        // Build production data
        $schools = [];
        $materialNeeds = [];

        foreach ($calendars as $calendar) {
            $schools[] = [
                'name' => $calendar->school->name,
                'menu' => $calendar->menu->name ?? 'N/A',
                'portions' => $calendar->portion_count,
            ];

            // Calculate material needs
            if ($calendar->menu) {
                foreach ($calendar->menu->menuItems as $item) {
                    $materialId = $item->raw_material_id;
                    $needed = $item->quantity_per_portion * $calendar->portion_count;
                    
                    if (isset($materialNeeds[$materialId])) {
                        $materialNeeds[$materialId]['quantity'] += $needed;
                    } else {
                        $materialNeeds[$materialId] = [
                            'name' => $item->rawMaterial->name,
                            'quantity' => $needed,
                            'unit' => $item->rawMaterial->unit,
                        ];
                    }
                }
            }
        }

        // Prepare message data
        $productionData = [
            'date' => Carbon::parse($this->date)->isoFormat('dddd, D MMMM YYYY'),
            'schools' => $schools,
            'materials' => array_values($materialNeeds),
        ];

        // Send to all kitchen coordinators
        $kitchenCoordinators = User::role('Koordinator Dapur')->get();

        foreach ($kitchenCoordinators as $coordinator) {
            $phone = $coordinator->phone;
            
            if (!$phone) {
                Log::warning("Kitchen coordinator {$coordinator->name} has no phone number. Skipping notification.");
                continue;
            }
            
            $whatsappService->sendProductionNotification(
                $phone,
                $coordinator->name,
                $productionData
            );
            
            Log::info("Production notification sent to {$coordinator->name}");
        }

        Log::info("Production notifications completed");
    }
}
