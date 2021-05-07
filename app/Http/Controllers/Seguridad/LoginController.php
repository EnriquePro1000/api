<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{

    public function login(Request $request){
        /*
         * Comprueba si el email enviado existe
         */
        $err_1 = User::where("email",$request->email)->count();
        if($err_1 < 1){
            return response()->json([
                'status' => "err_1",
                'result' => "El correo no existe"
                ]);
        }

        $credencials = $request->only("email","password");
        /*
         * Comprueba si el pass coincide
         */
        if(! $token = auth($this->guard)->attempt($credencials)){
        return response()->json([
            'status' => "err_2",
            'result' => "password incorrecto"
        ]);
    }
    
    /*
     * Encapsula el access_token en una variable
     */
    $api_token =  collect(json_decode($this->respondWithToken($token)
            ->content()))->unique('access_token');
    
    /*
     * Almacena el token del usuario en la bbdd
     */
    $user = User::findOrFail(auth($this->guard)->id());
    $upd["api_token"] = $api_token["access_token"];
    $user->update($upd);
     
    /*
     * Envia el usuario con el nuevo token al front
     */
     $upd_user = User::findOrFail(auth($this->guard)->id());
     return response()->json([
         'status' => "ok",
         'result' => $upd_user
             ]);
    }

    public function logout(){
        auth($this->guard)->logout();
        return response()->json([
            'status' => "ok",
            'result' => 'Successfully loged out'
            ]);
    }
    
    protected function RespondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL()*60
        ]);
    }
    
      public function users() { 
            $usuario = User::all();
           return response()->json([
         'status' => "ok",
         'result' => $usuario
             ]);
        
      
    
    }
}

    /*  
    public function unauthorized(){
         return response()->json([
            'status' => "error",
            'result' => "usuario no autorizado"
        ]);
    }
   */
    
    /*
    public function me(){
        return response()->json(auth($this->guard)->user());
        
    }
    */
    
    /*
    public function refresh(){
        auth($this->guard)->logout();
        $this->RespondWithToken(auth($this->guard)->refresh());
        $api_token =  collect(json_decode($this->RespondWithToken(auth($this->guard)->refresh())->content()))->unique('access_token');
     $user = User::findOrFail(auth($this->guard)->id());
     $upd["api_token"] = $api_token["access_token"];
     $user->update($upd);
     
     $ultuser = User::findOrFail(auth($this->guard)->id());
     
        return response()->json([
            'status' => "ok",
            'result' => $ultuser
        ]);
        
    }
    */
    
    /*
    protected function RespondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL()*60
        ]);
    }
    */
    
/*
    public function users() {      
        
        $usuario = User::all();
        $data = ['success'=> true,'usuario'=>$usuario];
        return response()->json($data,200,[]);   
  
    
    }
   */

