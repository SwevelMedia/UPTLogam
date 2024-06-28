<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\karyawan\KaryawanRequest;
use App\Http\Requests\karyawan\UpdateKaryawanRequest;
use App\Models\employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class karyawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = User::latest()->get();
        return view('admin.karyawan.index')->with('karyawan', $karyawan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KaryawanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/profile/', $fileName);

            $data['photo'] = $fileName;
        }

        User::create($data);
        return back()->with('success', 'Berhasil menambahkan data karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karyawan = User::whereId($id)->first();
        return view('admin.karyawan.show')->with('karyawan', $karyawan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::where('id', $id)->first();
        return view('admin.karyawan.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, string $id)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/profile/', $fileName);

            if (basename($request->oldPhoto) != null) {
                Storage::delete(['public/image/profile/' . basename($request->oldPhoto)]);
            }

            $data['photo'] = $fileName;
        }

        User::find($id)->update($data);
        return back()->with('success', 'Update data karyawan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empl = User::where('id', $id)->first();
        if (basename($empl->photo) != null) {
            Storage::delete(['public/image/profile/' . basename($empl->photo)]);
        }
        User::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus karyawan');
    }
}
