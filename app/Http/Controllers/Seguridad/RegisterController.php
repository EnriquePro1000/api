<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
//use Symfony\Component\HttpFoundation\Response;
//use Session;


class RegisterController extends Controller
{

    public function register(Request $request) {
        /*
         * Valida si los campos están vacios,
         * y retorna error si alguno lo está
         */
        if($request->cedula === null    | $request->nombres === null | 
           $request->apellidos === null | $request->email === null | 
           $request->password === null  | $request->password_confirm === null ){
            return response()->json([
                'status' => "err_0",
                'result' => "Uno o mas campos vacios"
                ]);
           }
           
           /*
            * comprueba si la ceula está repetida
            */
           $err_1 = User::where("cedula",$request->cedula)->count();
           if($err_1>0){
               return response()->json([
                   'status' => "err_1",
                   'result' => "Cedula repetida"
                   ]);
           }
           
           /*
            * comprueba si el email está repetido
            */
           $err_2 = User::where("email",$request->email)->count();
           if($err_2>0){
               return response()->json([
                   'status' => "err_2",
                   'result' => "Email repetido"
                   ]);
           }
           
           /*
            * Comprueba si las contraseñas coinciden
            */
           $err_3 = 1;
           if($request->password === $request->password_confirm){
               $err_3 = 0;
           }
           
           if($err_3>0){
               return response()->json([
                   'status' => "err_3",
                   'result' => "Las contraseñas no coinciden"
                   ]);
           }
           
           /*
            * Comprueba si el usuario es administrador,
            * registra el nuevo usuario si lo es,
            * retorna error si no lo es
            */
           $userLogged = User::findOrFail(auth($this->guard)->id());
           if($userLogged["admin"] === 1){
               $user['tipide_id'] = 1;
               $user['admin'] = false;
               $user['cedula']=$request->cedula;
               $user['name1']=$request->nombres;
               $user['lastname1']=$request->apellidos;
               $user['email']= $request->email;
               $user['password']= bcrypt($request->password);
               $user['user_id']= $userLogged["id"];
               User::create($user);
               
               return response()->json([
                   'status' => "ok",
                   'result' => "el usuario ha sido registrado correctamente"
                   ]);
           }else{
               return response()->json([
                   'status' => "err_5",
                   'result' => "usted no tiene los permisos requeridos para realizar esta acción"
                   ]);
           }
          
      
      
       
        
      
        
      
    
    }
   
}
