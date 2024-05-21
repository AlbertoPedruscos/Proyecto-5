<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class tbl_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios iniciales
        DB::table('tbl_usuarios')->insert([
            'nombre' => 'Julio',
            'apellidos' => 'Cesar',
            'email' => 'julio@gmail.com',
            'contrasena' => bcrypt('qweQWE123'),
            'id_rol' => 2,
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_usuarios')->insert([
            'nombre' => 'Iker',
            'apellidos' => 'Catalán',
            'email' => 'iker@gmail.com',
            'contrasena' => bcrypt('qweQWE123'),
            'id_rol' => 2,
            'id_empresa' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_usuarios')->insert([
            'nombre' => 'Alberto',
            'apellidos' => 'Bermejo',
            'email' => 'alberto@gmail.com',
            'contrasena' => bcrypt('qweQWE123'),
            'id_rol' => 3,
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_usuarios')->insert([
            'nombre' => 'Oscar',
            'apellidos' => 'Lopez',
            'email' => 'oscar@gmail.com',
            'contrasena' => bcrypt('qweQWE123'),
            'id_rol' => 3,
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Usuarios adicionales
        for ($empresa = 1; $empresa <= 5; $empresa++) {
            for ($i = 1; $i <= 15; $i++) {
                DB::table('tbl_usuarios')->insert([
                    'nombre' => 'Usuario' . $i,
                    'apellidos' => 'Apellido' . $i,
                    'email' => 'usuario' . $i . 'empresa' . $empresa . '@gmail.com',
                    'contrasena' => bcrypt('qweQWE123'),
                    'id_rol' => 3,
                    'id_empresa' => $empresa,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
