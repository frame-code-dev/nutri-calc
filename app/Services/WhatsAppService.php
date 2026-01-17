<?php

namespace App\Services;

use App\Models\NotificationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
        $this->apiUrl = config('services.fonnte.url', 'https://api.fonnte.com/send');
    }

    /**
     * Send WhatsApp message via Fonnte
     *
     * @param string $phone
     * @param string $message
     * @param string $type (reminder|production|manual)
     * @param string|null $recipientName
     * @return bool
     */
    public function sendMessage(string $phone, string $message, string $type = 'manual', ?string $recipientName = null): bool
    {
        // Clean phone number (remove + and spaces)
        $phone = $this->cleanPhoneNumber($phone);

        // Validate phone number
        if (!$this->isValidPhoneNumber($phone)) {
            $this->logNotification($phone, $recipientName, $message, $type, 'failed', 'Invalid phone number format');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62', // Indonesia
            ]);

            $responseData = $response->json();
            $success = $response->successful() && ($responseData['status'] ?? false);

            $this->logNotification(
                $phone,
                $recipientName,
                $message,
                $type,
                $success ? 'sent' : 'failed',
                json_encode($responseData)
            );

            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            $this->logNotification($phone, $recipientName, $message, $type, 'failed', $e->getMessage());
            return false;
        }
    }

    /**
     * Send reminder to school coordinator about incomplete weekly status
     *
     * @param \App\Models\SchoolCoordinator $coordinator
     * @param int $weekNumber
     * @param int $year
     * @return bool
     */
    public function sendWeeklyReminder($coordinator, int $weekNumber, int $year): bool
    {
        $message = $this->buildReminderMessage($coordinator->school->name, $weekNumber, $year);
        
        return $this->sendMessage(
            $coordinator->whatsapp_number,
            $message,
            'reminder',
            $coordinator->name
        );
    }

    /**
     * Send H-1 production notification to kitchen coordinator
     *
     * @param string $phone
     * @param string $name
     * @param array $productionData
     * @return bool
     */
    public function sendProductionNotification(string $phone, string $name, array $productionData): bool
    {
        $message = $this->buildProductionMessage($productionData);
        
        return $this->sendMessage($phone, $message, 'production', $name);
    }

    /**
     * Send custom manual message
     *
     * @param string $phone
     * @param string $name
     * @param string $message
     * @return bool
     */
    public function sendManualMessage(string $phone, string $name, string $message): bool
    {
        return $this->sendMessage($phone, $message, 'manual', $name);
    }

    /**
     * Build reminder message template
     */
    protected function buildReminderMessage(string $schoolName, int $weekNumber, int $year): string
    {
        return "🍽️ *REMINDER MBG SYSTEM*\n\n"
            . "Yth. Koordinator {$schoolName}\n\n"
            . "Mohon segera mengisi status penerimaan MBG untuk:\n"
            . "📅 Minggu ke-{$weekNumber} Tahun {$year}\n\n"
            . "Status harus lengkap (Senin-Jumat) agar dapat diproses dan dikunci oleh Admin.\n\n"
            . "Terima kasih atas kerjasamanya! 🙏\n\n"
            . "_Pesan otomatis dari Sistem MBG_";
    }

    /**
     * Build production notification message
     */
    protected function buildProductionMessage(array $data): string
    {
        $message = "🍳 *NOTIFIKASI PRODUKSI H-1*\n\n"
            . "Yth. Koordinator Dapur\n\n"
            . "Besok ({$data['date']}) produksi untuk:\n\n";

        foreach ($data['schools'] as $school) {
            $message .= "🏫 *{$school['name']}*\n";
            $message .= "   Menu: {$school['menu']}\n";
            $message .= "   Porsi: {$school['portions']}\n\n";
        }

        if (isset($data['materials'])) {
            $message .= "📦 *Kebutuhan Bahan:*\n";
            foreach ($data['materials'] as $material) {
                $message .= "• {$material['name']}: {$material['quantity']} {$material['unit']}\n";
            }
        }

        $message .= "\n_Pesan otomatis dari Sistem MBG_";

        return $message;
    }

    /**
     * Clean phone number for WhatsApp format
     */
    protected function cleanPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert 08xx to 628xx
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }

        // Add 62 if not present
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Validate Indonesian phone number
     */
    protected function isValidPhoneNumber(string $phone): bool
    {
        // Should start with 62 and have 10-13 digits total
        return preg_match('/^62\d{9,12}$/', $phone);
    }

    /**
     * Log notification to database
     */
    protected function logNotification(
        string $phone,
        ?string $recipientName,
        string $message,
        string $type,
        string $status,
        ?string $response = null
    ): void {
        NotificationLog::create([
            'recipient_phone' => $phone,
            'recipient_name' => $recipientName ?? 'Unknown',
            'message' => $message,
            'type' => $type,
            'status' => $status,
            'response' => $response,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }

    /**
     * Get notification statistics
     */
    public function getStatistics(int $days = 7): array
    {
        $startDate = now()->subDays($days);

        return [
            'total' => NotificationLog::where('created_at', '>=', $startDate)->count(),
            'sent' => NotificationLog::where('created_at', '>=', $startDate)->where('status', 'sent')->count(),
            'failed' => NotificationLog::where('created_at', '>=', $startDate)->where('status', 'failed')->count(),
            'by_type' => NotificationLog::where('created_at', '>=', $startDate)
                ->selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
        ];
    }
}
