<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_roles')->insert([
            'nombre' => 'Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_roles')->insert([
            'nombre' => 'Empresa',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_roles')->insert([
            'nombre' => 'Usuario',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
