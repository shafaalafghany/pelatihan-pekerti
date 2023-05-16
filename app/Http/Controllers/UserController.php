<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

  public function ShowProfil() {
    $user = Auth::user();
    return view('users.profil', ['user' => $user]);
  }
  
  public function ShowEditProfil()
  {
    $user = Auth::user();
    return view('users.edit_profil', ['user' => $user]);
  }

  public function UpdateProfil(Request $request)
  {
    $id = Auth::user();
    $user = User::find($id->id);

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
      'ktp' => 'required|mimetypes:application/pdf|max:5120',
      'sk_dosen' => 'required|mimetypes:application/pdf|max:5120',
      'sk_pekerti' => 'mimetypes:application/pdf|max:5120',
      'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $ktp = $request->file('ktp');
    $file_ktp = time() . '-' . $ktp->getClientOriginalName();

    $dosen = $request->file('sk_dosen');
    $file_dosen = time() . '-' . $dosen->getClientOriginalName();

    $foto = $request->file('foto_profil');
    $file_foto = time() . '-' . $foto->getClientOriginalName();

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
    $user->foto_profil = $file_foto;
    $user->berkas_ktp = $file_ktp;
    $user->berkas_sk_dosen = $file_dosen;

    $file_pekerti = "";
    if ($request->file('sk_pekerti')) {
      $pekerti = $request->file('sk_pekerti');
      $file_pekerti = time() . '-' . $pekerti->getClientOriginalName();
      $user->berkas_sk_pekerti = $file_pekerti;
    }

    if ($user->save()) {
      $foto->move('images/foto-profil', $file_foto);
      $ktp->move('files/ktp', $file_ktp);
      $dosen->move('files/sk-dosen', $file_dosen);
      if ($request->file('sk_pekerti')) {
        $request->file('sk_pekerti')->move('files/sk-pekerti', $file_pekerti);
      }

      session()->flash('message', 'Profil berhasil diperbarui');
      return redirect('/dashboard/profil');
    }
  }
}
