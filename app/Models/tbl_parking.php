<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_parking extends Model
{
    use HasFactory;

    protected $table = 'tbl_parkings'; // Especifica la tabla si no sigue la convención
    protected $primaryKey = 'id'; // Establece la clave primaria

    // Asignación masiva permitida
    protected $fillable = [
        'nombre', 'latitud', 'longitud', 'id_empresa'
    ];

    // Relaciones con otros modelos
    public function empresa()
    {
        return $this->belongsTo(tbl_empresas::class, 'id_empresa');
    }

    public function plazas()
    {
        return $this->hasMany(tbl_plazas::class, 'id_parking');
    }

    // Método personalizado para cargar la relación con la empresa
    public function scopeWithEmpresa($query)
    {
        return $query->with('empresa');
    }
}
