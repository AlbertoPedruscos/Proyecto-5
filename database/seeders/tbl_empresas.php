<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_empresas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_empresas')->insert([
            'nombre' => 'Nnparkings',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_empresas')->insert([
            'nombre' => 'Interparking Hispania',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_empresas')->insert([
            'nombre' => 'Saba Sede',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_empresas')->insert([
            'nombre' => 'Continental Parking SL',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tbl_empresas')->insert([
            'nombre' => 'Pàrking PRATSA Self Storage',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
