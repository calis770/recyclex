<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = Akun::where('id_level', '2')->count();
        return view('products.index');
    }

    public function users()
    {
        $users = Akun::with('levelAkun')->where('id_level', '2')->get();
        return view('admin.users', compact('users'));
    }
}