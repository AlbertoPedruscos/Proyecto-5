<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modeloReserva extends Model
{
    use HasFactory;
    protected $table = 'tbl_reservas';

    protected $fillable = [
        'id_trabajador',
        'id_plaza',
        'nom_cliente',
        'matricula',
        'marca',
        'modelo',
        'color',
        'num_telf',
        'email',
        'ubicacion_entrada',
        'ubicacion_salida',
        'fecha_entrada',
        'fecha_salida',
        'firma',
    ];

    public function trabajador()
    {
        return $this->belongsTo(tbl_usuarios::class, 'id_trabajador', 'id', 'nombre');
    }
}

