<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DokumenRiwayatController extends Controller {
  public function ShowDokumenRiwayatTest()
  {
    $user = auth()->user();
    $kartu_peserta = DB::table('kartu_peserta')
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

    // $sertifikat = DB::();

    return view('cetak_dokumen.dokumen_riwayat_test', [
      'user' => $user,
      'kartu_peserta' => $kartu_peserta,
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
              'dosen.fullname',
              'dosen.foto_profil',
              'pelatihan.id as pelatihan_id',
              'pelatihan.nama',
              )
            ->join('dosen', 'kartu_peserta.id_dosen', '=', 'dosen.id')
            ->join('pelatihan', 'kartu_peserta.id_pelatihan', '=', 'pelatihan.id')
            ->where('sertifikat.id', $id_sertifikat)
            ->get();

    return view('cetak_dokumen.sertifikat',[
      'data' => $data[0],
    ]);
  }
}
