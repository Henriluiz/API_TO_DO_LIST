<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'permissoes_admin',
        'status_admin',
    ];
}
