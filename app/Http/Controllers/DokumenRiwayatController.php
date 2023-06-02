<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelatihan;
use App\Models\Sertifikat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokumenRiwayatController extends Controller {
  public function ShowDokumenRiwayatTest()
  {
    $user = auth()->user();
    $data = DB::table('kartu_peserta')
            ->select(
              'kartu_peserta.*',
              'dosen.id as dosen_id',
              'pelatihan.id as pelatihan_id',
              'pelatihan.nama',
              'pelatihan.tanggal_pelaksanaan',
              )
            ->join('dosen', 'kartu_peserta.id_dosen', '=', 'dosen.id')
            ->join('pelatihan', 'kartu_peserta.id_pelatihan', '=', 'pelatihan.id')
            ->where('dosen.id', $user->id)
            ->get();

    foreach ($data as $item) {
      $split = explode(" - ", $item->tanggal_pelaksanaan);
      $item->pelaksanaan = Carbon::parse($split[0])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') . " - " . Carbon::parse($split[1])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');
      $sertifikat = DB::table('sertifikat')
                    ->where('id_dosen', $item->dosen_id)
                    ->where('id_pelatihan', $item->pelatihan_id)
                    ->get();
      if (count($sertifikat) > 0) {
        $item->sertifikat = true;
        $item->id_sertifikat = $sertifikat[0]->id;
      } else {
        $item->sertifikat = false;
      }
    }

    return view('cetak_dokumen.dokumen_riwayat_test', [
      'user' => $user,
      'data' => $data,
    ]);
  }

  public function ShowKartuPeserta($id_kartu_peserta)
  {
    $data = DB::table('kartu_peserta')
            ->select(
              'kartu_peserta.*',
              'dosen.id as dosen_id',
              'dosen.fullname',
              'dosen.foto_profil',
              'dosen.nama_instansi',
              'pelatihan.id as pelatihan_id',
              'pelatihan.nama',
              )
            ->join('dosen', 'kartu_peserta.id_dosen', '=', 'dosen.id')
            ->join('pelatihan', 'kartu_peserta.id_pelatihan', '=', 'pelatihan.id')
            ->where('kartu_peserta.id', $id_kartu_peserta)
            ->get();

    return view('cetak_dokumen.kartu_peserta', [
      'data' => $data[0],
    ]);
  }

  public function ShowSertifikat($id_sertifikat)
  {
    $data = DB::table('sertifikat')
            ->select(
              'sertifikat.*',
              'dosen.id as dosen_id',
              'dosen.gelar_depan',
              'dosen.gelar_belakang',
              'dosen.fullname',
              'dosen.foto_profil',
              'pelatihan.id as pelatihan_id',
              'pelatihan.nama',
              'pelatihan.jenis_pelatihan',
              'pelatihan.tanggal_pelaksanaan'
              )
            ->join('dosen', 'sertifikat.id_dosen', '=', 'dosen.id')
            ->join('pelatihan', 'sertifikat.id_pelatihan', '=', 'pelatihan.id')
            ->where('sertifikat.id', $id_sertifikat)
            ->get();

    $split = explode(" - ", $data[0]->tanggal_pelaksanaan);
    $data[0]->pelaksanaan = Carbon::parse($split[0])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') . " - " . Carbon::parse($split[1])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y');

    return view('cetak_dokumen.sertifikat',[
      'data' => $data[0],
    ]);
  }

  public function AdminShowPilihPeserta($id_pelatihan)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $peserta = DB::table('dosen_pelatihan')
              ->select('dosen_pelatihan.*', 'dosen.id as dosen_id', 'dosen.fullname', 'dosen.id_pelatihan')
              ->join('dosen', 'dosen_pelatihan.id_dosen', '=', 'dosen.id')
              ->where('dosen.id_pelatihan', $id_pelatihan)
              ->get();

    return view('admin.nilai.pilih_peserta', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'peserta' => $peserta,
    ]);
  }

  public function AdminShowTerbitSertifikat($id_pelatihan, $id_dosen)
  {
    $user = Admin::find(Auth::guard('admin')->id());
    $pelatihan = Pelatihan::find($id_pelatihan);
    $peserta = User::find($id_dosen);
    
    return view('admin.pelatihan.sertifikat', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'peserta' => $peserta,
    ]);
  }

  public function PilihPesertaSertifikat(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
      'peserta' => 'required',
    ]);

    $id_pelatihan = $request->pelatihan;
    $id_dosen = $request->peserta;

    // $presensi = DB::table('presensi')->where('id_pelatihan', $id_pelatihan)->get();
    // $jumlah_presensi = 0;
    // foreach ($presensi as $item) {
    //   $cek_presensi = DB::table('dosen_presensi')
    //                   ->where('id_dosen', $id_dosen)
    //                   ->where('id_sesi', $item->id_sesi)
    //                   ->get();
    //   if (count($cek_presensi) > 0) {
    //     $jumlah_presensi++;
    //   }
    // }

    // $presenstase_presensi = (float)bcdiv($jumlah_presensi, count($presensi), 1);
    // if ($presenstase_presensi < 0.9) {
    //   session()->flash('message', 'Kehadiran peserta kurang dari 90%, agar sertifikat dapat diterbitkan presentase kehadiran peserta minimal 90%');
    //   session()->flash('type', 'danger');
    //   return back();
    // }

    // $tugas = DB::table('tugas')->where('id_pelatihan', $id_pelatihan)->get();
    // $jumlah_tugas = 0;
    // foreach ($tugas as $item) {
    //   $cek_tugas = DB::table('tugas_dosen')
    //               ->where('id_dosen', $id_dosen)
    //               ->where('id_tugas', $item->id)
    //               ->orderByDesc('id')
    //               ->limit(1)
    //               ->get();
    //   if (count($cek_tugas) > 0) {
    //     $jumlah_tugas++;
    //   }
    // }

    // $presentase_tugas = $jumlah_tugas / count($tugas);
    // if ($presentase_tugas < 1) {
    //   session()->flash('message', 'Peserta belum mengumpulkan seluruh tugas, agar sertifikat dapat diterbitkan presentase peserta diwajibkan mengumpulkan seluruh tugas');
    //   session()->flash('type', 'danger');
    //   return back();
    // }

    // $nilai = DB::table('nilai')->where('id_pelatihan', $id_pelatihan)->get();
    // $jumlah_nilai = 0;
    // foreach ($nilai as $item) {
    //   $cek_nilai = DB::table('detail_nilai')
    //               ->where('id_dosen', $id_dosen)
    //               ->where('id_pelatihan', $id_pelatihan)
    //               ->orderByDesc('id')
    //               ->limit(1)
    //               ->get();
    //   if (count($cek_nilai) > 0) {
    //     $jumlah_nilai++;
    //   }
    // }

    // if ($jumlah_nilai < count($nilai)) {
    //   session()->flash('message', 'Nilai peserta belum diinputkan seluruhnya, agar sertifikat dapat diterbitkan seluruh nilai peserta harus diinputkan seluruhnya');
    //   session()->flash('type', 'danger');
    //   return back();
    // }

    $sertifikat = DB::table('sertifikat')->where('id_pelatihan', $id_pelatihan)->where('id_dosen', $id_dosen)->get();
    if (count($sertifikat) > 0) {
      session()->flash('message', 'Sertifikat peserta telah diterbitkan sebelumnya');
      session()->flash('type', 'danger');
      return back();
    }

    return redirect('/admin/dashboard/pelatihan/' . $id_pelatihan . "/" . $id_dosen . "/sertifikat");
  }

  public function TerbitkanSertifikat(Request $request)
  {
    $request->validate([
      'pelatihan' => 'required',
      'peserta' => 'required',
      'nomor_surat' => 'required',
    ]);

    $peserta = User::find($request->peserta);

    $sertifikat = new Sertifikat();
    $sertifikat->id_dosen = $request->peserta;
    $sertifikat->id_pelatihan = $request->pelatihan;
    $sertifikat->nomor_sertifikat = $request->nomor_surat;
    $sertifikat->save();

    session()->flash('message', 'Berhasil menerbitkan sertifikat untuk ' . $peserta->fullname);
    return redirect('/admin/dashboard/pelatihan/' . $request->pelatihan);
  }
}
