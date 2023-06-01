<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DetailNilai;
use App\Models\Nilai;
use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller {
  public function AdminTambahKolomNilai($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $kolom = DB::table('nilai')
              ->where('id_pelatihan', $id_pelatihan)
              ->get();
    
    return view('admin.nilai.tambah_kolom', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'kolom' => $kolom,
    ]);
  }

  public function AdminInputNilai($id_pelatihan, $id_dosen)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $dosen = User::find($id_dosen);
    $pelatihan = Pelatihan::find($id_pelatihan);
    $kolom = DB::table('nilai')->where('id_pelatihan', $id_pelatihan)->get();
    
    foreach ($kolom as $item) {
      $item->nilai = 0;
      $item->id_detail_nilai = 0;
      $detail_nilai = DB::table('detail_nilai')->where('id_nilai', $item->id)->where('id_dosen', $id_dosen)->orderByDesc('id')->get();
      if (count($detail_nilai) > 0) {
        $item->id_detail_nilai = $detail_nilai[count($detail_nilai) - 1]->id;
        $item->nilai = $detail_nilai[count($detail_nilai) - 1]->nilai;
      }
    }

    return view('admin.nilai.input_nilai', [
      'user' => $user,
      'dosen' => $dosen,
      'pelatihan' => $pelatihan,
      'kolom' => $kolom,
    ]);
  }

  public function TambahNilai(Request $request)
  {
    $dosen = User::find($request->dosen);
    $nilai = DB::table('nilai')->where('id_pelatihan', $request->pelatihan)->get();
    foreach ($nilai as $item) {
      $detail_nilai = new DetailNilai();
      $detail_nilai->id_dosen = $request->dosen;
      $detail_nilai->id_nilai = $item->id;
      $detail_nilai->nilai = $request->{$item->id};
      $detail_nilai->save();
    }

    session()->flash('message', 'Berhasil menambahkan Nilai ' . $dosen->fullname);
    return redirect('/admin/dashboard/pelatihan/'. $request->pelatihan);
  }

  public function TambahKolomNilai(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
      'kolom_nilai' => 'required',
    ]);

    $nilai = new Nilai();
    $nilai->id_pelatihan = $request->pelatihan;
    $nilai->nama_nilai = $request->kolom_nilai;
    $nilai->save();

    session()->flash('message', 'Berhasil menambahkan Kolom Penilaian baru');
    return redirect('/admin/dashboard/pelatihan/'. $request->pelatihan . '/tambah-kolom-nilai');
  }
}
