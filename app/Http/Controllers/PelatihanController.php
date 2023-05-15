<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index() {
        $user = auth()->user();
        
        $tugas = [];
        $pelatihan = [];
        
        if ($user['id_pelatihan'] != 0) {
            $pelatihan = Pelatihan::where('id', $user['id_pelatihan'])->first();
        //     // $tugas = User::join
        }

        return view('dashboard', [
            'user' => $user,
            'tugas' => $tugas,
            'pelatihan' => $pelatihan,
        ]);
    }
}
