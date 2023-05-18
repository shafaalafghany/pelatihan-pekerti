<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelatihanController extends Controller
{
    public function ShowDaftarPelatihan()
    {
        $user = auth()->user();
        $today = date("Y-m-d");
        $pelatihan = DB::table('pelatihan')->orderBy('batas_pendaftaran', 'desc')->orderBy('id', 'desc')->get();
        foreach ($pelatihan as $item) {
            $daftar = Carbon::parse($item->mulai_pendaftaran)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
            $item->mulai_pendaftaran = $daftar;
            $batas = Carbon::parse($item->batas_pendaftaran)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
            $item->batas_pendaftaran = $batas;
        }

        return view('pelatihan.daftar_pelatihan', [
            'user' => $user,
            'pelatihan' => $pelatihan,
            'today' => $today,
        ]);
    }

    public function ShowLanjutDaftarPelatihan($id_pelatihan) {
        $user = auth()->user();
        $pelatihan = Pelatihan::find($id_pelatihan);

        if ($user->id_pelatihan > 0) {
            $message = "Anda sedang terdaftar pada " . $pelatihan->nama . ".";
            session()->flash('message', $message);
            return redirect('/dashboard');
        }

        return view('pelatihan.lanjut_daftar_pelatihan', [
            'user' => $user,
            'pelatihan' => $pelatihan,
        ]);
    }
    
    public function DaftarPelatihan(Request $request, $id_pelatihan) {
        $auth = Auth::user();
        $user = User::find($auth->id);
        $pelatihan = Pelatihan::find($id_pelatihan);
        $file_foto = "";
        $file_ktp = "";
        $file_sk_dosen = "";
        $file_sk_pekerti = "";

        if ($user->id_pelatihan > 0) {
            $message = "Anda sedang terdaftar pada " . $pelatihan->nama . ".";
            session()->flash('message', $message);
            return redirect('/dashboard');
        }

        $request->validate([
            'email' => 'required',
            'nik' => 'required',
            'nidn_nidk' => 'required',
            'fullname' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nama_instansi' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'telepon' => 'required',
            'foto_profil' => 'image|mimes:jpg,jpeg,png|max:2048',
            'ktp' => 'mimetypes:application/pdf|max:5120',
            'sk_dosen' => 'mimetypes:application/pdf|max:5120',
            'sk_pekerti' => 'mimetypes:application/pdf|max:5120',
        ]);

        if ($user->foto_profil == null) {
            $request->validate([
                'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        if ($user->berkas_ktp == null) {
            $request->validate([
                'ktp' => 'required|mimetypes:application/pdf|max:5120',
            ]);
        }

        if ($user->berkas_sk_dosen == null) {
            $request->validate([
                'sk_dosen' => 'required|mimetypes:application/pdf|max:5120',
            ]);
        }

        if ($user->berkas_sk_pekerti == null && $pelatihan->jenis_pelatihan == "aa") {
            $request->validate([
                'sk_pekerti' => 'required|mimetypes:application/pdf|max:5120',
            ]);
        }

        $user->nik = $request->nik;
        $user->nidn_nidk = $request->nidn_nidk;
        $user->fullname = $request->fullname;
        $user->gelar_depan = $request->gelar_depan;
        $user->gelar_belakang = $request->gelar_belakang;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->nama_instansi = $request->nama_instansi;
        $user->alamat = $request->alamat;
        $user->provinsi = $request->provinsi;
        $user->kota = $request->kota;
        $user->kode_pos = $request->kode_pos;
        $user->telepon = $request->telepon;
        $user->is_berkas_submited = 1;
        $user->id_pelatihan = $id_pelatihan;
        $user->status_pendaftaran = 1;

        if ($request->foto_profil) {
            $foto = $request->file('foto_profil');
            $file_foto = Str::random(16) . time() . '-' . $foto->getClientOriginalName();
            $user->foto_profil = $file_foto;
        }


        if ($request->ktp) {
            $ktp = $request->file('ktp');
            $file_ktp = Str::random(16) . time() . '-' . $ktp->getClientOriginalName();
            $user->berkas_ktp = $file_ktp;
        }

        if ($request->sk_dosen) {
            $sk_dosen = $request->file('sk_dosen');
            $file_sk_dosen = Str::random(16) . time() . '-' . $sk_dosen->getClientOriginalName();
            $user->berkas_sk_dosen = $file_sk_dosen;
        }

        if ($request->sk_pekerti) {
            $sk_pekerti = $request->file('sk_pekerti');
            $file_sk_pekerti = Str::random(16) . time() . '-' . $sk_pekerti->getClientOriginalName();
            $user->berkas_sk_pekerti = $file_sk_pekerti;
        }

        if ($user->save()) {
            if ($request->file('foto_profil')) {
                $request->file('foto_profil')->move('images/foto-profil', $file_foto);
            }

            if ($request->file('ktp')) {
                $request->file('ktp')->move('files/ktp', $file_ktp);
            }

            if ($request->file('sk_dosen')) {
                $request->file('ktp')->move('files/sk-dosen', $file_sk_dosen);
            }

            if ($request->file('sk_pekerti')) {
                $request->file('sk_pekerti')->move('files/sk-pekerti', $file_sk_pekerti);
            }

            $message = "Berhasil mendaftar ke " . $pelatihan->nama . ".";

            session()->flash('message', $message);
            return redirect('/dashboard');
        }
    }
}
