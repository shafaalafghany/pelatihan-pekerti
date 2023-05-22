<?php

namespace App\Http\Controllers;

use App\Models\DosenPelatihan;
use App\Models\Pelatihan;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
  public function ShowPembayaran()
  {
    $user = auth()->user();
    $pelatihan = [];
    if ($user->status_pendaftaran != 3) {
      $pelatihan = Pelatihan::find($user->id_pelatihan);
    }

    // dd(Carbon::now()->toDateTimeString());
    // dd($bayar[0]->created_at . " --- " . Carbon::parse($bayar[0]->created_at)->addDay());
    // dd(Carbon::parse($bayar[0]->created_at)->format('Y-m-d'));
    
    $lunas = DB::table('pembayaran')
    ->join('pelatihan', 'pembayaran.id_pelatihan', '=', 'pelatihan.id')
    ->select('pembayaran.*', 'pelatihan.nama')
    ->where('pembayaran.id_dosen', $user->id)
    ->where('pembayaran.status', '=', 2)
    ->orWhere('pembayaran.status', '=', 3)
    ->orderBy('pembayaran.created_at', 'desc')
    ->get();

    foreach ($lunas as $item) {
      if ($item->status == 2 && (Carbon::parse($item->created_at)->addDay() > Carbon::parse($item->created_at))) {
        $item->keterangan = "Melebihi waktu batas pembayaran";
      } elseif ($item->status == 2) {
        $item->keterangan = "Tagihan belum dibayar";
      } elseif ($item->status == 3) {
        $waktu = Carbon::parse($item->updated_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y h:i');
        $item->keterangan = "Sudah dibayar pada ";
        $item->dibayar_pada = $waktu;
      }
    }

    return view('pembayaran.pembayaran', [
      'user' => $user,
      'pelatihan' => $pelatihan,
      'lunas' => $lunas,
    ]);
  }

  public function ShowInvoice($id_pembayaran)
  {
    $user = auth()->user();
    $data = DB::table('dosen')
    ->select('dosen.fullname', 'pelatihan.nama', 'pembayaran.id', 'pembayaran.invoice', 'pembayaran.updated_at')
    ->join('pelatihan', 'pelatihan.id', '=', 'dosen.id_pelatihan')
    ->join('pembayaran', 'pembayaran.id_dosen', '=', 'dosen.id')
    ->where('dosen.id', $user->id)
    ->where('pembayaran.id', $id_pembayaran)
    ->orderBy('pembayaran.created_at', 'desc')
    ->limit(1)
    ->get();

    return view('pembayaran.invoice', ['data' => $data[0]]);
  }

  public function AddPembayaran($id_pelatihan)
  {
    $user = auth()->user();
    $pelatihan = Pelatihan::find($user->id_pelatihan);

    $kode_pelatihan = "";
    if ($pelatihan->jenis_pelatihan == "pekerti") {
      $kode_pelatihan = "PKT";
    } else {
      $kode_pelatihan = "AA";
    }

    $pembayaran = new Pembayaran();
    $pembayaran->id_dosen = $user->id;
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
        'fullname' => $user->fullname,
        'email' => $user->email,
        'phone' => $user->telepon,
      ),
    );

    $pembayaran->snap_token = \Midtrans\Snap::getSnapToken($params);
    $pembayaran->save();

    return redirect('https://app.sandbox.midtrans.com/snap/v3/redirection/' . $pembayaran->snap_token);
  }

  public function callback(Request $request)
  {
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($hashed == $request->signature_key) {
      $pembayaran = Pembayaran::find($request->order_id);
      $user = User::find($pembayaran->id_dosen);
      if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
        $user->status_pendaftaran = 3;
        $user->save();
        $pembayaran->status = 3;
        $pembayaran->snap_token = null;
        $pembayaran->save();
        $dosenPelatihan = new DosenPelatihan();
        $dosenPelatihan->id_dosen = $user->id;
        $dosenPelatihan->id_pelatihan = $user->id_pelatihan;
        $dosenPelatihan->save();
      } else {
        $user->status_pendaftaran = 5;
        $user->save();
        $pembayaran->status = 2;
        $pembayaran->save();
      }
    }
  }
}
