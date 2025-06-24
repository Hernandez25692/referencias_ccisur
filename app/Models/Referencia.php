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

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }
}
