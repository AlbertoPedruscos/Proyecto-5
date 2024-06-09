<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_registros extends Model
{
    use HasFactory;
    protected $table = 'tbl_registros';

    protected $fillable = [
        'id_usuario',
        'latitud',
        'longitud',
        'id_empresa',
        'id_reserva',
        'accion',
        'tipo',
        'fecha_creacion'
    ];
}
