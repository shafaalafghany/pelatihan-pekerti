<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BerkasTugas;
use App\Models\Pelatihan;
use App\Models\Sesi;
use App\Models\Tugas;
use App\Models\TugasDosen;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TugasController extends Controller {
  public function ShowTugas()
  {
    $user = auth()->user();
    $tugas = DB::table('tugas')
            ->where('id_pelatihan', $user->id_pelatihan)
            ->get();

    foreach ($tugas as $item) {
      $item->keterangan = null;
      $time_tugas = new DateTime(Carbon::parse($item->batas_pengumpulan)->toDateTimeString());
      $berkas = DB::table('tugas_dosen')
                ->where('id_dosen', $user->id)
                ->where('id_tugas', $item->id)
                ->get();
      if (count($berkas) > 0) {
        $time_pengumpulan = new DateTime(Carbon::parse($berkas[0]->created_at)->toDateTimeString());
        if ($berkas[0]->id_tugas == $item->id) {
          if ($time_pengumpulan > $time_tugas) {
            $item->keterangan = "Telat Mengumpulkan";
          } else {
            $item->keterangan = "Sudah Mengumpulkan";
          }
        }
      }
    }

    // dd($tugas);

    return view('tugas.tugas', [
      'user' => $user,
      'tugas' => $tugas,
    ]);
  }

  public function ShowTugasDetail($id_tugas)
  {
    $user = auth()->user();
    $tugas = Tugas::find($id_tugas);
    $berkas_tugas  = DB::table('berkas_tugas')
                      ->where('id_tugas', $id_tugas)
                      ->get();
    $tugas_dosen = DB::table('tugas_dosen')
                  ->where('id_tugas', $tugas->id)
                  ->where('id_dosen', $user->id)
                  ->get();

    if (count($berkas_tugas) > 0) {
      foreach ($berkas_tugas as $item) {
        $split = explode("-", $item->nama_berkas);
        $item->nama = $split[1];
      }
    }

    return view('tugas.tugas_detail', [
      'user' => $user,
      'tugas' => $tugas,
      'berkas_tugas' => $berkas_tugas,
      'tugas_dosen' => $tugas_dosen,
    ]);
  }

  public function KumpulTugas(Request $request, $id_tugas)
  {
    $user = auth()->user();
    $request->validate([
      'berkas' => 'mimetypes:application/pdf|max:10240',
    ]);

    $file_berkas = "";
    $tugas_dosen = new TugasDosen();
    $tugas_dosen->id_tugas = $id_tugas;
    $tugas_dosen->id_dosen = $user->id;

    if ($request->online_text == null && $request->file('berkas') == null) {
      session()->flash('message', 'Salah satu dari online teks atau berkas tidak boleh kosong!');
      session()->flash('type', 'danger');
      return to_route('tugas');
    }

    if ($request->online_text != null) {
      $tugas_dosen->online_text = $request->online_text;
    }

    if ($request->file('berkas') != null) {
      $berkas = $request->file('berkas');
      $file_berkas = Str::random(16) . time() . '-' . str_replace(" ", "_", $berkas->getClientOriginalName());
      $tugas_dosen->berkas_tugas = $file_berkas;
    }

    if ($tugas_dosen->save()) {
      if ($request->file('berkas')) {
        $request->file('berkas')->move('files/berkas_tugas', $file_berkas);
      }

      session()->flash('message', 'Berhasil mengumpulkan tugas');
      return redirect('dashboard/tugas');
    }
  }

  public function AdminShowTugas()
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = DB::table('pelatihan')->where('is_active', 1)->get();

    return view('admin.tugas.tugas', [
      'user' => $user,
      'pelatihan' => $pelatihan,
    ]);
  }

  public function AdminShowTugasDetail(Request $request)
  {
    if ($request->pelatihan == 0) {
      session()->flash('message', 'Mohon pilih nama pelatihan dengan benar.');
      session()->flash('type', 'danger');
      return to_route('admin_tugas');
    }

    $id_pelatihan = $request->pelatihan;
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $tugas = DB::table('tugas')
            ->select('tugas.*', 'sesi.id as sesi_id', 'sesi.nama')
            ->join('sesi', 'tugas.id_sesi', '=', 'sesi.id')
            ->where('tugas.id_pelatihan', $id_pelatihan)
            ->get();

    return view('admin.tugas.tugas_detail', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'tugas' => $tugas,
    ]);
  }

  public function AdminBuatTugas($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $sesi = DB::table('sesi')->where('id_pelatihan', $id_pelatihan)->get();

    return view('admin.tugas.buat_tugas', [
      'user' => $user,
      'sesi' => $sesi,
    ]);
  }

  public function BuatTugas(Request $request)
  {
    if ($request->sesi == 0) {
      session()->flash('message', 'Mohon pilih sesi dengan pilihan yang tersedia');
      session()->flash('type', 'danger');
      return back();
    }

    $request->validate([
      'sesi' => 'required',
      'nama_tugas' => 'required',
      'deskripsi_tugas' => 'required',
      'berkas_tambahan' => 'required',
      'berkas_tambahan.*' => 'required',
      'tanggal' => 'required',
      'bulan' => 'required',
      'tahun' => 'required',
      'jam' => 'required',
      'menit' => 'required',
    ]);

    $batas_pengumpulan = $request->tahun . "-" . $request->bulan . "-" . $request->tanggal . " " . $request->jam . ":" . $request->menit. ":00";

    $tugas = new Tugas();
    $sesi = Sesi::find($request->sesi);
    $tugas->id_pelatihan = $sesi->id_pelatihan;
    $tugas->id_sesi = $request->sesi;
    $tugas->judul = $request->nama_tugas;
    $tugas->deskripsi = $request->deskripsi_tugas;
    $tugas->batas_pengumpulan = $batas_pengumpulan;
    $tugas->save();

    $files = $request->berkas_tambahan;
    if ($files) {
      foreach (($files) as $item) {
        $nama = Str::random(16) . time() . "-" . $item->getClientOriginalName();
        $berkas = new BerkasTugas();
        $berkas->id_tugas = $tugas->id;
        $berkas->nama_berkas = $nama;
        $berkas->save();

        $item->move('files/berkas-tugas', $nama);
      }
    }

    session()->flash('message', 'Berhasil membuat tugas baru.');
    return redirect('/admin/dashboard/tugas');
  }
}
