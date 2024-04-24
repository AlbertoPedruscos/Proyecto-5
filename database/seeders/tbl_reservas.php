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
            'id_trabajador' => 1,
            'id_cliente' => 1,
            'id_plaza' => 1,
            'firma' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
