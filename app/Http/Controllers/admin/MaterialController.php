<?php

namespace App\Http\Controllers\admin;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Material::orderBy('id', 'desc')->get();
        return view('admin.material.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
        ], [
            'name.required' => 'Nama Material wajib diisi',
            'name.regex' => 'Nama Material hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'satuan.required' => 'Satuan wajib diisi',
            'satuan.regex' => 'Satuan hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'name' => $request->name
        ];

        material::create($data);
        return redirect('material')->with('success', 'Berhasil menambahkan data Material');
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
        $data = material::where('id', $id)->first();
        return view('admin.material.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u']
        ], [
            'name.required' => 'Nama Material wajib diisi',
            'name.regex' => 'Nama Material hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'satuan.required' => 'Satuan wajib diisi',
            'satuan.regex' => 'Satuan hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'name' => $request->name
        ];

        material::where('id', $id)->update($data);
        return redirect('material')->with('success', 'Berhasil mengupdate data Material');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        material::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus data Material');
    }
}