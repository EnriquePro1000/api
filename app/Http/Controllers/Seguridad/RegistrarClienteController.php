<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cliente;



class RegistrarClienteController extends Controller
{  
   
  
    public function register(Request $request) {
        
        /*
         * valida si algun campo vital está vacio
         */
        if($request->cedula === null | $request->nombres === null | 
           $request->apellidos === null | $request->direccion === null | 
           $request->telefono === null){
            return response()->json([
                'status' => "err_0",
                'result' => "Uno o mas campos vacios".$request->file
                ]);
           }
           
        /*
         * valida si el numero de identidad que está enviando el cliente
         * ya ha sido utilizado por el usuario que abre el credito, 
         * el cliente puede ser registrado por otros usuarios
         */
           $a = Cliente::where("identidad",$request->cedula)
                ->where("usuario_id",auth($this->guard)->id())
                ->count();
           
        if($a > 0){
            return response()->json([
                'status' => "err_1",
                'result' => "Usted tiene otro usuario con esta identificación"
                ]);
        }        
        
        /*
         * procedimiento a seguir si enviaron un file desde el front
         */
        if($request->hasFile("file")){
            //almacena el archivo recibido en una variable
            $file = $request->file('file');
            /*
             * valida si el tamaño del archivo es menor a 8 mb
             */
            if($file->getSize() > 8000000){
                return response()->json([
                'status' => "err_2",
                'result' => "Su archivo pesa mas de 8 mb"
                ]);
            }
            //obtenemos nombre y extensión del archivo
            $name = $file->getClientOriginalName();
            $ext  = $file->getClientOriginalExtension();
            
            /*
             * valida si el archivo es jpeg, jpg, png o pdf, la validación
             * del tamaño la hace el front por ahora
             */
            if($ext === "jpeg" | $ext === "jpg" | $ext === "png" | $ext === "pdf" |
               $ext === "JPEG" | $ext === "JPG" | $ext === "PNG" | $ext === "PDF"){
                //Hará que el nombre sea practicamente irrepetible
                $random = date("Y_m_d_H_i_s")."id".auth($this->guard)->id();
                //movemos el archivo a la carpeta public/CedulasClientes
            $file->move('CedulasClientes', $name);
            //renombramos el archivo para mayor maniobrabilidad
            rename ("CedulasClientes/".$name, "CedulasClientes/".$random.".".$ext);
            //almacenamos el nuevo nombre en la base de datos
            $cliente['file'] = "CedulasClientes/".$random.".".$ext;
            }else{
                  return response()->json([
                'status' => "err_2",
                'result' => "El archivo que está enviando no es valido"
                ]);
                
            }            
        }else{
            $cliente['file'] = "NoFound.jpg";
        }
        
        /*
         * almacena los datos que vienen del front en variables
         */
        $cliente['tipide_id'] = 1; //cedula por defecto
        $cliente['identidad'] = trim($request->cedula);         
        $cliente['name1'] = trim($request->nombres);
        $cliente['lastname1'] = trim($request->apellidos);
        $cliente['telefono'] = trim($request->telefono);
        $cliente['direccion'] = trim($request->direccion);
        $cliente['prestamoactivo'] = false;
        $cliente['usuario_id'] = auth($this->guard)->id();
        Cliente::create($cliente);
          return response()->json([
                'status' => "ok",
                'result' => "todo ha ido correctamente"
                ]);
                
    }
    
    
 
    
  
}
