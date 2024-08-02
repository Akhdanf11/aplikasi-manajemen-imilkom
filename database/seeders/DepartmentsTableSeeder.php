<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Seed the departments table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'Kemahasiswaan'],
            ['name' => 'Wawasan Kontemporer'],
            ['name' => 'Seni dan Olahraga'],
            ['name' => 'Hubungan Masyarakat'],
            ['name' => 'Dana dan Usaha'],
            ['name' => 'Komunikasi dan Informasi'],
            ['name' => 'Biro Administrasi dan Kesekretariatan'],
        ]);
    }
}

