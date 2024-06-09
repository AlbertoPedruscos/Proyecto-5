<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_ubicaciones extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_ubicaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_sitio',
        'empresa',
        'calle',
        'ciudad',
        'latitud',
        'longitud',
    ];
    public function empresa()
    {
        return $this->belongsTo(tbl_empresas::class, 'empresa_id');
    }
}

