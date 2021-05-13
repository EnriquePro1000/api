<?php

namespace App\Models\Prestamos;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        "id",
        "cliente_id",
        "prestamo_id",
        "mora",
        "creado",
        "usuario_id",
        ];

}
