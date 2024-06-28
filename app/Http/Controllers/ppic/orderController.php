<?php

namespace App\Http\Controllers\ppic;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Material;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Gambar;
use App\Models\MachineOrder;
use App\Models\MaterialOrder;
use App\Models\OperatorProses;
use App\Models\User;
use Carbon\Carbon;

class orderController extends Controller
{
    public function index()
    {
        $running = Order::whereIn('status', [3, 4, 5, 6, 7, 8])->orderBy('id', 'desc')->get();
        $orders = Order::whereIn('status', [0, 1, 2])->orderBy('id', 'desc')->get();
        $history = Order::whereIn('status', [9, 10])->orderBy('id', 'desc')->get();
        $machines = Machine::all();
        $materials = Material::all();
        $approveCad = Order::Where('status', 5)->where('cad_approv', 0)->get();
        $approveCam = Order::Where('status', 7)->where('cam_approv', 0)->get();
        $noDesign = Order::where('need_design', 3)->where('status', 6)->get();

        return view('ppic.order.index', [
            'running' => $running,
            'machines' => $machines,
            'materials' => $materials,
            'orders' => $orders,
            'history' => $history,
            'approveCad' => $approveCad,
            'approveCam' => $approveCam,
            'noDesign' => $noDesign,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $orderId = $request->input('orderId');
        $status = $request->input('status');

        $order = Order::find($orderId);
        if (!$order) {
            return back()->withErrors('Order not found');
        }

        $order->status = $status;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Status updated successfully.');
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $gambars = $order->images;

        $data = order::where('id', $id)->first();
        return view('ppic.order.edit')->with('data', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'order_name' => 'required',
            'material' => 'required',
            'gambar.*' => 'mimes:jpeg,png,PNG,jpg,gif,svg,pdf|max:10000',
        ]);

        $client = Client::where('name', $request->perusahaan)->first();

        if (!$client) {
            $client = Client::create([
                'name' => $request->perusahaan,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        $orderCount = Order::whereMonth('created_at', Carbon::now()->month)->count() + 1;
        $orderNumber = "ORD-" . Carbon::now()->format('ym') . sprintf("%03d", $orderCount);

        $order = new Order();
        $order->order_number = $orderNumber;
        $order->client_id = $client->id;
        $order->status = Order::STATUS_PENDING;

        if ($request->filled('order_name')) {
            $order->order_name = $request->order_name;
        }
        if ($request->filled('material')) {
            $order->material = $request->material;
        }

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

        return redirect()->back()->with('success', 'Pesanan Berhasil Dibuat');
    }
    public function showOrderModal($orderId)
    {
        $machines = Machine::all();

        return view('order_modal', [
            'order_id' => $orderId,
            'machines' => $machines
        ]);
    }

    public function pilihMesin(Request $request, $id)
    {
        $request->validate([
            "mesin" =>  "required|array|min:1",
            "material" => "required",
            "status" => "required",
            "need_design" => "required"
        ]);

        $order = Order::findOrFail($id);

        $selectedMachines = $request->input('mesin');
        $status = $request->input('status');

        // Simpan data mesin ke dalam tabel machine_orders
        foreach ($selectedMachines as $machineId) {
            MachineOrder::create([
                'order_number' => $order->order_number,
                'machines_id' => $machineId,
                'status' => $status
            ]);
        }

        MaterialOrder::create([
            'order_number' => $order->order_number,
            'id_material' => $request->input('material'),
            'status' => $status
        ]);

        // Update status pesanan
        $order->update([
            'status' => $status,
            'need_design' => $request->input('need_design')
        ]);

        return redirect('order/konfirmasi/' . $id);
    }
    public function confirm($id)
    {
        $order = Order::whereId($id)->first();
        $mesin = MachineOrder::where('order_number', $order->order_number)->with('Mesin')->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->with('Material')->get();
        $karyawan = User::whereNotIn('role', ['admin', 'ppic', 'machiner', 'lainnya'])->orderBy('role', 'desc')->get();

        $allmachine = Machine::all();
        return view('ppic.order.konfirmOrder')->with([
            'order'     => $order,
            'mesin'     => $mesin,
            'material'  => $material,
            'allmachine'    => $allmachine,
            'karyawan'  => $karyawan

        ]);
    }

    public function pilihMesinAccept(Request $request, $id)
    {
        $request->validate([
            "mesin" =>  "required|array|min:1",
            "karyawan" => "required",
        ]);

        $order = Order::findOrFail($id);

        $selectedMachines = $request->input('mesin');
        $selectedKaryawan = $request->input('karyawan');

        // Simpan data mesin ke dalam tabel machine_orders

        MachineOrder::where('order_number', $order->order_number)->delete();

        foreach ($selectedMachines as $machineId) {
            MachineOrder::create([
                'order_number' => $order->order_number,
                'machines_id' => $machineId,
            ]);

            Machine::find($machineId)->update(["status" => 2]);
        }

        foreach ($selectedKaryawan as $karyawanId) {

            $kar = explode('-', $karyawanId);
            if ($kar[1] == "drafter") {
                Schedule::create([
                    'desc'      => 'CAD',
                    'users_id' => $kar[0],
                    'order_number' => $order->order_number,
                ]);
            } else if ($kar[1] == "programmer") {
                Schedule::create([
                    'desc'      => 'CAM',
                    'users_id' => $kar[0],
                    'order_number' => $order->order_number,
                ]);
            } else if ($kar[1] == "toolman") {
                Schedule::create([
                    'desc'      => 'TOOLS',
                    'users_id' => $kar[0],
                    'order_number' => $order->order_number,
                ]);
            }
        }

        $data = [
            'status' => 2
        ];

        foreach ($selectedMachines as $machineId) {
            Machine::where('id', $machineId)->update($data);
        }

        $order = Order::whereId($id)->first();
        $order->update([
            'status' => 2,
            'id_ppic' => auth()->user()->id
        ]);

        return redirect('order/jadwal/' . $id);
    }

    // public function accept($id)
    // {
    //     $order = Order::whereId($id)->first();
    //     $order->update([
    //         'status' => 2,
    //         'id_ppic' => auth()->user()->id
    //     ]);

    //     return redirect('order/jadwal/' . $id);
    // }


    public function decline($id, $massage)
    {
        $order = Order::whereId($id)->first();

        $order->update([
            'status' => 10,
            'description' => $massage
        ]);

        $redirectToWhatsApp = request()->query('redirectToWhatsApp');
        if ($redirectToWhatsApp === 'true') {
            $phoneNumber = request()->query('phoneNumber');

            // Format URL WhatsAp
            $whatsappUrl = "https://api.whatsapp.com/send?phone=62{$phoneNumber}&text={$massage}";

            return redirect($whatsappUrl);
        } else {
            return redirect()->route('order.index');
        }
    }


    public function jadwal($id)
    {
        $order = Order::findOrFail($id);
        $mesin = MachineOrder::where('order_number', $order->order_number)->with('Mesin')->get();
        return view('ppic.order.aturJadwal')->with([
            'order' => $order,
            'mesin' => $mesin
        ]);
    }

    public function submitJadwal(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();
        if ($order->need_design == 1) {
            $request->validate([
                'tool'    => 'required',
                'cam'    => 'required',
            ]);
        }

        $request->validate([
            'cad'    => 'required',
            'mesin'    => 'required',
        ]);

        if ($order->need_design == 1) {
            $tool = explode(' - ', $request->input('tool'));
            $startTool = $tool[0];
            $stopTool = $tool[1];

            $dataTool = [
                'start_plan'    => $startTool,
                'stop_plan'     => $stopTool
            ];
            Schedule::where('desc', 'TOOLS')->where('order_number', $orderNumber)->update($dataTool);


            $cam = explode(' - ', $request->input('cam'));
            $startCam = $cam[0];
            $stopCam = $cam[1];

            $dataCAM = [
                'start_plan'    => $startCam,
                'stop_plan'     => $stopCam
            ];
            Schedule::where('desc', 'CAM')->where('order_number', $orderNumber)->update($dataCAM);
        }

        $cad = explode(' - ', $request->input('cad'));
        $startCad = $cad[0];
        $stopCad = $cad[1];

        $dataCAD = [
            'start_plan'    => $startCad,
            'stop_plan'     => $stopCad
        ];
        Schedule::where('desc', 'CAD')->where('order_number', $orderNumber)->update($dataCAD);

        $descMesin = $request->input('descMesin');
        $mesin = $request->input('mesin');
        $startMesin = [];
        $stopMesin = [];
        foreach ($mesin as $val) {
            $exp = explode(' - ', $val);
            array_push($startMesin, $exp[0]);
            array_push($stopMesin, $exp[1]);
            $exp = array();
        }

        foreach ($descMesin as $key => $value) {
            Schedule::create([
                'desc'      => $value,
                'start_plan'    => $startMesin[$key],
                'stop_plan'     => $stopMesin[$key],
                'order_number'      => $orderNumber
            ]);
        }

        if ($order->need_design == 1) {
            $order->update(['status' => 3]);

            return redirect('/ppic/order')->with('success', 'Jadwal berhasil dibuat.');
        } else {

            $order->update([
                'status' => 3,

            ]);

            return redirect('/ppic/order')->with('success', 'Jadwal berhasil dibuat.');
        }
    }

    public function approveDesain($id)
    {
        $order = order::whereId($id)->first();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();
        $gambarUpload = Gambar::where('order_id', $id)->whereIn('owner', ['programmer', 'drafter'])->get();
        $gambarClient = Gambar::where('order_id', $id)->whereNotIn('owner', ['programmer', 'drafter'])->get();

        $operatorProses = 0;
        foreach ($mesin as $value) {
            $op = $value->operatorProses->count();
            $operatorProses += $op;
        }

        return view('ppic.order.approve-desain', [
            'order' => $order,
            'mesin' => $mesin,
            'material' => $material,
            'gambarUpload' => $gambarUpload,
            'gambarClient' => $gambarClient,
            'operatorProses' => $operatorProses
        ]);
    }

    public function approveCad(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order->status == 5) {
            $order->update(['cad_approv' => 1]);

            if ($order->need_design == 0) {
                foreach ($order->machineOrders as $mo) {
                    OperatorProses::create([
                        'proses_name' => 'Setting',
                        'urutan' => 1,
                        'id_machine_order' => $mo->id
                    ]);

                    OperatorProses::create([
                        'proses_name' => 'Proses 1',
                        'urutan' => 2,
                        'id_machine_order' => $mo->id
                    ]);
                }

                $order->update(['status' => 8]);
            }
        } elseif ($order->status == 7) {
            $order->update(['cam_approv' => 1]);
        }


        return back()->with('success', 'Approve Desain Berhasil');
    }

    public function approveCadBack(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order->status == 5) {
            $order->update(['cad_approv' => 0]);
        } elseif ($order->status == 7) {
            $order->update(['cam_approv' => 0]);
        }

        return back();
    }

    public function revisiCad(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order->status == 5) {
            $order->update([
                'cad_approv' => 2,
                'description' => $request->input('description')
            ]);
        } elseif ($order->status == 7) {
            $order->update([
                'cam_approv' => 2,
                'description' => $request->input('description')
            ]);
        }

        return back()->with('success', 'Revisi Desain');
    }

    public function orderDecline(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();
        $order->update([
            'status' => 10,
            'description' => $request->input('description')
        ]);

        return back();
    }

    public function approveCadBackDecline(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order->cad_approv == 1) {
            $order->update([
                'status' => 7,
                'description' => ''
            ]);
        } else {
            $order->update([
                'status' => 5,
                'description' => ''
            ]);
        }
        return back();
    }

    public function orderReport()
    {
        $history = Order::whereIn('status', [9])->orderBy('id', 'desc')->get();
        $orders = Order::whereIn('status', [0, 1, 2])->orderBy('id', 'desc')->get();
        $materials = Material::all();

        return view('ppic.report.orderReport', [
            'history' => $history,
            'orders' => $orders,
            'materials' => $materials
        ]);
    }
    public function hubungi($id, $massage)
    {
        $order = Order::whereId($id)->first();

        $redirectToWhatsApp = request()->query('redirectToWhatsApp');
        if ($redirectToWhatsApp === 'true') {
            $phoneNumber = request()->query('phoneNumber');

            // Format URL WhatsAp
            $whatsappUrl = "https://api.whatsapp.com/send?phone=62{$phoneNumber}&text={$massage}";

            return redirect($whatsappUrl);
        }
    }

    public function approveProduksi($id)
    {
        $order = order::whereId($id)->first();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();

        function timeToSeconds($time)
        {
            list($hours, $minutes, $seconds) = explode(':', $time);
            return ($hours * 3600) + ($minutes * 60) + $seconds;
        }

        // Fungsi untuk mengkonversi detik ke waktu (HH:MM:SS)
        function secondsToTime($seconds)
        {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            $seconds = $seconds % 60;
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        $waktuMesinSeconds = 0;
        $waktuOpSeconds = 0;
        foreach ($order->machineOrders as $mo) {
            foreach ($mo->operatorProses as $op) {
                if ($op->proses_name != 'Setting') {
                    $durasiMesin = $op->formatted_waktu_mesin;
                    $durasiOp = $op->formatted_Waktu_Operator;

                    $waktuMesinSeconds += timeToSeconds($durasiMesin);
                    $waktuOpSeconds += timeToSeconds($durasiOp);
                }
            }
        }

        $waktuMesin = secondsToTime($waktuMesinSeconds);
        $waktuOp = secondsToTime($waktuOpSeconds);

        return view('ppic.order.approve-produksi', [
            'order' => $order,
            'mesin' => $mesin,
            'material' => $material,
            'waktuMesin' => $waktuMesin,
            'waktuOp' => $waktuOp
        ]);
    }

    public function approveProduksiSubmit($id)
    {
        $order = Order::find($id);
        foreach ($order->machineOrders as $mo) {
            $mo->mesin->update(['status' => 1]);
        }
        $order->update(['status' => 9]);

        return back();
    }
}
