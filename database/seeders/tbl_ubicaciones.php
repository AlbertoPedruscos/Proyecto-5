<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_ubicaciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_ubicaciones')->insert([
            [
                'id' => 1,
                'nombre_sitio' => 'Nombre del sitio 1',
                'calle' => 'Calle 1',
                'ciudad' => 'Ciudad 1',
                'latitud' => 123.456789,
                'longitud' => 456.123456,
                'empresa' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Puedes agregar más datos según sea necesario
        ]);
    }
}
