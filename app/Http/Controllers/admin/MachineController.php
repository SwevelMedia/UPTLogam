<?php

namespace App\Http\Controllers\admin;

use App\Models\machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proses;
use App\Models\SubProses;
use App\Models\Tools;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machine = machine::latest()->get();
        return view('admin.machine.index')->with('machine', $machine);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.machine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'machine_code' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
        ], [
            'name.required' => 'Nama Mesin wajib diisi',
            'name.regex' => 'Nama Mesin hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'machine_code.required' => 'Kode mesin wajib diisi',
            'machine_code.regex' => 'Kode mesin hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'name' => $request->name,
            'machine_code' => $request->machine_code
        ];

        machine::create($data);
        return redirect('machine')->with('success', 'Berhasil menambahkan data Mesin');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mesin = machine::find($id);
        $tools = Tools::orderBy('tool_name', 'asc')->get();

        return view('admin.machine.proses', compact('mesin', 'tools'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = machine::where('id', $id)->first();
        return view('admin.machine.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'machine_code' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
        ], [
            'name.required' => 'Nama Mesin wajib diisi',
            'name.regex' => 'Nama Mesin hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'machine_code.required' => 'Kode mesin wajib diisi',
            'machine_code.regex' => 'Kode mesin hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'name' => $request->name,
            'machine_code' => $request->machine_code
        ];
        machine::where('id', $id)->update($data);
        return redirect('machine')->with('success', 'Berhasil mengupdate data Mesin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        machine::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus data Mesin');
    }

    public function tambahProses(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ], [
            'name.required' => 'Nama Proses wajib diisi',
        ]);


        $data = [
            'name' => strip_tags($request->name),
            'machines_id' => $request->machine_id
        ];

        Proses::create($data);
        return back()->with('success', 'Berhasil menambahkan data Proses');
    }

    public function tambahSubProses(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'tool' => 'required'
        ], [
            'name.required' => 'Nama Sub-Proses wajib diisi'
        ]);


        $data = [
            'proses_id' => $request->proses_id,
            'name' => strip_tags($request->name),
            'spindle_speed' => $request->spindle_speed,
            'feedrate' => $request->feedrate,
            'stock_to_leave' => $request->stock_to_leave,
            'estimate_time' => $request->estimate_time,
            'corner_radius' => $request->corner_radius,
            'holder' => $request->holder,
            'tool' => $request->tool
        ];

        SubProses::create($data);
        return back()->with('success', 'Berhasil menambahkan data Sub-Proses');
    }

    public function editProses(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Proses::find($id)->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Data Berhasil Diupdate');
    }

    public function editSubProses(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'tool' => 'required'
        ], [
            'name.required' => 'Nama Sub-Proses wajib diisi'
        ]);


        $data = [
            'name' => strip_tags($request->name),
            'spindle_speed' => $request->spindle_speed,
            'feedrate' => $request->feedrate,
            'stock_to_leave' => $request->stock_to_leave,
            'estimate_time' => $request->estimate_time,
            'corner_radius' => $request->corner_radius,
            'holder' => $request->holder,
            'tool' => $request->tool
        ];

        SubProses::find($id)->update($data);
        return back()->with('success', 'Berhasil Update data Sub-Proses');
    }

    public function hapusSub($id)
    {
        subproses::find($id)->delete();
        return back()->with('success', 'Berhasil menghapus data sub-Proses');
    }

    public function hapusProses($id)
    {
        $proses = Proses::find($id);

        foreach ($proses->subProses as $value) {
            subproses::find($value->id)->delete();
        }

        $proses->delete();
        return back()->with('success', 'Berhasil menghapus data Proses');
    }
}
