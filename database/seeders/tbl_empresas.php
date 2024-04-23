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
            'nombre' => 'ConPark',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
