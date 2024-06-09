<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class tbl_pagos_empresa extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Datos de ejemplo para insertar en la tabla tbl_pagos_empresa
        $pagos = [
            ['empresa' => 2, 'ha_hecho_pago' => 1, 'fecha_pago' => $now],
            ['empresa' => 2, 'ha_hecho_pago' => 1, 'fecha_pago' => Carbon::create(2024, 6, 15, 0, 0, 0)],
        ];

        // Insertar los datos en la tabla tbl_pagos_empresa
        foreach ($pagos as $pago) {
            DB::table('tbl_pagos_empresa')->insert([
                'empresa' => $pago['empresa'],
                'ha_hecho_pago' => $pago['ha_hecho_pago'],
                'fecha_pago' => $pago['fecha_pago'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
