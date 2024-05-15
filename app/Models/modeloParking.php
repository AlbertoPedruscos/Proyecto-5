<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modeloParking extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_parkings';

    protected $fillable = [
        'nombre',
        'latitud',
        'longitud',
        'id_empresa',
        'id_plaza',
    ];
}
