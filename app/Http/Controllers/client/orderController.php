<?php

namespace App\Http\Controllers\client;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\Gambar;
use App\Models\Material;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class orderController extends Controller
{
    public function index()
    {
        $data = client::get();
        $material = material::get();
        return view('client.order')->with('data', $data)->with('material', $material);
    }

    public function cek_status(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $cari = Order::where('order_number', $orderNumber)->first();

        $client = client::where('id', $cari->client_id ?? 0)->first();
        $diterima = Schedule::where('order_number', $orderNumber)->first();
        $estimasidesign = Schedule::where('order_number', $orderNumber)->where('desc', 'CAM')->first();
        $estimasitools = Schedule::where('order_number', $orderNumber)->where('desc', 'TOOLS')->first();
        $estimasiproduksi = Schedule::where('order_number', $orderNumber)->whereNotIn('desc', ['CAM', 'CAD', 'TOOLS'])->first();
        $estimasiselesai = Schedule::where('order_number', $orderNumber)->orderBy('id', 'desc')->first();
        $design = Schedule::where('order_number', $orderNumber)->where('desc', 'CAM')->first();

        if ($orderNumber == null) {

            return view('client.status', [
                'orderNumber' => 1
            ]);
        }
        return view('client.status')->with(
            [
                'cari' => $cari,
                'client' => $client,
                'diterima' => $diterima,
                'estimasidesign' => $estimasidesign,
                'estimasitools' => $estimasitools,
                'estimasiproduksi' => $estimasiproduksi,
                'estimasiselesai' => $estimasiselesai,
                'design' => $design,
            ]
        );
    }
    public function order(Request $request)
    {
        // Validasi data
        $request->validate([
            'perusahaan' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'order_name' => 'required',
            'material' => 'required',
            'gambar.*' => 'mimes:jpeg,png,PNG,jpg,pdf|max:5000',
        ]);

        // Cari apakah perusahaan sudah ada di database
        $client = Client::where('name', $request->perusahaan)->first();

        if (!$client) {
            // Jika perusahaan tidak ditemukan, tambahkan perusahaan baru
            $client = Client::create([
                'name' => $request->perusahaan,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        // Generate order number
        $orderCount = Order::whereMonth('created_at', Carbon::now()->month)->count() + 1;
        $orderNumber = "ORD-" . Carbon::now()->format('ym') . sprintf("%03d", $orderCount);

        // Simpan data ke dalam tabel Order
        $order = new Order();
        $order->order_number = $orderNumber;
        $order->client_id = $client->id;
        $order->status = Order::STATUS_PENDING;

        // Assign order_name and material if provided in the request
        if ($request->filled('order_name')) {
            $order->order_name = $request->order_name;
        }
        if ($request->filled('material')) {
            $order->material = $request->material;
        }

        // Validate if order_name or material is present in the request
        if (!$order->order_name && !$order->material) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Either order name or material field is required.']);
        }

        $order->save();

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move('file/client/', $imageName);

                $gambar = new Gambar();
                $gambar->order_id = $order->id;
                $gambar->owner = $request->perusahaan;
                $gambar->path = $imageName;
                $gambar->save();
            }
        }

        return view('client.order-success', [
            'order' => Order::where('order_number', $orderNumber)->first()
        ]);
    }
    public function create($clientId)
    {
        $order = Order::where('client_id', $clientId)->first();
        return view('create_order', compact('order'));
    }


    // public function orderSuccess()
    // {

    //     return view('client.order-success', [
    //         'order' => Order::first()
    //     ]);
    // }
}