<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index() {
        return view('daftar_pelatihan');
    }
}
