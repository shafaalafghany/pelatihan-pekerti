<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelatihan;
use App\Models\Sesi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SesiController extends Controller {
  public function ShowSesi()
  {
    $user = auth()->user();
    
    if ($user->id_pelatihan == 0 && $user->status_pendaftaran != 3) {
      session()->flash('message', 'Anda belum terdaftar dalam pelatihan manapun');
      return redirect('/dashboard');
    }
    
    $time_start = Carbon::now()->format('Y-m-d') . " " . "00:00:00";
    $time_end = Carbon::now()->addDay()->format('Y-m-d') . " " . "00:00:00";
    $sesi = DB::table('sesi')
            ->where('waktu_mulai', '>', $time_start)
            ->where('waktu_selesai', '<', $time_end)
            ->get();

    return view('sesi.pilih_sesi', [
      'user' => $user,
      'sesi' => $sesi,
    ]);
  }

  public function AdminShowSesi()
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = DB::table('pelatihan')->orderByDesc('created_at')->get();
    
    return view('admin.sesi.pilih_pelatihan', [
      'user' => $user,
      'pelatihan' => $pelatihan,
    ]);
  }

  public function AdminPilihPelatihan(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
    ]);

    $pelatihan = $request->pelatihan;

    if ($pelatihan == 0) {
      session()->flash('message', 'Tolong pilih pelatihan dengan benar');
      session()->flash('type', 'danger');
      return back();
    }

    return redirect('/admin/dashboard/sesi/' . $pelatihan);
  }

  public function AdminShowSesiDetail($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $sesi = DB::table('sesi')
            ->where('id_pelatihan', $id_pelatihan)
            ->get();

  foreach ($sesi as  $item) {
    $item->mulai = date("G:i", strtotime($item->waktu_mulai));
    $item->selesai = date("G:i", strtotime($item->waktu_selesai));
  }

    return view('admin.sesi.sesi', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'sesi' => $sesi,
    ]);
  }

  public function AdminBuatSesi($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);

    return view('admin.sesi.buat_sesi', [
      'user' => $user,
      'pelatihan' => $pelatihan,
    ]);
  }

  public function BuatSesi(Request $request)
  {
    $request->validate([
      'id_pelatihan' => 'required',
      'nama' => 'required',
      'keterangan' => 'required',
      'tanggal_pelaksanaan' => 'required',
      'jam_mulai' => 'required',
      'menit_mulai' => 'required',
      'jam_selesai' => 'required',
      'menit_selesai' => 'required',
      'jenis_pelaksanaan' => 'required',
    ]);

    if ($request->jenis_pelaksanaan == "luring" && $request->tempat_pelaksanaan == null) {
      session()->flash('message', 'Tempat Pelaksanaan Luring wajib diisi jika jenis pelaksanaan adalah luring');
      session()->flash('type', 'danger');
      return back();
    }
    
    if ($request->jenis_pelaksanaan == "daring" && $request->tautan_daring == null) {
      session()->flash('message', 'Tautan Pelaksanaan Daring wajib diisi jika jenis pelaksanaan adalah daring');
      session()->flash('type', 'danger');
      return back();
    }

    $sesi = new Sesi();
    $sesi->id_pelatihan = $request->id_pelatihan;
    $sesi->nama = $request->nama;
    $sesi->keterangan = $request->keterangan;
    $sesi->jenis_pelaksanaan = $request->jenis_pelaksanaan;
    $sesi->waktu_mulai = $request->tanggal_pelaksanaan . " " . $request->jam_mulai . ":" . $request->menit_mulai . ":00";
    $sesi->waktu_selesai = $request->tanggal_pelaksanaan . " " . $request->jam_selesai . ":" . $request->menit_selesai . ":00";
    $sesi->tempat_pelaksanaan = $request->tempat_pelaksanaan;
    $sesi->tautan_pelaksanaan = $request->tautan_daring;
    $sesi->save();

    session()->flash('message', 'Berhasil membuat sesi baru');
    return redirect('/admin/dashboard/sesi/' . $request->id_pelatihan);
  }
}
