<?php

namespace App\Http\Controllers\admin;

use App\Models\machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tools;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tools::latest()->get();
        return view('admin.tool.index')->with('tool', $tools);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tool.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tool_name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'size' => ['required', 'regex:/^[0-9]+$/'],
            'tool_code' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'status' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
        ], [
            'name.required' => 'Nama tools wajib diisi',
            'name.regex' => 'Nama tools hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'name.required' => 'Size tools wajib diisi',
            'name.regex' => 'Size tools hanya boleh berisi  angka',
            'machine_code.required' => 'Kode tools wajib diisi',
            'machine_code.regex' => 'Kode tools hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'status.required' => 'Status wajib diisi',
            'status.regex' => 'Status hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'tool_name' => $request->tool_name,
            'size' => $request->size,
            'tool_code' => $request->tool_code,
            'status' => $request->status
        ];

        Tools::create($data);
        return redirect('tool')->with('success', 'Berhasil menambahkan data alat');
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
        $data = tools::where('id', $id)->first();
        return view('admin.tool.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'tool_name' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'size' => ['required', 'regex:/^[0-9]+$/'],
            'tool_code' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
            'status' => ['required', 'regex:/^[\pL\s\-0-9]+$/u'],
        ], [
            'name.required' => 'Nama tools wajib diisi',
            'name.regex' => 'Nama tools hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'name.required' => 'Size tools wajib diisi',
            'name.regex' => 'Size tools hanya boleh berisi  angka',
            'machine_code.required' => 'Kode tools wajib diisi',
            'machine_code.regex' => 'Kode tools hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
            'status.required' => 'Status wajib diisi',
            'status.regex' => 'Status hanya boleh berisi huruf, angka, spasi, dan tanda hubung',
        ]);


        $data = [
            'tool_name' => $request->tool_name,
            'size' => $request->size,
            'tool_code' => $request->tool_code,
            'status' => $request->status
        ];
        tools::where('id', $id)->update($data);
        return redirect('tool')->with('success', 'Berhasil mengupdate data alat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        tools::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus data alat');
    }
}
