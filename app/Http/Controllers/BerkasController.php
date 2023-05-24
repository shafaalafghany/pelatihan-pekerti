<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelatihan;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BerkasController extends Controller
{
  public function ShowValidasiBerkas()
  {
    $user = Admin::find(Auth::guard('admin')->id());

    $peserta = DB::table('dosen')->select('id', 'fullname')->where('is_berkas_submited', 1)->orderBy('updated_at', 'desc')->get();
    
    return view('admin.validasi_berkas.validasi_berkas', [
      'user' => $user,
      'peserta' => $peserta,
    ]);
  }

  public function ShowValidasiBerkasDetail($id_peserta)
  {
    $user = Admin::find(Auth::guard('admin')->id());

    $peserta = User::find($id_peserta);
    $pelatihan = Pelatihan::find($peserta->id_pelatihan);

    return view('admin.validasi_berkas.validasi_berkas_detail', [
      'user' => $user,
      'peserta' => $peserta,
      'pelatihan' => $pelatihan,
    ]);
  }

  public function TerimaValidasiBerkas($id_peserta, $id_pelatihan)
  {
    $peserta = User::find($id_peserta);
    $pelatihan = Pelatihan::find($id_pelatihan);

    $peserta->is_ktp_validated = 1;
    $peserta->is_sk_dosen_validated = 1;
    $peserta->is_berkas_submited = 0;
    $peserta->status_pendaftaran = 2;

    if ($peserta->berkas_sk_pekerti != null && $pelatihan->jenis_pelatihan == "aa") {
      $peserta->is_sk_pekerti_validated = 1;
    }

    $peserta->save();

    $message = "Berkas " . $peserta->fullname . " telah berhasil divalidasi";
    session()->flash('message', $message);
    session()->flash('type', 'success');
    
    return redirect('/admin/dashboard/validasi-berkas');
  }

  public function TolakValidasiBerkas($id_peserta)
  {
    $peserta = User::find($id_peserta);
    $pelatihan = Pelatihan::find($peserta->id_pelatihan);

    $peserta->is_ktp_validated = 2;
    $peserta->is_sk_dosen_validated = 2;
    $peserta->is_berkas_submited = 0;
    $peserta->status_pendaftaran = 4;

    if ($peserta->berkas_sk_pekerti != null && $pelatihan->jenis_pelatihan == "aa") {
      $peserta->is_sk_pekerti_validated = 2;
    }

    $peserta->save();

    $message = "Berhasil menolak berkas " . $peserta->fullname . "."; 
    session()->flash('message', $message);
    session()->flash('type', 'warning');
    return redirect('/admin/dashboard/validasi-berkas');
  }
}
