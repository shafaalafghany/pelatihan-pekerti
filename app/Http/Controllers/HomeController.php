<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
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
