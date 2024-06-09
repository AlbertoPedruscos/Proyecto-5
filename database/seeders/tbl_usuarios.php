<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class tbl_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('tbl_usuarios')->insert([
        //     [
        //         'nombre' => 'alberto',
        //         'apellidos' => 'bermejo',
        //         'email' => 'alberto@gmail.com',
        //         'contrasena' => bcrypt('qweQWE123'),
        //         'id_rol' => 3,
        //         'id_empresa' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'nombre' => 'oscar',
        //         'apellidos' => 'oscar',
        //         'email' => 'oscar@gmail.com',
        //         'contrasena' => bcrypt('qweQWE123'),
        //         'id_rol' => 3,
        //         'id_empresa' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     // [
        //     //     'nombre' => 'julio',
        //     //     'apellidos' => 'cesar',
        //     //     'email' => 'julio@gmail.com',
        //     //     'contrasena' => bcrypt('qweQWE123'),
        //     //     'id_rol' => 2,
        //     //     'id_empresa' => 2,
        //     //     'created_at' => now(),
        //     //     'updated_at' => now()
        //     // ],
        //     // [
        //     //     'nombre' => 'iker',
        //     //     'apellidos' => 'catalan',
        //     //     'email' => 'iker@gmail.com',
        //     //     'contrasena' => bcrypt('qweQWE123'),
        //     //     'id_rol' => 2,
        //     //     'id_empresa' => 2,
        //     //     'created_at' => now(),
        //     //     'updated_at' => now()
        //     // ],
        //     // Añadir más usuarios si es necesario
        // ]);
        // Obtener las empresas para mapear sus nombres a los IDs
        $empresas = DB::table('tbl_empresas')->pluck('nombre', 'id')->toArray();

        // Lista de usuarios a insertar
        $usuarios = [
            // Empresa ID 2
            ['nombre' => 'Julio Cesar', 'apellidos' => 'Carrillo', 'id_rol' => 2, 'id_empresa' => 2],
            ['nombre' => 'Pedro', 'apellidos' => 'Blanco', 'id_rol' => 3, 'id_empresa' => 2],   
            ['nombre' => 'Gerard', 'apellidos' => 'Orobitg', 'id_rol' => 3, 'id_empresa' => 2],
            ['nombre' => 'Sergio', 'apellidos' => 'Velasco', 'id_rol' => 3, 'id_empresa' => 2],
            ['nombre' => 'Sergio', 'apellidos' => 'Jimenez', 'id_rol' => 3, 'id_empresa' => 2],
            ['nombre' => 'Agnés', 'apellidos' => 'Plans', 'id_rol' => 3, 'id_empresa' => 2],

            // Empresa ID 3
            ['nombre' => 'Alberto', 'apellidos' => 'Bermejo', 'id_rol' => 2, 'id_empresa' => 3],
            ['nombre' => 'Juan', 'apellidos' => 'García', 'id_rol' => 3, 'id_empresa' => 3],
            ['nombre' => 'Juan', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 3],
            ['nombre' => 'Alberto', 'apellidos' => 'De Santos', 'id_rol' => 3, 'id_empresa' => 3],
            ['nombre' => 'Sergi', 'apellidos' => 'Marin', 'id_rol' => 3, 'id_empresa' => 3],
            ['nombre' => 'Ian', 'apellidos' => 'Romero Sanabria', 'id_rol' => 3, 'id_empresa' => 3],

            // Empresa ID 4
            ['nombre' => 'Íker', 'apellidos' => 'Catalán Gómez', 'id_rol' => 2, 'id_empresa' => 4],
            ['nombre' => 'Betty', 'apellidos' => 'Pérez', 'id_rol' => 3, 'id_empresa' => 4],
            ['nombre' => 'Pau', 'apellidos' => 'Oliva', 'id_rol' => 3, 'id_empresa' => 4],
            ['nombre' => 'Ángel', 'apellidos' => 'Ruíz', 'id_rol' => 3, 'id_empresa' => 4],
            ['nombre' => 'Alexander', 'apellidos' => 'Abellaneda', 'id_rol' => 3, 'id_empresa' => 4],

            // Empresa ID 5
            ['nombre' => 'Óscar', 'apellidos' => 'López', 'id_rol' => 2, 'id_empresa' => 5],
            ['nombre' => 'Javier', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 5],
            ['nombre' => 'Laura', 'apellidos' => 'Sánchez', 'id_rol' => 3, 'id_empresa' => 5],
            ['nombre' => 'Daniel', 'apellidos' => 'González', 'id_rol' => 3, 'id_empresa' => 5],
            ['nombre' => 'María', 'apellidos' => 'Pérez', 'id_rol' => 3, 'id_empresa' => 5],

            // Empresa ID 6
            ['nombre' => 'Sara', 'apellidos' => 'Rodríguez', 'id_rol' => 2, 'id_empresa' => 6],
            ['nombre' => 'Sara', 'apellidos' => 'Rodríguez', 'id_rol' => 3, 'id_empresa' => 6],
            ['nombre' => 'Carlos', 'apellidos' => 'Fernández', 'id_rol' => 3, 'id_empresa' => 6],
            ['nombre' => 'Marta', 'apellidos' => 'García', 'id_rol' => 3, 'id_empresa' => 6],
            ['nombre' => 'David', 'apellidos' => 'Ruiz', 'id_rol' => 3, 'id_empresa' => 6],
            ['nombre' => 'Elena', 'apellidos' => 'Díaz', 'id_rol' => 3, 'id_empresa' => 6],

            // Empresa ID 7
            ['nombre' => 'Alejandro', 'apellidos' => 'Lay', 'id_rol' => 2, 'id_empresa' => 7],
            ['nombre' => 'Alejandro', 'apellidos' => 'Lay', 'id_rol' => 3, 'id_empresa' => 7],
            ['nombre' => 'Andrea', 'apellidos' => 'López', 'id_rol' => 3, 'id_empresa' => 7],
            ['nombre' => 'Pablo', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 7],
            ['nombre' => 'Lucía', 'apellidos' => 'Sánchez', 'id_rol' => 3, 'id_empresa' => 7],
            ['nombre' => 'Sergio', 'apellidos' => 'González', 'id_rol' => 3, 'id_empresa' => 7],

            // Empresa ID 8
            ['nombre' => 'Paula', 'apellidos' => 'García', 'id_rol' => 2, 'id_empresa' => 8],
            ['nombre' => 'Paula', 'apellidos' => 'García', 'id_rol' => 3, 'id_empresa' => 8],
            ['nombre' => 'Adrián', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 8],
            ['nombre' => 'Isabel', 'apellidos' => 'López', 'id_rol' => 3, 'id_empresa' => 8],
            ['nombre' => 'Alberto', 'apellidos' => 'Ruiz', 'id_rol' => 3, 'id_empresa' => 8],
            ['nombre' => 'Cristina', 'apellidos' => 'Pérez', 'id_rol' => 3, 'id_empresa' => 8],
            
            // Empresa ID 9
            ['nombre' => 'Pedro', 'apellidos' => 'Bravo', 'id_rol' => 2, 'id_empresa' => 9],
            ['nombre' => 'Pedro', 'apellidos' => 'Bravo', 'id_rol' => 3, 'id_empresa' => 9],
            ['nombre' => 'Martina', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 9],
            ['nombre' => 'Jorge', 'apellidos' => 'Sánchez', 'id_rol' => 3, 'id_empresa' => 9],
            ['nombre' => 'Nuria', 'apellidos' => 'González', 'id_rol' => 3, 'id_empresa' => 9],
            ['nombre' => 'Manuel', 'apellidos' => 'Pérez', 'id_rol' => 3, 'id_empresa' => 9],

            // Empresa ID 10
            ['nombre' => 'Ana Maria', 'apellidos' => 'Mena', 'id_rol' => 2, 'id_empresa' => 10],
            ['nombre' => 'Iván', 'apellidos' => 'López', 'id_rol' => 3, 'id_empresa' => 10],
            ['nombre' => 'Laura', 'apellidos' => 'Martínez', 'id_rol' => 3, 'id_empresa' => 10],
            ['nombre' => 'Francisco', 'apellidos' => 'Sánchez', 'id_rol' => 3, 'id_empresa' => 10],
            ['nombre' => 'Elena', 'apellidos' => 'Ruiz', 'id_rol' => 3, 'id_empresa' => 10],

            // Empresa ID 11
            ['nombre' => 'Admin', 'apellidos' => 'admin', 'id_rol' => 1, 'id_empresa' => 11],
        ];

        // Función para limpiar los nombres y apellidos de caracteres especiales y acentos, y convertirlos a minúsculas
        function cleanString($string) {
            // Reemplazar acentos y caracteres especiales
            $string = preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $string));
            // Convertir a minúsculas
            return strtolower($string);
        }

        // Función para generar el email
        function generateEmail($nombre, $apellidos, $empresa_nombre) {
            // Limpiar nombres y apellidos
            $nombre_usuario = cleanString($nombre);
            $apellidos_usuario = cleanString($apellidos);
            
            // Verificar si hay un nombre compuesto y agregar un punto si es así
            $nombre_parts = explode(' ', $nombre);
            if (count($nombre_parts) > 1) {
                $nombre_usuario = implode('.', $nombre_parts);
            }
            
            // Reemplazar espacios con puntos en los apellidos
            $apellidos_usuario = str_replace(' ', '.', $apellidos_usuario);
            
            // Limpiar el nombre de la empresa
            $empresa_nombre = str_replace([' ', '.'], '', $empresa_nombre);
            
            // Generar email
            return strtolower($nombre_usuario . '.' . $apellidos_usuario . '@' . cleanString($empresa_nombre) . '.com');
        }

        // Insertar los usuarios con el correo electrónico formateado y timestamps
        foreach ($usuarios as $usuario) {
            $empresa_nombre = $empresas[$usuario['id_empresa']];
            $email = generateEmail($usuario['nombre'], $usuario['apellidos'], $empresa_nombre);
            $createdAt = Carbon::now()->subDays(rand(1, 7))->subHours(rand(0, 23))->subMinutes(rand(0, 59))->subSeconds(rand(0, 59));
            DB::table('tbl_usuarios')->insert([
                'nombre' => $usuario['nombre'],
                'apellidos' => $usuario['apellidos'],
                'email' => $email,
                'contrasena' => bcrypt('qweQWE123'),
                'id_rol' => $usuario['id_rol'],
                'id_empresa' => $usuario['id_empresa'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }    
    }
}
