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
                'nombre_sitio' => 'Aeropuerto de Barcelona-El Prat',
                'calle' => 'Aeropuerto del Prat',
                'ciudad' => 'Barcelona',
                'latitud' => 41.2975,
                'longitud' => 2.0833,
                'empresa' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre_sitio' => 'Puerto de Valencia',
                'calle' => 'Muelle de la Aduana s/n',
                'ciudad' => 'Valencia',
                'latitud' => 39.4496,
                'longitud' => -0.3263,
                'empresa' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre_sitio' => 'Helipuerto de Madrid-Cuatro Vientos',
                'calle' => 'Aeropuerto de Madrid-Cuatro Vientos',
                'ciudad' => 'Madrid',
                'latitud' => 40.3708,
                'longitud' => -3.7894,
                'empresa' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre_sitio' => 'Aeropuerto Adolfo Suárez Madrid-Barajas',
                'calle' => 'Aeropuerto de Madrid-Barajas',
                'ciudad' => 'Madrid',
                'latitud' => 40.4944,
                'longitud' => -3.5679,
                'empresa' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nombre_sitio' => 'Puerto de Barcelona',
                'calle' => 'Moll de Barcelona',
                'ciudad' => 'Barcelona',
                'latitud' => 41.3641,
                'longitud' => 2.1899,
                'empresa' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'nombre_sitio' => 'Aeropuerto de Málaga-Costa del Sol',
                'calle' => 'Aeropuerto de Málaga',
                'ciudad' => 'Málaga',
                'latitud' => 36.6749,
                'longitud' => -4.4991,
                'empresa' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'nombre_sitio' => 'Aeropuerto de Palma de Mallorca',
                'calle' => 'Aeropuerto de Palma de Mallorca',
                'ciudad' => 'Palma de Mallorca',
                'latitud' => 39.5513,
                'longitud' => 2.7388,
                'empresa' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'nombre_sitio' => 'Puerto de Algeciras',
                'calle' => 'Av. de la Hispanidad, s/n',
                'ciudad' => 'Algeciras',
                'latitud' => 36.1275,
                'longitud' => -5.4356,
                'empresa' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'nombre_sitio' => 'Helipuerto de Barcelona',
                'calle' => 'Carrer de la Selva de Mar, 50',
                'ciudad' => 'Barcelona',
                'latitud' => 41.4006,
                'longitud' => 2.2063,
                'empresa' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'nombre_sitio' => 'Aeropuerto de Alicante-Elche',
                'calle' => 'Aeropuerto de Alicante-Elche',
                'ciudad' => 'Alicante',
                'latitud' => 38.2822,
                'longitud' => -0.5582,
                'empresa' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'nombre_sitio' => 'Puerto de Las Palmas',
                'calle' => 'Muelle de la Luz',
                'ciudad' => 'Las Palmas de Gran Canaria',
                'latitud' => 28.1465,
                'longitud' => -15.4284,
                'empresa' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
