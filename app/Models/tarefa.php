<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tarefa extends Authenticatable
{
    protected $table = 'tarefas';

    protected $fillable = [
        'id_user',
        'nome',
        'DataInicio',
        'DataLimite',
        'tipo',
        'StatusTarefa',
    ];

}
