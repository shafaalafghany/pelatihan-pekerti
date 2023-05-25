<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
