<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController
{
    public function getInsight(Request $request)
    {
        $jsonData = $request->query('data');
        $data     = json_decode($jsonData, true);

        if (!$data) {
            return response()->json(['error' => 'Data tidak valid'], 400);
        }

        $prompt = "
            Analisis perkembangan penjualan berdasarkan data berikut:

            Filter digunakan: {$data['filter']}

            Total produk terjual: {$data['product_sold']}
            Total pendapatan: Rp " . number_format($data['revenue'], 0, ',', '.') . "

            Produk paling laris:
            - {$data['favorite_product']['nama']} ({$data['favorite_product']['jumlah']} terjual)

            Produk paling sedikit terjual:
            - {$data['least_product']['nama']} ({$data['least_product']['jumlah']} terjual)

            Data Donut Chart (penjualan tiap produk):
            " . json_encode($data['donut'], JSON_PRETTY_PRINT) . "

            Data Bar Chart (penjualan per periode):
            " . json_encode($data['bar'], JSON_PRETTY_PRINT) . "

            Tolong buat ringkasan insight yang:
            - sangat jelas
            - mudah dibaca
            - seolah laporan bisnis profesional
            - jelaskan tren naik/turun
            - berikan saran strategi yang realistis
        ";

        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $postData = [
            "contents" => [[
                "parts" => [[ "text" => $prompt ]]
            ]]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $result = curl_exec($ch);
        $error  = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            return response()->json([
                "error" => "Request gagal",
                "details" => $error
            ], 500);
        }

        if ($status !== 200) {
            return response()->json([
                "error" => "API Gemini mengembalikan status tidak OK",
                "status" => $status,
                "response" => json_decode($result, true)
            ], 500);
        }

        return response()->json(json_decode($result, true));
    }

}
