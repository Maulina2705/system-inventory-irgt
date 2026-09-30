<?php

namespace App\Services;

use App\Models\MaintenanceReport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    /**
     * Send new maintenance ticket notification to Telegram channel/group
     */
    public static function sendMaintenanceTicket(MaintenanceReport $report): bool
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (empty($botToken) || empty($chatId)) {
            Log::info('Telegram notification skipped: bot_token or chat_id not configured in services/env.');
            return false;
        }

        try {
            $asset = $report->asset;
            $assetName = $asset ? "{$asset->name} (" . ($asset->brand ?? '-') . " " . ($asset->model ?? '') . ")" : '-';
            $assetCode = $asset ? $asset->asset_code : '-';
            $location = $asset && $asset->location ? $asset->location->name : '-';
            $placement = $asset && $asset->placement ? $asset->placement->name : '-';
            $ticketUrl = url("/reports/{$report->id}");

            $text = "🚨 *NEW MAINTENANCE TICKET*\n\n"
                  . "📋 *Tiket:* `{$report->report_number}`\n"
                  . "🏷️ *Aset:* {$assetName} (`{$assetCode}`)\n"
                  . "📍 *Lokasi:* {$placement} - {$location}\n"
                  . "⚠️ *Prioritas:* *{$report->priority}*\n"
                  . "👤 *Pelapor:* {$report->reporter_name} (" . ($report->reporter_department ?? 'Umum') . ")\n"
                  . "📝 *Masalah:* {$report->title}\n"
                  . "📄 *Deskripsi:* " . \Illuminate\Support\Str::limit($report->description, 150) . "\n\n"
                  . "🔗 [Lihat Detail & Tangani Tiket]({$ticketUrl})";

            $response = Http::timeout(5)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => false,
            ]);

            if ($response->successful()) {
                Log::info("Telegram notification sent successfully for ticket {$report->report_number}");
                return true;
            }

            Log::warning("Telegram notification API returned error: " . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error("Failed to send Telegram notification: " . $e->getMessage());
            return false;
        }
    }
}
