<?php

namespace App\Helpers;

use Illuminate\Support\Facades\View;

class BladeHelper
{
    public static function renderBladeToText($view, $data = [])
    {
        // Render Blade menjadi string
        $renderedHtml = View::make($view, $data)->render();

        // Konversi hyperlink agar tetap bisa diklik di WhatsApp
        $renderedHtml = preg_replace_callback('/<a\s+href="([^"]+)".*?>(.*?)<\/a>/', function ($matches) {
            return '[' . $matches[2] . '](' . $matches[1] . ')'; // Format: [Teks](URL)
        }, $renderedHtml);

        // Hapus semua tag HTML
        $plainText = strip_tags($renderedHtml);

        // Konversi Markdown ke teks biasa untuk WhatsApp
        $plainText = preg_replace('/\*\*(.*?)\*\*/', '*$1*', $plainText); // **bold** -> *bold*
        $plainText = preg_replace('/\#(.*?)\n/', "$1\n", $plainText); // Hapus #
        $plainText = preg_replace('/\- (.*?)\n/', "- $1\n", $plainText); // Pertahankan list
        $plainText = preg_replace('/\n{2,}/', "\n", $plainText); // Kurangi spasi berlebih

        return trim($plainText);
    }
}
