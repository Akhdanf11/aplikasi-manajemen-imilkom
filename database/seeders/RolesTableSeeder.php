<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Anggota Departemen']);
        Role::create(['name' => 'Kepala Departemen']);
        Role::create(['name' => 'Sekretaris Departemen']);
        Role::create(['name' => 'Ketua Umum']);
        Role::create(['name' => 'Sekretaris Umum']);
        Role::create(['name' => 'Bendahara Umum']);
    }
}

