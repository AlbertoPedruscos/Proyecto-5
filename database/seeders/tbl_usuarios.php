<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_usuarios')->insert([
            'nombre' => 'Julio',
            'apellidos' => 'Cesar',
            'email' => 'julio@gmail.com',
            'contrasena' => 'asdASD123',
            'id_rol' => 1,
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
