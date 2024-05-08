<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_reservas')->insert([
            'id_trabajador' => 1,
            'id_plaza' => 1,
            'nom_cliente' => 'Cliente 1',
            'matricula' => '1234 ABC',
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'color' => 'Azul',
            'num_telf' => '123456789',
            'email' => 'cliente1@example.com',
            'ubicacion_entrada' => 'Entrada 1',
            'ubicacion_salida' => 'Salida 1',
            'fecha_entrada' => now(),
            'fecha_salida' => now()->addHour(),
        ]);
    }
}
