<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
}
