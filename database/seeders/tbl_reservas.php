<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_reservas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_reservas')->insert([
            'id_trabajador' => null,
            'id_plaza' => 1,
            'nom_cliente' => 'Alberto',
            'matricula' => '1234 ABC',
            'marca' => 'Volkswagen',
            'modelo' => 'Golf',
            'color' => 'Azul',
            'num_telf' => '654321987',
            'email' => 'alberto@gmail.com',
            'ubicacion_entrada' => '1',
            'ubicacion_salida' => '1',
            'fecha_entrada' => '2024-04-30 11:43:01',
            'fecha_salida' => '2024-04-30 11:43:01',
            'firma_entrada' => null,
            'firma_salida' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tbl_reservas')->insert([
            'id_trabajador' => null,
            'id_plaza' => 2,
            'nom_cliente' => 'Julio',
            'matricula' => '5678 DEF',
            'marca' => 'Audi',
            'modelo' => 'A3',
            'color' => 'Rojo',
            'num_telf' => '654321987',
            'email' => 'julio@gmail.com',
            'ubicacion_entrada' => '1',
            'ubicacion_salida' => '1',
            'fecha_entrada' => '2024-04-30 11:43:01',
            'fecha_salida' => '2024-04-30 11:43:01',
            'firma_entrada' => null,
            'firma_salida' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
