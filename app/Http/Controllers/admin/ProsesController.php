<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proses;
use App\Models\machine;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proses = Proses::latest()->get();
        $machine = machine::latest()->get();
        return view('admin.proses.index')->with('proses', $proses)->with('machine',$machine);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $machine = machine::latest()->get();
        return view('admin.proses.create')->with('machine', $machine);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'machines_id' => ['required']
        ], [
            'name.required' => 'Nama Proses wajib diisi',
            'machines_id.required' => 'Mesin wajib diisi'
        ]);


        $data = [
            'name' => strip_tags($request->name),
            'machines_id' => $request->machines_id
        ];

        proses::create($data);
        return redirect('proses')->with('success', 'Berhasil menambahkan data Proses');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proses = proses::where('id', $id)->first();
        $machine = machine::latest()->get();
        return view('admin.proses.edit')->with('proses', $proses)->with('machine',$machine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'machines_id' => ['required']
        ], [
            'name.required' => 'Nama Proses wajib diisi',
            'machines_id.required' => 'Mesin wajib diisi'
        ]);


        $data = [
            'name' => strip_tags($request->name),
            'machines_id' => $request->machines_id
        ];

        proses::where('id', $id)->update($data);
        return redirect('proses')->with('success', 'Berhasil mengupdate data proses');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        proses::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus data Proses');
    }
}