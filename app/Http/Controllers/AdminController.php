<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelatihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index() {
        $user = Admin::find(Auth::guard('admin')->id());
        $today = date("Y-m-d");
        $jumlah = 0;
        $pelatihan = DB::table('pelatihan')->orderBy('batas_pendaftaran', 'desc')->orderBy('id', 'desc')->limit(5)->get();
        foreach ($pelatihan as $item) {
            $daftar = Carbon::parse($item->mulai_pendaftaran)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
            $item->mulai_pendaftaran = $daftar;
            $batas = Carbon::parse($item->batas_pendaftaran)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
            $item->batas_pendaftaran = $batas;
        }
        
        $all_pelatihan = Pelatihan::all();
        foreach ($all_pelatihan as $item) {
            $jumlah += $item->jumlah_pendaftar;
        }

        $validasi = DB::table('dosen')->where('is_berkas_submited', 1)->orderBy('updated_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', [
            'user' => $user,
            'pelatihan' => $pelatihan,
            'today' => $today,
            'jumlah_pendaftar' => $jumlah,
            'peserta_validasi' => $validasi,
        ]);
    }

    public function ShowTambahAdmin()
    {
        $user = Admin::find(Auth::guard('admin')->id());

        return view('admin.tambah_admin', [
            'user' => $user,
        ]);
    }

    public function TambahAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admin',
            'nama' => 'required',
            'password' => [
                'required', 
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ]);

        $admin = new Admin();
        $admin->name = $request->nama;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = "staff";
        $admin->save();

        session()->flash('message', 'Berhasil menambahkan admin baru');
        return to_route('tambah_admin');
    }
}
