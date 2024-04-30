<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_parking extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_parking')->insert([
            'nombre' => 'Parking 1',
            'latitud' => '41.349536354143744',
            'longitud' => '2.106697003108879',
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_parking')->insert([
            'nombre' => 'Parking 2',
            'latitud' => '41.35010355977579',
            'longitud' => '2.106182758240472',
            'id_empresa' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_parking')->insert([
            'nombre' => 'Parking 3',
            'latitud' => '41.34915063858738',
            'longitud' => '2.105719090230854',
            'id_empresa' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_parking')->insert([
            'nombre' => 'Parking 4',
            'latitud' => '41.34780760150584', 
            'longitud' => '2.1074169285400246',
            'id_empresa' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_parking')->insert([
            'nombre' => 'Parking 5',
            'latitud' => '41.34659114964164',  
            'longitud' => '2.1098135735856767',
            'id_empresa' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
