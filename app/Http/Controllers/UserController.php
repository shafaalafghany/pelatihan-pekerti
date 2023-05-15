<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller {
  public function ShowEditProfil() {
    return view('users.edit_profil');
  }
}