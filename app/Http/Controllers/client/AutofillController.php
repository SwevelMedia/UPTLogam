<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AutofillController extends Controller
{
    public function autofill(Request $request)
    {
        // Mendapatkan nama perusahaan dari request
        $perusahaan = $request->input('perusahaan');

        Log::info("Nama Perusahaan: " . $perusahaan);

        // Query menggunakan Eloquent untuk mencari client berdasarkan nama perusahaan
        $client = Client::where('name', $perusahaan)->first();

        // Log nilai $client untuk memeriksa apakah klien ditemukan
        Log::info("Klien: " . json_encode($client));

        // Query menggunakan Eloquent untuk mencari client berdasarkan nama perusahaan
        $client = Client::where('name', $perusahaan)->first();

        // Jika client ditemukan
        if ($client) {
            // Cek apakah ada order yang terkait dengan client
            $order = $client->order()->first();

            // Jika order ditemukan, kirimkan data client dan order sebagai respons JSON
            if ($order) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'phone' => $client->phone,
                        'address' => $client->address,
                        'order_name' => $order->order_name,
                        'material' => $order->material,
                    ]
                ]);
            } else {
                // Jika order tidak ditemukan, kirimkan respons JSON dengan data client saja
                return response()->json([
                    'success' => true,
                    'data' => [
                        'phone' => $client->phone,
                        'address' => $client->address,
                        'order_name' => $order->order_name,
                        'material' => $order->material,
                    ]
                ]);
            }
        }

        // Jika client tidak ditemukan, kirimkan respons JSON kosong
        return response()->json([
            'success' => false,
            'data' => null
        ]);
    }
}
