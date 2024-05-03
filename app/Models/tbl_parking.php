<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_parking extends Model
{
    use HasFactory;

    protected $table = "tbl_parking";

    protected $fillable = [
        'nombre',
        'latitud',
        'longitud',
        'id_empresa',
        'id_plaza',
        'created_at',
        'updated_at',
    ];

    public function plazas()
    {
        return $this->hasMany(tbl_plazas::class, 'id_parking');
    }

    public function empresa()
    {
        return $this->belongsTo(tbl_empresas::class, 'id_empresa');
    }
}
