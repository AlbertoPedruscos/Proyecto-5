<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pagos_empresa extends Model
{
    use HasFactory;

    protected $table = 'tbl_pagos_empresa';

    protected $fillable = [
        'empresa',
        'ha_hecho_pago',
        'fecha_pago',
    ];

    protected $casts = [
        'ha_hecho_pago' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(tbl_empresas::class, 'empresa');
    }
}
