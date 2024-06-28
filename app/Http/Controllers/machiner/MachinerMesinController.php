<?php

namespace App\Http\Controllers\machiner;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Schedule;
use App\Models\Order;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachinerMesinController extends Controller
{
    public function index()
    {
        return view('machiner.mesin.konfigmesin');
    }

    public function mesin()
    {
        $machines = Machine::orderBy('id')->get();

        return view('machiner.mesin.konfigmesin', compact('machines'));
    }
    public function detail($id)
    {
        $mesin = machine::whereId($id)->with('maintenance')->first();
        
        return view('machiner.mesin.detail')->with([
            'mesin' => $mesin
        ]);
    }
    public function order($id)
    {
        $order = Order::find($id);
        $jadwal = Schedule::where('order_number', $id)->first();

        if ($jadwal) {
            $jadwal->update([
                'users_id'  => auth()->user()->id,
                'start_actual'  => date('Y-m-d H:i:s')
            ]);
        }

        return view('operator.produksi.order')->with([
            'order' => $order,
            'jadwal' => $jadwal
        ]);
    }
    public function statusMesin(Request $request)
{
    Log::info('Request data: ', $request->all());

    $rules = [
        'machine_id' => 'required|integer|exists:machines,id',
        'status' => 'required|integer'
    ];

    if ($request->input('status') == 2) {
        $rules['estimasi'] = 'nullable';
        $rules['keterangan'] = 'nullable';
    } elseif ($request->input('status') != 1) {
        $rules['estimasi'] = 'required|date';
        $rules['keterangan'] = 'nullable|string';
    }

    $request->validate($rules);

    $machine = Machine::find($request->input('machine_id'));
    if ($machine) {
        if ($machine->status == 2 && $request->input('status') == 1) {
            return redirect()->back()->with('error', 'Mesin sedang digunakan, tidak dapat diubah ke status Ready.');
        }

        $maintenanceData = [
            'status' => $request->input('status')
        ];

        if ($request->input('status') != 1) {
            $maintenanceData['estimasi'] = $request->input('estimasi');
            $maintenanceData['keterangan'] = $request->input('keterangan', '');
        }

        $maintenance = Maintenance::updateOrCreate(
            ['machine_id' => $machine->id],
            $maintenanceData
        );

        $machine->update([
            'status' => $request->input('status')
        ]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    return redirect()->back()->with('error', 'Machine not found');
}
}

