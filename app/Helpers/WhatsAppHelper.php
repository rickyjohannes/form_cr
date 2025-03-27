<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsAppHelper
{
    public static function sendWhatsAppNotification($phoneNumber, $message)
    {
        $token = env('FONNTE_API_KEY'); // Simpan token di .env
        $url = "https://api.fonnte.com/send";

        $response = Http::withHeaders([
            "Authorization" => $token
        ])->post($url, [
            "target" => $phoneNumber, // Nomor tujuan (format internasional tanpa +)
            "message" => $message,
            "countryCode" => "62", // Kode negara, default Indonesia
        ]);

        return $response->json();
    }
}
