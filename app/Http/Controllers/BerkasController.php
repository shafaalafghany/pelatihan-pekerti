<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
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
    dd($peserta);

    return view('admin.validasi_berkas.validasi_berkas_detail', [
      'user' => $user,
      'peserta' => $peserta,
    ]);
  }
}
