<?php

namespace App\Models\Prestamos;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    
    public $timestamps = false;
    
    protected $fillable = [
        "id",
        "cliente_id",    
        "prestamo_id",    
        "num_cuota",    
        "tipopago", 
        "pagocompleto", 
        "valor_deuda_inicial", 
        "ganancias", 
        "por_cobrar", 
        "mespago", 
        "fechpago", 
        "valor_pago", 
        "usuario_id", 
        ];
    
     public function cliente()
    {
        //one to one inverso, el prestamo pertenece a un cliente
        return $this->belongsTo('App\Models\Seguridad\Cliente');
    }
    
}
