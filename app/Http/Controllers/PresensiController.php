<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DosenPresensi;
use App\Models\Pelatihan;
use App\Models\Presensi;
use App\Models\Sesi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresensiController extends Controller {
  public function ShowPresensi()
  {
    $user = auth()->user();

    if ($user->id_pelatihan == 0 && $user->status_pendaftaran != 3) {
      session()->flash('message', 'Anda belum terdaftar dalam pelatihan manapun');
      return redirect('/dashboard');
    }

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

  public function AdminShowPresensi()
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = DB::table('pelatihan')
                    ->orderBy('batas_pendaftaran', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();

    return view('admin.presensi.pilih_pelatihan', [
      'user' => $user,
      'pelatihan' => $pelatihan,
    ]);
  }

  public function PilihPelatihan(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
    ]);

    if ($request->pelatihan == 0) {
      session()->flash('message', 'Mohon memilih pelatihan dengan benar');
      session()->flash('type', 'danger');
      return back();
    }

    return redirect('/admin/dashboard/presensi/' . $request->pelatihan);
  }

  public function AdminShowPrensensiDetail($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $presensi = DB::table('presensi')
                ->select('presensi.*', 'sesi.id as sesi_id', 'sesi.nama as nama_sesi', 'sesi.id_pelatihan')
                ->join('sesi', 'presensi.id_sesi', '=', 'sesi.id')
                ->where('sesi.id_pelatihan', $id_pelatihan)
                ->get();

    return view('admin.presensi.presensi', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'presensi' => $presensi,
    ]);
  }

  public function AdminShowPresensiDetailSesi($id_pelatihan, $id_sesi)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $sesi = Sesi::find($id_sesi);
    $presensi = DB::table('presensi')->where('id_pelatihan', $id_pelatihan)->where('id_sesi', $id_sesi)->get();
    $data = DB::table('dosen_presensi')
            ->select('dosen_presensi.*', 'dosen.fullname', 'dosen.nama_instansi')
            ->join('dosen', 'dosen_presensi.id_dosen', '=', 'dosen.id')
            ->where('dosen_presensi.id_sesi', $id_sesi)
            ->get();

    return view('admin.presensi.presensi_detail', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'sesi' => $sesi,
      'presensi' => $presensi,
      'data' => $data,
    ]);
  }

  public function AdminBuatPresensi($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $sesi = DB::table('sesi')->where('id_pelatihan', $id_pelatihan)->get();

    return view('admin.presensi.buat_presensi', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'sesi' => $sesi,
    ]);
  }

  public function BuatPresensi(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
      'sesi' => 'required',
      'jam' => 'required',
      'menit' => 'required',
    ]);

    if ($request->sesi == 0) {
      session()->flash('message', 'Mohon memilih sesi dengan benar');
      session()->flash('type', 'danger');
      return back();
    }

    $cek = DB::table('presensi')->where('id_sesi', $request->sesi)->get();
    if(count($cek) > 0) {
      session()->flash('message', 'Presensi untuk sesi ini telah dibuat, dimohon untuk memilih sesi lainnya');
      session()->flash('type', 'danger');
      return back();
    }

    $presensi = new Presensi();
    $presensi->id_pelatihan = $request->pelatihan;
    $presensi->id_sesi = $request->sesi;
    $presensi->kode_presensi = Str::random(5);
    $presensi->batas_presensi = Carbon::now()->toDateString() . " " . $request->jam . ":" . $request->menit . ":00";
    $presensi->save();

    session()->flash('message', 'Berhasil membuat presensi baru');
    return redirect('/admin/dashboard/presensi/' . $request->pelatihan);
  }
}
