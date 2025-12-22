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
            Instruksi Analisis Penjualan:
            Berdasarkan data yang diberikan di bawah ini, buatlah ringkasan insight dengan elemen-elemen yang jelas dan mudah dipahami:

            Data Penjualan:

            Filter: {$data['filter']}
            Total Produk Terjual: {$data['product_sold']}
            Total Pendapatan: Rp " . number_format($data['revenue'], 0, ',', '.') . "

            Produk Paling Laris:
            Nama: {$data['favorite_product']['nama']}
            Jumlah Terjual: {$data['favorite_product']['jumlah']}

            Produk Paling Sedikit Terjual:
            Nama: {$data['least_product']['nama']}
            Jumlah Terjual: {$data['least_product']['jumlah']}

            Data Donut Chart (Penjualan Tiap Produk):
            " . json_encode($data['donut'], JSON_PRETTY_PRINT) . "

            Data Bar Chart (Penjualan per Periode):
            " . json_encode($data['bar'], JSON_PRETTY_PRINT) . "

            Insight yang Diharapkan:
            Ringkasan Tren Penjualan:
            Apakah penjualan mengalami kenaikan atau penurunan?
            Bagaimana tren produk yang terlaris dan produk yang paling sedikit terjual dalam periode waktu tertentu?

            Analisis Berdasarkan Data:
            Produk Paling Laris: Mengapa produk ini lebih laku dibandingkan yang lain? Apa faktor yang memengaruhi? (misalnya, promosi, musim, dll.)
            Produk Paling Sedikit Terjual: Apa yang menyebabkan produk ini kurang diminati? Apa yang bisa diperbaiki untuk produk ini?

            Saran Strategi:
            Berdasarkan data, beri saran konkret tentang bagaimana meningkatkan penjualan produk yang kurang laku dan bagaimana menjaga kinerja produk yang laris.
            Pertimbangkan aspek seperti promosi, perubahan harga, atau perubahan dalam cara pemasaran.
            Buat saran yang realistis dan dapat diimplementasikan dalam waktu dekat.
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
