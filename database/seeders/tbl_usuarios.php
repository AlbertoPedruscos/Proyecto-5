<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class tbl_usuarios extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_usuarios')->insert([
            [
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'email' => 'juan@gmail.com',
                'rol' => 'admin',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'Garcia',
                'email' => 'pedro@gmail.com',
                'rol' => 'trabajador',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [            
                'nombre' => 'Íker',
                'apellido' => 'Catalán',
                'email' => 'iker@gmail.com',
                'rol' => 'trabajador',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],            
            [            
                'nombre' => 'Julio',
                'apellido' => 'Cesar',
                'email' => 'julio@gmail.com',
                'rol' => 'trabajador',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],      
            [            
                'nombre' => 'Julio',
                'apellido' => 'Cesar',
                'email' => 'julio@gmail.com',
                'rol' => 'cliente',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],                  
            [
                'nombre' => 'Oscar',
                'apellido' => 'Lopez',
                'email' => 'ocar@gmail.com',
                'rol' => 'cliente',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Rodriguez',
                'email' => 'luis@gmail.com',
                'rol' => 'cliente',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
