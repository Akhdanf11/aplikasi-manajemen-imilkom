<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        \Log::info('Authenticated user role: ' . $user->role->name);

        if ($user->role->name === 'Anggota Departemen') {
            return redirect()->route('dashboard.anggota-departemen');
        } elseif ($user->role->name === 'Kepala Departemen' || $user->role->name === 'Sekretaris Departemen') {
            return redirect()->route('dashboard.kepala-departemen');
        } elseif ($user->role->name === 'Ketua Umum' || $user->role->name === 'Sekretaris Umum' || $user->role->name === 'Bendahara Umum') {
            return redirect()->route('dashboard.bph');
        } else {
            return redirect()->route('home');
        }
    }

}
