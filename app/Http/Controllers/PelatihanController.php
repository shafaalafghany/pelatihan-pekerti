<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
            $item->daftar = $daftar;
            $batas = Carbon::parse($item->batas_pendaftaran)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
            $item->batas = $batas;
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
            $registered_pelatihan = Pelatihan::find($user->id_pelatihan);
            session()->flash('type', 'danger');
            session()->flash('message', "Anda sedang terdaftar pada " . $registered_pelatihan->nama . ".");
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
            session()->flash('message', "Anda sedang terdaftar pada " . $pelatihan->nama . ".");
            return redirect('/dashboard');
        }
        
        if ($pelatihan->jumlah_pendaftar == $pelatihan->kuota_pendaftar) {
            session()->flash('type', 'danger');
            session()->flash('message', "Kuota peserta telah penuh.");
            return redirect('/dashboard');
        }

        if (date("Y-m-d") > $pelatihan->batas_pendaftaran) {
            session()->flash('type', 'danger');
            session()->flash('message', "Waktu Pendaftaran telah melewati waktu batas pendaftaran.");
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
            $file_foto = Str::random(16) . time() . '-' . str_replace(" ", "_", $foto->getClientOriginalName());
            $user->foto_profil = $file_foto;
        }


        if ($request->ktp) {
            $ktp = $request->file('ktp');
            $file_ktp = Str::random(16) . time() . '-' . str_replace(" ", "_", $ktp->getClientOriginalName());
            $user->berkas_ktp = $file_ktp;
        }

        if ($request->sk_dosen) {
            $sk_dosen = $request->file('sk_dosen');
            $file_sk_dosen = Str::random(16) . time() . '-' . str_replace(" ", "_", $sk_dosen->getClientOriginalName());
            $user->berkas_sk_dosen = $file_sk_dosen;
        }

        if ($request->sk_pekerti) {
            $sk_pekerti = $request->file('sk_pekerti');
            $file_sk_pekerti = Str::random(16) . time() . '-' . str_replace(" ", "_", $sk_pekerti->getClientOriginalName());
            $user->berkas_sk_pekerti = $file_sk_pekerti;
        }

        $user->save();
        if ($request->file('foto_profil')) {
            $request->file('foto_profil')->move('images/foto-profil', $file_foto);
        }

        if ($request->file('ktp')) {
            $request->file('ktp')->move('files/ktp', $file_ktp);
        }

        if ($request->file('sk_dosen')) {
            $request->file('sk_dosen')->move('files/sk-dosen', $file_sk_dosen);
        }

        if ($request->file('sk_pekerti')) {
            $request->file('sk_pekerti')->move('files/sk-pekerti', $file_sk_pekerti);
        }

        session()->flash('message', "Berhasil mendaftar ke " . $pelatihan->nama . ".");
        return redirect('/dashboard');
    }

    public function AdminShowPelatihan()
    {
        $user = Admin::find(Auth::guard('admin')->id());
        $pelatihan = DB::table('pelatihan')
                    ->orderBy('batas_pendaftaran', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();

        foreach ($pelatihan as $item) {
            $split = explode(" - ", $item->tanggal_pelaksanaan);
            $item->pelaksanaan = Carbon::parse($split[0])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') . " - " . Carbon::parse($split[1])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
        }
        return view('admin.pelatihan.pelatihan', [
            'user' => $user,
            'pelatihan' => $pelatihan,
        ]);
    }

    public function AdminShowPelatihanDetail($id_pelatihan)
    {
        $user = Admin::find(Auth::guard('admin')->id());
        $pelatihan = Pelatihan::find($id_pelatihan);
        $split = explode(" - ", $pelatihan->tanggal_pelaksanaan);
        $pelatihan->pelaksanaan = Carbon::parse($split[0])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') . " - " . Carbon::parse($split[1])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
        $pelatihan->status_nilai = true;

        $peserta = DB::table('dosen_pelatihan')
                    ->select('dosen_pelatihan.id_dosen', 'dosen_pelatihan.id_pelatihan', 'dosen.*')
                    ->join('dosen', 'dosen_pelatihan.id_dosen', '=', 'dosen.id')
                    ->where('dosen.id_pelatihan', $id_pelatihan)
                    ->get();

        $nilai = DB::table('nilai')->where('id_pelatihan', $id_pelatihan)->get();

        if (count($nilai) == 0) {
            $pelatihan->status_nilai = false;
        }

        return view('admin.pelatihan.pelatihan_detail', [
            'user' => $user,
            'pelatihan' => $pelatihan,
            'peserta' => $peserta
        ]);
    }

    public function AdminBuatPelatihan()
    {
        $user = Admin::find(Auth::guard('admin')->id());

        return view('admin.pelatihan.buat_pelatihan', [
            'user' => $user,
        ]);
    }

    public function BuatPelatihan(Request $request)
    {
        $request->validate([
            'nama_pelatihan' => 'required|string',
            'jenis_pelatihan' => 'required',
            'mulai_pendaftaran' => 'required',
            'batas_pendaftaran' => 'required',
            'mulai_pelaksanaan' => 'required',
            'akhir_pelaksanaan' => 'required',
            'kuota_peserta' => 'required',
        ]);

        $check_pelatihan = DB::table('pelatihan')
                            ->where('jenis_pelatihan', $request->jenis_pelatihan)
                            ->where('is_active', 1)
                            ->get();
        if (count($check_pelatihan) > 0) {
            session()->flash('message', 'Ada pelatihan ' . strtoupper($request->jenis_pelatihan) . ' sedang aktif, silahkan nonaktifkan terlebih dahulu pelatihan tersebut sebelum membuat pelatihan baru.');
            session()->flash('type', 'danger');
            return back();
        }

        $pelatihan = new Pelatihan();
        $pelatihan->nama = $request->nama_pelatihan;
        $pelatihan->jenis_pelatihan = $request->jenis_pelatihan;
        $pelatihan->mulai_pendaftaran = $request->mulai_pendaftaran;
        $pelatihan->batas_pendaftaran = $request->batas_pendaftaran;
        $pelatihan->tanggal_pelaksanaan = $request->mulai_pelaksanaan . " - " . $request->akhir_pelaksanaan;
        $pelatihan->kuota_pendaftar = $request->kuota_peserta;
        $pelatihan->is_active = 1;

        $pelatihan->save();

        session()->flash('message', 'Berhasil membuat pelatihan baru');
        return to_route('admin_pelatihan');
    }
}
