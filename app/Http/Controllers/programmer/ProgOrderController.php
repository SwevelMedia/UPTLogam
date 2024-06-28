<?php

namespace App\Http\Controllers\programmer;

use App\Http\Controllers\Controller;
use App\Models\Gambar;
use App\Models\MachineOrder;
use App\Models\MaterialOrder;
use App\Models\OperatorProses;
use App\Models\Order;
use App\Models\ProsesOrder;
use App\Models\Schedule;
use App\Models\SubProses;
use App\Models\Tools;
use App\Models\ToolsOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgOrderController extends Controller
{
    // Controller method
    public function index()
    {
        $jadwal = Schedule::get();

        $orders = [];
        $running = [];

        if (auth()->user()->role == 'drafter') {
            $orderAll = Order::whereStatus(3)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAD' && auth()->user()->id == $item->users_id) {
                        $orders[] = $order;
                    }
                }
            }
            $runningAll = Order::where('status', 4)->get();
            foreach ($jadwal as $item) {
                foreach ($runningAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAD' && auth()->user()->id == $item->users_id) {
                        $running[] = $order;
                    }
                }
            }
            $approval = Order::where('status', 5)->where('cad_approv', 0)->orderBy('id', 'desc')->get();
            $revisi = Order::where('status', 5)->where('cad_approv', 2)->orderBy('id', 'desc')->get();
            $history = Order::whereIn('status', [5, 6, 7, 8])->where('cad_approv', 1)->orderBy('id', 'desc')->get();
        }

        if (auth()->user()->role == 'programmer') {
            $orderAll = Order::whereStatus(5)->where('cad_approv', 1)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAM' && auth()->user()->id == $item->users_id) {
                        $orders[] = $order;
                    }
                }
            }
            $runningAll = Order::where('status', 6)->get();
            foreach ($jadwal as $item) {
                foreach ($runningAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAM' && auth()->user()->id == $item->users_id) {
                        $running[] = $order;
                    }
                }
            }

            $approval = Order::where('status', 7)->where('cam_approv', 0)->orderBy('id', 'desc')->get();
            $revisi = Order::where('status', 7)->where('cam_approv', 2)->orderBy('id', 'desc')->get();
            $history = Order::whereIn('status', [7, 8])->where('cam_approv', 1)->orderBy('id', 'desc')->get();
        }
        // Pass $count to the layout
        return view('programmer.order.index')->with([
            'orders' => $orders,
            'running' => $running,
            'history' => $history,
            'approval' => $approval,
            'revisi' => $revisi
        ]);
    }


    public function detail($id)
    {
        $order = Order::whereId($id)->first();
        $jadwal = Schedule::where('order_number', $order->order_number)->whereIn('desc', ['CAD', 'CAM'])->orderBy('id', 'asc')->get();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();
        $gambarUpload = Gambar::where('order_id', $id)->where('owner', 'programmer')->get();
        $tools = Tools::orderBy('tool_name', 'asc')->get();

        // Pass $count to the layout
        return view('programmer.order.detail')->with([
            'order' => $order,
            'jadwal' => $jadwal,
            'mesin' => $mesin,
            'material' => $material,
            'gambarUpload' => $gambarUpload,
            'tools' => $tools
        ]);
    }

    public function history($id)
    {
        $order = Order::whereId($id)->first();
        $jadwal = Schedule::where('order_number', $order->order_number)->whereIn('desc', ['CAD', 'CAM'])->orderBy('id', 'asc')->get();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();
        $gambarUpload = Gambar::where('order_id', $id)->where('owner', 'programmer')->get();
        $tools = Tools::orderBy('tool_name', 'asc')->get();

        // Pass $count to the layout
        return view('programmer.order.history')->with([
            'order' => $order,
            'jadwal' => $jadwal,
            'mesin' => $mesin,
            'material' => $material,
            'gambarUpload' => $gambarUpload,
            'tools' => $tools
        ]);
    }

    public function startCad(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'CAD')->first();
        $order = Order::where('order_number', $orderNumber)->first();

        $jadwal->update([
            'users_id'  => auth()->user()->id,
            'start_actual'  => date('Y-m-d H:i:s')
        ]);
        $order->update(['status' => 4]);

        return back()->with('success', 'Start actual CAD');
    }

    public function uploadCad(Request $request)
    {
        $request->validate([
            'cad' => 'required|max:5000|mimes:pdf',
        ]);

        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'CAD')->first();
        $order = Order::where('order_number', $orderNumber)->first();

        if ($request->hasFile('cad')) {
            $file = $request->file('cad');
            $originalName = $file->getClientOriginalName();

            // Mendapatkan ekstensi file
            $ext = $file->getClientOriginalExtension();

            // Membentuk nama file yang sesuai
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $ext;
            $file->move('file/' . $orderNumber . '/', $fileName);

            Gambar::create([
                'owner' => 'drafter',
                'order_id' => $order->id,
                'path'  => $fileName
            ]);
        }

        $jadwal->update([
            'stop_actual' => date('Y-m-d H:i:s'),
            'information' => $request->input('information')
        ]);

        $order->update([
            'status' => 5
        ]);

        return redirect('prog/order')->with('success', 'Upload Desain Berhasil');
    }

    public function startCam(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'CAM')->first();
        $order = Order::where('order_number', $orderNumber)->first();

        $jadwal->update([
            'users_id'  => auth()->user()->id,
            'start_actual'  => date('Y-m-d H:i:s')
        ]);

        $order->update([
            'status' => 6
        ]);

        return back()->with('success', 'Start actual CAM');
    }

    public function cam($id)
    {
        $order = Order::find($id);
        $tools = Tools::orderBy('tool_name', 'asc')->get();
        $toolsOrder = ToolsOrder::where('order_number', $order->order_number)->orderBy('id', 'asc')->get();

        return view('programmer.order.cam', compact('order', 'tools', 'toolsOrder'));
    }


    public function uploadCam(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'CAM')->first();
        $order = Order::where('order_number', $orderNumber)->first();


        $request->validate([
            "cam" => "required",
            "proses" =>  "required|array|min:1",
        ]);

        $proses = $request->input('proses');

        $machineOrder = MachineOrder::where('order_number', $orderNumber)->get();


        foreach ($machineOrder as $key => $mo) {
            OperatorProses::create([
                'proses_name' => 'Setting',
                'urutan' => 1,
                'id_machine_order' => $mo->id,
                'waktu_mesin'   => '-'
            ]);

            for ($i = 1; $i <= $proses[$key]; $i++) {
                OperatorProses::create([
                    'proses_name' => 'Proses ' . $i,
                    'urutan' => $i + 1,
                    'id_machine_order' => $mo->id
                ]);
            }
        }

        if ($request->hasFile('cam')) {
            foreach ($request->file('cam') as $image) {
                // Mendapatkan nama file asli dengan ekstensi
                $originalName = $image->getClientOriginalName();

                // Mendapatkan ekstensi file
                $ext = $image->getClientOriginalExtension();

                // Membentuk nama file yang sesuai
                $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $ext;

                // Memindahkan file ke folder tujuan dengan nama yang diharapkan
                $image->move('file/' . $orderNumber . '/', $fileName);

                // Menyimpan data ke database
                Gambar::create([
                    'owner' => 'programmer',
                    'order_id' => $order->id,
                    'path' => $fileName
                ]);
            }
        }


        $jadwal->update([
            'stop_actual' => date('Y-m-d H:i:s'),
            'information' => $request->input('information')
        ]);

        $order->update([
            'status' => 7
        ]);

        return redirect('prog/order')->with('success', 'Upload Desain Berhasil');
    }

    public function revisi($id)
    {
        $order = Order::find($id);
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();
        $gambarUpload = Gambar::where('order_id', $id)->whereIn('owner', ['programmer', 'drafter'])->get();
        $gambarClient = Gambar::where('order_id', $id)->whereNotIn('owner', ['programmer', 'drafter'])->get();
        $gambarCad = Gambar::where('order_id', $id)->where('owner', 'drafter')->first();
        $gambarCam = Gambar::where('order_id', $id)->where('owner', 'programmer')->first();
        return view('programmer.order.revisi')->with([
            'order' => $order,
            'mesin' => $mesin,
            'material' => $material,
            'gambarUpload' => $gambarUpload,
            'gambarClient' => $gambarClient,
            'gambarCad' => $gambarCad,
            'gambarCam' => $gambarCam,
        ]);
    }

    public function submitRevisi(Request $request, $id)
    {
        $request->validate([
            'file'  => 'required|mimes:pdf'
        ]);

        $order = Order::find($id);

        $oldFile = $request->input('oldFile');
        if ($oldFile != null) {
            Storage::delete(['public/image/order/' . $oldFile]);

            $gambardb = Gambar::where('path', $oldFile)->first();
            $gambardb->delete();
        }

        if (auth()->user()->role == 'drafter') {
            $file = $request->file('file');
            $fileName = $order->order_number . '_CAD.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/order/', $fileName);

            Gambar::create([
                'owner' => 'drafter',
                'order_id' => $order->id,
                'path'  => $fileName
            ]);

            $order->update([
                'cad_approv'   => 0
            ]);
        } elseif (auth()->user()->role == 'programmer') {
            $file = $request->file('file');
            $fileName = $order->order_number . '_CAM.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/order/', $fileName);

            Gambar::create([
                'owner' => 'programmer',
                'order_id' => $order->id,
                'path'  => $fileName
            ]);

            $order->update([
                'cam_approv'   => 0
            ]);
        } else {
            abort(403);
        }

        return redirect('prog/order')->with('success', 'Upload Revisi Berhasil');
    }
}