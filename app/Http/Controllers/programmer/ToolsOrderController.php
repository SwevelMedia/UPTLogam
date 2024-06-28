<?php

namespace App\Http\Controllers\programmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ToolsOrder;
use App\Models\Order;
use App\Models\Tools;

class ToolsOrderController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel tools_order
        $toolsOrders = ToolsOrder::all();

        // Inisialisasi array kosong untuk menyimpan data yang akan ditampilkan di tampilan
        $toolsOrderWithCombinedTools = [];

        // Iterasi setiap data tools_order
        foreach ($toolsOrders as $toolsOrder) {
            // Ambil data alat berdasarkan tools_id
            $tool = Tools::findOrFail($toolsOrder->tools_id);

            // Menggabungkan nama alat dan ukuran alat
            $combinedTools = [
                'id' => $tool->id,
                'tool_name' => $tool->tool_name,
                'size' => $tool->size
            ];

            // Cek apakah order number sudah ada di dalam array $toolsOrderWithCombinedTools
            if (!isset($toolsOrderWithCombinedTools[$toolsOrder->order_number])) {
                // Jika belum, inisialisasi array kosong untuk order number tersebut
                $toolsOrderWithCombinedTools[$toolsOrder->order_number] = [];
            }

            // Tambahkan data alat yang telah digabungkan ke dalam array untuk order number yang sesuai
            $toolsOrderWithCombinedTools[$toolsOrder->order_number]['tools'][] = $combinedTools;
            $toolsOrderWithCombinedTools[$toolsOrder->order_number]['order_number'] = $toolsOrder->order_number;
        }

        // Melewatkan data yang telah diubah ke tampilan
        return view('programmer.tools.index', compact('toolsOrderWithCombinedTools'));
    }

    public function create()
    {
        $tools_order = ToolsOrder::latest()->get();
        $orders = Order::latest()->get();
        $tools = Tools::latest()->get();
        return view('programmer.tools.create', compact('tools_order', 'orders', 'tools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tools' => 'required',
            'qty' => 'required'
        ], [
            'tools.required' => 'Pilih setidaknya satu alat.',
            'qty.required' => 'Qty wajib diisi.',
        ]);

        $qty = $request->qty;
        $tools = $request->tools;
        $orderNumber = $request->order_number;

        for ($i=0; $i<$qty; $i++) {
            ToolsOrder::create([
                'tools_id' => $tools,
                'order_number' => $orderNumber
            ]);
        }

        $item = Order::where('order_number', $orderNumber)->first();

        return redirect('desain/cam/'. $item->id)->with('success', 'Berhasil menambahkan data');
    }
    public function deleteTools(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'order_number' => 'required'
        ]);

        $id = $request->id;
        $orderNumber = $request->order_number;

        $TO = ToolsOrder::where('tools_id', $id)->where('order_number', $orderNumber)->get();

        foreach ($TO as $to){
            ToolsOrder::find($to->id)->delete();
        }

        $item = Order::where('order_number', $orderNumber)->first();

        return redirect('desain/cam/'. $item->id)->with('success', 'Berhasil menambahkan data');
    }
}