<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Department;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function showRegistrationForm()
    {
        $roles = Role::all(); // Ambil semua role dari database
        $departments = Department::all(); // Ambil semua departemen dari database
        return view('auth.register', compact('roles', 'departments'));
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],
            'department' => ['required_if:role,1,2', 'exists:departments,id'], // Validasi departemen jika role adalah Anggota Departemen atau Kepala Departemen
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role'],
            'department_id' => $data['department'] ?? null, // Simpan department_id jika ada
        ]);
    }

    /**
     * Handle a successful registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function registered($request, $user)
    {
        if ($user->role->name === 'Anggota Departemen') {
            return redirect()->route('dashboard.anggota-departemen');
        } elseif (in_array($user->role->name, ['Kepala Departemen', 'Sekretaris Departemen'])) {
            return redirect()->route('dashboard.kepala-departemen');
        } elseif (in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'])) {
            return redirect()->route('dashboard.bph');
        } else {
            return redirect()->route('home'); // Rute default jika role tidak dikenali
        }
    }
}
