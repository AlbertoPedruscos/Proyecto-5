<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_plazas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_plazas')->insert([
            'nombre' => 'A1',
            'planta' => 1,
            'id_estado' => 1,
            'id_parking' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_plazas')->insert([
            'nombre' => 'A2',
            'planta' => 1,
            'id_estado' => 2,
            'id_parking' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_plazas')->insert([
            'nombre' => 'A3',
            'planta' => 1,
            'id_estado' => 1,
            'id_parking' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_plazas')->insert([
            'nombre' => 'A4',
            'planta' => 1,
            'id_estado' => 2,
            'id_parking' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
