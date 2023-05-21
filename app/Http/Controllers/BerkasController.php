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

    $this->addPembayaran($id_peserta, $id_pelatihan, $pelatihan->jenis_pelatihan);

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

  private function addPembayaran($id_peserta, $id_pelatihan, $jenis_pelatihan)
  {
    $peserta = User::find($id_peserta);
    $kode_pelatihan = "";
    if ($jenis_pelatihan == "pekerti") {
      $kode_pelatihan = "PKT";
    } else {
      $kode_pelatihan = "AA";
    }

    $pembayaran = new Pembayaran();
    $pembayaran->id_dosen = $id_peserta;
    $pembayaran->id_pelatihan = $id_pelatihan;
    $pembayaran->invoice = "INV/" . date("Ymd") . "/" . $kode_pelatihan . "/" . random_int(1000000000, 9999999999);
    $pembayaran->status = 1;
    $pembayaran->save();
    
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

    $params = array(
      'transaction_details' => array(
        'order_id' => $pembayaran->id,
        'gross_amount' => 200000,
      ),
      'customer_details' => array(
        'fullname' => $peserta->fullname,
        'email' => $peserta->email,
        'phone' => $peserta->telepon,
      ),
    );

    $snapToken = \Midtrans\Snap::getSnapToken($params);
    $pembayaran->snap_token = $snapToken;
    $pembayaran->save();
  }
}
