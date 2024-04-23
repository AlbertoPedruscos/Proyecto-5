<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblReserva extends Model
{
    use HasFactory;

    protected $table = 'tbl_reservas';

    protected $fillable = [
        'id_trabajador',
        'id_cliente',
        'id_plaza',
        'fecha_inicio',
        'fecha_fin',
        'firma',
    ];
}
