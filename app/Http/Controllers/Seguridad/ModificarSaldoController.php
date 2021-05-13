<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Prestamos\Saldo;



class ModificarSaldoController extends Controller
{  
    
    public function ModificarSaldo(Request $request){
        
        $user = User::findOrFail(auth($this->guard)->id());
        
        if($request->tipo === null | $request->cantidad === null){
               return response()->json([
                'status' => "error_2",
                'result' => "campos vacios"
                ]); 
        }
         if($request->cantidad <= 0 ){
               return response()->json([
                'status' => "error_3",
                'result' => "numero menor a 0"
                ]); 
        }
         if($request->cantidad > 4200000000 ){
               return response()->json([
                'status' => "error_1",
                'result' => "la bbdd no puede manejar una cantidad tan grande"
                ]); 
        }
            
   
        
         if($request->tipo === "true"){
        $saldo["tipo"] = 1;
        $saldo["ingresado"] = $request->cantidad;
        $saldo["usuario_id"] = auth($this->guard)->id();
        Saldo::create($saldo);
        $upd["cupo"] = $user["cupo"] + $request->cantidad;
        $user->update($upd);
        
         return response()->json([
                'status' => "ok_true",
                'result' => "el cupo fue actualizado correctamente"
                ]);      
    }
    
    if($request->tipo === "false"){
        if($request->cantidad <= $user["cupo"]){
            $saldo["tipo"] = 0; 
            $saldo["ingresado"] = $request->cantidad;
        $saldo["usuario_id"] = auth($this->guard)->id();
        Saldo::create($saldo);        
      
         $upd["cupo"] = $user["cupo"] - $request->cantidad;
        $user->update($upd);
        
          return response()->json([
                'status' => "ok_false",
                'result' => "el cupo fue actualizado correctamente"
                ]); 
        }else{
            return response()->json([
                'status' => "error_0",
                'result' => "no puedes restar mas que el cupo actual"
                ]); 
        } 
        
    }
    }    

}
   