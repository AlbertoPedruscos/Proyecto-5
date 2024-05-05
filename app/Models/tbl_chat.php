<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_chat extends Model
{
    use HasFactory;

    protected $table = 'tbl_chat';

    protected $fillable = [
        'emisor',
        'receptor',
        'mensaje',
    ];
}
