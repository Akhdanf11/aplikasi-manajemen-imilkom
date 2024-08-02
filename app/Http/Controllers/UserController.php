<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department; // Assuming you have a Department model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->checkRole(['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen', 'Sekretaris Departemen']);
            return $next($request);
        })->only(['index', 'edit', 'update', 'destroy']);
    }

    protected function checkRole(array $roles)
    {
        $userRole = Auth::user()->role->name;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }
    }

    public function index(Request $request)
    {
        // Access is restricted to BPH (Ketua Umum, Sekretaris Umum, Bendahara Umum) only
        $this->checkRole(['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']);

        // Fetch roles and departments
        $roles = Role::all();
        $departments = Department::all(); // Adjust based on your actual model

        // Query users with optional filtering
        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role_id', $request->input('role'));
        }
        
        if ($request->filled('department')) {
            $query->where('department_id', $request->input('department')); // Adjust based on your actual field
        }

        $users = $query->paginate(10); // Adjust pagination as needed

        return view('users.index', compact('users', 'roles', 'departments'));
    }

    public function edit(User $user)
        {
            // Ambil semua peran
            $roles = Role::all();

            // Kirim data ke view
            return view('users.edit', compact('user', 'roles'));
        }

        public function update(Request $request, User $user)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'role_id' => 'required|exists:roles,id',
            ]);

            $user->update($request->only(['name', 'role_id']));

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        }

        public function destroy(User $user)
        {
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        }
}
