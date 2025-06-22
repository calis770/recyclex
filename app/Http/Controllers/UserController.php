<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Akun;

class UserController extends Controller
{
    public function dashboard()
    {
        $userData = [
            'id' => Session::get('user_id'),
            'email' => Session::get('user_email'),
            'level' => Session::get('user_level'),
            'level_name' => Session::get('user_level_name'),
        ];

        $user = Akun::with('level')->find(Session::get('user_id'));

        return view('user.dashboard', compact('user', 'userData'));
    }

    public function profile()
    {
        $user = Akun::with('level')->find(Session::get('user_id'));
        return view('user.profile', compact('user'));
    }
}