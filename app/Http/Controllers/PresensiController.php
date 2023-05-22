<?php

namespace App\Http\Controllers;

use App\Models\DosenPresensi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller {
  public function ShowPresensi()
  {
    $user = auth()->user();

    if ($user->id_pelatihan == 0 && $user->status_pendaftaran != 3) {
      session()->flash('message', 'Anda belum terdaftar dalam pelatihan manapun');
      return redirect('/dashboard');
    }

    return view('presensi.presensi', ['user' => $user]);
  }

  public function CekPresensi(Request $request)
  {
    $request->validate([
      'kode_presensi' => 'required|string',
    ]);

    $user = auth()->user();
    $kode_presensi = $request->kode_presensi;
    $cek_kode = DB::table('presensi')->where('kode_presensi', $kode_presensi)->get();
    $time_now = new DateTime(Carbon::now()->toDateTimeString());

    if (count($cek_kode) == 0) {
      session()->flash('message', 'Kode presensi salah');
      session()->flash('type', 'danger');
      return to_route('presensi');
    }

    $time_presence = new DateTime($cek_kode[0]->batas_presensi);
    if ($time_now > $time_presence) {
      session()->flash('message', 'Waktu presensi telah melewati batas waktu');
      session()->flash('type', 'danger');
      return to_route('presensi');
    }
    
    $cek_presensi = DB::table('dosen_presensi')->where('id_dosen', $user->id)->where('id_sesi', $cek_kode[0]->id_sesi)->get();
    if (count($cek_presensi) > 0) {
      session()->flash('message', 'Anda telah melakukan presensi sebelumnya');
      return to_route('presensi');
    }
    
    $dosen_presensi = new DosenPresensi();
    $dosen_presensi->id_dosen = $user->id;
    $dosen_presensi->id_sesi = $cek_kode[0]->id_sesi;
    $dosen_presensi->save();
    
    session()->flash('message', 'Berhasil melakukan presensi');
    return to_route('dashboard');
  }
}
