<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Tools;
use App\Models\Gambar;
use App\Models\Schedule;
use App\Models\MachineOrder;
use Illuminate\Http\Request;
use App\Models\MaterialOrder;
use Illuminate\Validation\Rule;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\karyawan\UpdateKaryawanRequest;
use App\Models\Machine;
use App\Models\Material;

class HomeController extends Controller
{
    public function index(LoginRequest $request)
    {
        $user = $request->user();

        // Memeriksa jika peran pengguna adalah admin
        if ($user->role === 'admin') {
            // Redirect ke dashboard admin
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } elseif ($user->role === 'ppic') {
            return redirect()->intended(RouteServiceProvider::PPIC);
        } elseif ($user->role === 'programmer') {
            return redirect()->intended(RouteServiceProvider::PROG);
        } elseif ($user->role === 'toolman') {
            return redirect()->intended(RouteServiceProvider::TOOLMAN);
        } elseif ($user->role === 'operator') {
            return redirect()->intended(RouteServiceProvider::OPERATOR);
        } elseif ($user->role === 'machiner') {
            return redirect()->intended(RouteServiceProvider::MACHINER);
        } else {
            return 'Maaf anda tidak memiliki akses!';
        }
    }

    public function dashboard()
    {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($role === 'ppic') {
            return redirect('/ppic/dashboard');
        } elseif ($role === 'programmer') {
            return redirect('/prog/dashboard');
        } elseif ($role === 'drafter') {
            return redirect('/prog/dashboard');
        } elseif ($role === 'toolman') {
            return redirect('/toolman/dashboard');
        } elseif ($role === 'operator') {
            return redirect('/operator/dashboard');
        } elseif ($role === 'machiner') {
            return redirect('/machiner/dashboard');
        } else {
            return 'Maaf anda tidak memiliki akses!';
        }
    }

    public function profile($id)
    {
        $data = User::where('id', $id)->first();
        return view('profile.edit')->with('data', $data);
    }

    public function profileUpdate(UpdateKaryawanRequest $request, string $id)
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
        return back()->with('success', 'Update Profil Berhasil');
    }

    public function ppUpdate(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,JPEG,PNG,JPG,GIF,SVG,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/profile/', $fileName);

            if (basename($request->oldPhoto) != null) {
                Storage::delete(['public/image/profile/' . basename($request->oldPhoto)]);
            }
        }

        User::find($id)->update([
            'photo' => $fileName
        ]);
        return back()->with('success', 'Foto profil berhail di update');
    }
    public function halaman_scan()
    {
        return view('scan');
    }

    public function scan(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = Order::where('order_number', $orderNumber)->first();
        $id = Order::where('order_number', $orderNumber)->first();


        // jika programmer akan langsung start cad jika belum
        $cad = Schedule::where('order_number', $orderNumber)->where('desc', 'CAD')->first();
        if (auth()->user()->role == 'ppic' || auth()->user()->role == 'admin') {
            return redirect('/order/' . $id->id);
        }
        if ($cad->desc == 'CAD' && auth()->user()->role == 'drafter') {
            if ($cad->start_actual == null && $cad->users_id == auth()->user()->id) {
                $order->update(['status' => 4]);
                Schedule::find($cad->id)->update([
                    'start_actual'  => date('d/m/Y')
                ]);
                return redirect('/order/' . $id->id)->with('success', 'Start actual CAD');
            }
            if ($cad->start_actual == null && $cad->users_id != auth()->user()->id) {
                return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
            }

            if ($order->status == 4) {
                if ($cad->users_id == auth()->user()->id) {
                    return redirect('/order/' . $id->id)->with('warning', 'CAD sudah pernah di start silahkan upload file');
                } else {
                    return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
                }
            }
        }
        if ($order->status > 4 && auth()->user()->role == 'drafter') {
            return redirect('/order/' . $id->id)->with('warning', 'Proyek ini sudah pernah di kerjakan ');
        }

        //start cam jika proggramer dan sudah selesai cad
        $cam = Schedule::where('order_number', $orderNumber)->where('desc', 'CAM')->first();
        if ($cam->desc == 'CAM' && auth()->user()->role == 'programmer' && $order->status > 4) {
            if ($cam->start_actual == null && $cam->users_id == auth()->user()->id) {
                Schedule::find($cam->id)->update([
                    'start_actual'  => date('d/m/Y')
                ]);
                return redirect('/order/' . $id->id)->with('success', 'Start actual CAM');
            }
            if ($cam->start_actual == null && $cam->users_id != auth()->user()->id) {
                return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
            }
            if ($cam->stop_actual == null) {
                if ($cam->users_id == auth()->user()->id) {
                    return redirect('/order/' . $id->id)->with('warning', 'CAM sudah pernah di start silahkan upload file');
                } else {
                    return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
                }
            }
            return redirect('/order/' . $id->id)->with('warning', 'Pesanan ini sudah di kerjakan silahkan kerjakan pesanan lainnya');
        }
        if ($cam->desc == 'CAM' && auth()->user()->role == 'programmer' && $order->status < 5) {
            return redirect('/order/' . $id->id)->with('warning', 'Pesanan ini baru sampai pembuatan CAD');
        }


        // jika belum sampai tahap toolman tapi sudah di scan
        if (auth()->user()->role == 'toolman' && $order->status < 6) {
            return redirect('/order/' . $id->id)->with('warning', 'Pesanan ini belum sampai di bagian anda');
        }

        // start toolman
        $tools = Schedule::where('order_number', $orderNumber)->where('desc', 'TOOLS')->first();
        if (auth()->user()->role == 'toolman' && $order->status > 5) {
            if ($tools->start_actual == null && $tools->users_id == auth()->user()->id) {
                $tools->update([
                    'start_actual'  => date('d/m/Y')
                ]);
                return redirect('/order/' . $id->id)->with('success', 'Mulai Penyiapan Alat');
            }
            if ($tools->start_actual == null && $tools->users_id != auth()->user()->id) {
                return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
            }
            if ($tools->stop_actual == null) {
                if ($tools->users_id == auth()->user()->id) {
                    return redirect('/order/' . $id->id)->with('warning', 'TOOLS sudah pernah di start silahkan upload file');
                } else {
                    return redirect('/order/' . $id->id)->with('warning', 'Proyek ini bukan pekerjaan anda');
                }
            }
            return redirect('/order/' . $id->id)->with('warning', 'Pesanan ini sudah di kerjakan silahkan kerjakan pesanan lainnya');
        }
        if (auth()->user()->role == 'operator' && $order->status < 8) {
            return redirect('/order/' . $id->id)->with('warning', 'Pesanan ini belum sampai di bagian anda');
        }

        $produksi = Schedule::where('order_number', $orderNumber)->whereNotIn('desc', ['TOOLS', 'CAD', 'CAM'])->get();

        // return $produksi;
        foreach ($produksi as $proses) {
            if ($proses->start_actual == null && auth()->user()->role == 'operator') {
                $proses->update([
                    'users_id'  => auth()->user()->id,
                    'start_actual'  => date('d/m/Y')
                ]);
                return redirect('/order/' . $id->id)->with('success', 'Mulai proses produksi');
            }
            if ($proses->stop_actual == null && auth()->user()->role == 'operator') {
                if ($proses->users_id == auth()->user()->id) {
                    return redirect('/order/' . $id->id)->with('warning', 'Proses sudah dimulai sebelumnya klik selesai jika sudah selesai');
                } else {
                    return redirect('/order/' . $id->id)->with('warning', 'Proses produksi sedan di jalankan oleh operator lain');
                }
            }
        }
    }

    public function procAction(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->get();
        $order = Order::where('order_number', $orderNumber)->first();

        foreach ($jadwal as $value) {
            if ($value->desc == 'CAD') {
                if ($value->start_actual == null) {
                    $order->update(['status' => 4]);
                    Schedule::find($value->id)->update([
                        'users_id'  => auth()->user()->id,
                        'start_actual'  => date('d/m/Y')
                    ]);
                    return back()->with('success', 'Start action');
                } else {
                    # code...
                }
            } else {
                # code...
            }
        }
    }

    public function detail($id)
    {
        $order = order::whereId($id)->first();
        $jadwal = Schedule::where('order_number', $order->order_number)->whereIn('desc', ['CAD', 'CAM', 'TOOLS'])->orderBy('id', 'asc')->get();
        $jadwalProduksi = Schedule::where('order_number', $order->order_number)->whereNotIn('desc', ['CAD', 'CAM', 'TOOLS'])->orderBy('id', 'asc')->get();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();
        $gambarUpload = Gambar::where('order_id', $id)->whereIn('owner', ['programmer', 'drafter'])->get();
        $gambarClient = Gambar::where('order_id', $id)->whereNotIn('owner', ['programmer', 'drafter'])->get();
        $tools = Tools::orderBy('tool_name', 'asc')->get();
        $machines = Machine::all();
        $materials = Material::all();

        return view('detail')->with([
            'order' => $order,
            'jadwal' => $jadwal,
            'jadwalProduksi' => $jadwalProduksi,
            'mesin' => $mesin,
            'material' => $material,
            'gambarUpload' => $gambarUpload,
            'gambarClient' => $gambarClient,
            'tools' => $tools,
            'machines' => $machines,
            'materials' => $materials
        ]);
    }
}
