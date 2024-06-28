<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proses;
use App\Models\SubProses;

class SubProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
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
            'holder' => $request->holder
        ];

        subproses::create($data);
        return back()->with('success', 'Berhasil menambahkan data Sub-Proses');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proses = proses::where('id', $id)->first();
        $subproses = subproses::where('proses_id', $proses->id)->get();
        return view('admin.subproses.index')->with('proses', $proses)->with('subproses', $subproses);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
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
            'holder' => $request->holder
        ];

        subproses::find($id)->update($data);
        return back()->with('success', 'Berhasil mengubah data Sub-Proses');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        subproses::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus data sub-Proses');
    }
}