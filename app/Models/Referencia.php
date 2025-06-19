<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $fillable = [
        'correlativo',
        'asunto',
        'solicitado_por',
        'autorizado_por',
        'documento',
        'departamento',
        'estado',
        'user_id',
    ];
}
