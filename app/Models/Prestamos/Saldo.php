<?php

namespace App\Models\Prestamos;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldos';
    
    protected $fillable = [
        "id",
        "ingresado",
        "tipo",
        "usuario_id",
        ];
    
    
//     public function prestamo()
//    {
//        //one to one inverso, el abono pertenece a un prestamo
//        return $this->belongsTo('Faktor\Infrastructure\Models\Prestamos\Prestamo');
//    }
//    
//     public function fkcliente()
//    {
//        //one to one inverso, el prestamo pertenece a un cliente
//        return $this->belongsTo('Faktor\Infrastructure\Models\Seguridad\FKCliente');
//    }
}
