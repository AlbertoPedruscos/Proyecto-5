<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_reservas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('tbl_reservas')->insert([
<<<<<<< Updated upstream
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
=======
            ['id_trabajador' => null, 'id_plaza' => 1, 'nom_cliente' => 'Carlos', 'matricula' => '1234ABC', 'marca' => 'Ford', 'modelo' => 'Fiesta', 'color' => 'Azul', 'num_telf' => '123456789', 'email' => 'carlos@example.com', 'ubicacion_entrada' => 'Aeropuerto T1', 'ubicacion_salida' => 'Aeropuerto T2', 'fecha_entrada' => '2024-05-08 10:00:00', 'fecha_salida' => '2024-05-08 18:00:00'],
            ['id_trabajador' => null, 'id_plaza' => 2, 'nom_cliente' => 'Laura', 'matricula' => '5678DEF', 'marca' => 'Renault', 'modelo' => 'Clio', 'color' => 'Rojo', 'num_telf' => '987654321', 'email' => 'laura@example.com', 'ubicacion_entrada' => 'Aeropuerto T2', 'ubicacion_salida' => 'Aeropuerto T2', 'fecha_entrada' => '2024-05-09 11:00:00', 'fecha_salida' => '2024-05-09 19:00:00'],
            ['id_trabajador' => null, 'id_plaza' => 3, 'nom_cliente' => 'Ana', 'matricula' => '1357GHI', 'marca' => 'Seat', 'modelo' => 'Ibiza', 'color' => 'Blanco', 'num_telf' => '987123456', 'email' => 'ana@example.com', 'ubicacion_entrada' => 'Puerto', 'ubicacion_salida' => 'Puerto', 'fecha_entrada' => '2024-05-10 09:00:00', 'fecha_salida' => '2024-05-10 17:00:00'],
            ['id_trabajador' => null, 'id_plaza' => 4, 'nom_cliente' => 'David', 'matricula' => '2468JKL', 'marca' => 'Volkswagen', 'modelo' => 'Polo', 'color' => 'Verde', 'num_telf' => '654987321', 'email' => 'david@example.com', 'ubicacion_entrada' => 'Aeropuerto T1', 'ubicacion_salida' => 'Aeropuerto T1', 'fecha_entrada' => '2024-05-11 08:00:00', 'fecha_salida' => '2024-05-11 16:00:00'],
            ['id_trabajador' => null, 'id_plaza' => 5, 'nom_cliente' => 'Eva', 'matricula' => '3690MNO', 'marca' => 'Peugeot', 'modelo' => '208', 'color' => 'Gris', 'num_telf' => '321456987', 'email' => 'eva@example.com', 'ubicacion_entrada' => 'Aeropuerto T2', 'ubicacion_salida' => 'Aeropuerto T1', 'fecha_entrada' => '2024-05-12 10:00:00', 'fecha_salida' => '2024-05-12 18:00:00'],
>>>>>>> Stashed changes
        ]);
    }
}
