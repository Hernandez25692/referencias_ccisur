<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bitacora extends Model
{
    use HasFactory;

    protected $fillable = [
        'referencia_id',
        'user_id',
        'accion',
        'cambios',
    ];

    public function referencia()
    {
        return $this->belongsTo(Referencia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
