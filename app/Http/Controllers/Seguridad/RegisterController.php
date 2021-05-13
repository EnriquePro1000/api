<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
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
           $request->password === null  | $request->password_confirm === null |
                $request->tipo_prestamo === null ){
            return response()->json([
                'status' => "err_0",
                'result' => "Uno o mas campos vacios"
                ]);
           }
           
           /*
            * comprueba si la ceula está repetida
            */
           $err_1 = User::where("identidad",trim($request->cedula))->count();
           if($err_1>0){
               return response()->json([
                   'status' => "err_1",
                   'result' => "Identidad repetida"
                   ]);
           }
           
           /*
            * comprueba si el email está repetido
            */
           $err_2 = User::where("email",trim($request->email))->count();
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
            * Comprueba el nivel del usuario
            */
           $userLogged = User::findOrFail(auth($this->guard)->id());
           
           if($userLogged['level'] === 3){ // si el usuario es empleado
                  return response()->json([ // no puede crear usuarios
                   'status' => "err_5",
                   'result' => "el usuario no esta autorizado"
                   ]);
               }
               
               $user['tipide_id'] = 1; // cedula por defecto
               if($userLogged['level'] === 1){ //si el usuario es admin
                   if($request->tipo_prestamo === "1"){
                       $user['level'] = 2; //crea un jefe
                   }
                   if($request->tipo_prestamo === "2"){
                       $user['level'] = 4; //crea un unico prestamista por mensualidades
                   }
                   
               }
               
               if($userLogged['level'] === 2){ // si el usuario es jefe
                   $user['level'] = 3; // crea un empleado
               }
               
               $user['identidad']= trim($request->cedula);
               $user['name1']= trim($request->nombres);
               $user['lastname1']= trim($request->apellidos);
               $user['email']= trim($request->email);
               $user['password']= bcrypt($request->password);
               $user['user_id']= $userLogged["id"];
              User::create($user);
               
               return response()->json([
                   'status' => "ok",
                   'result' => "el usuario ha sido registrado correctamente"
                   ]);
    
               
           }
          
    
    
      
       
        
      
        
      
    
    }
   

