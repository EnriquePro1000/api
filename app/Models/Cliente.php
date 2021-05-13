<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
      
    protected $fillable = [
        "id",
        'tipide_id',
        "identidad",
        'name1',
        'name2',
        'lastname1',
        'lastname2',
        "direccion",
        "telefono",
        "file",
        "prestamoactivo",
        "usuario_id"
        ];    
    
}
