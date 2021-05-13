<?php

namespace App\Models\Prestamos;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamos';
    
    public $timestamps = false;
     
    protected $fillable = [
        "id",
        "cliente_id",
        "monto",
        "intereses",
        "total_deuda",
        "total_intereses",
        "pagos",
        "estado",
        "mesesmora",
        "fechinicio",
        "fechafin",
        "usuario_id",
        ];
    
     public function cliente()
    {
        //one to one inverso, el prestamo pertenece a un cliente
        return $this->belongsTo('App\Models\Seguridad\Cliente');
    }
     public function pago()
    {
        //one to one inverso, el prestamo pertenece a un cliente
        return $this->hasMany('App\Models\Prestamo\Pago');
    }
    
}
