<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
//use Session;


class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['unauthorized','login']]);
        $this->guard = "api";
    }
    
    public function unauthorized(){
        return response()->json(Response::HTTP_UNAUTHORIZED);
    }    
    
    public function login(Request $request) {
       
    $credencials = $request->only("email","password");
    if(! $token = auth($this->guard)->attempt($credencials)){
        return response()->json(['error' => 'Unauthorized'],401);
        //return response()->json($data,200,[]);
    }
    $token = $this->respondWithToken($token);
    //$user = response()->json(auth($this->guard)->user());
    //return response()->json(['token' => $token, 'user' => $user],200);
    return $this->respondWithToken($token);  
    }
    
    public function me(){
        return response()->json(auth($this->guard)->user());
        
    }
    
    public function logout(){
        auth($this->guard)->logout();
        return response()->json(['message' => 'Successfully loged out']);
    }
    
    
    
    public function refresh(){
        auth($this->guard)->logout();
        return $this->RespondWithToken(auth($this->guard)->refresh());
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
        $data = ['success'=> true,'usuario'=>$usuario];
        return response()->json($data,200,[]);   
  
    
    }
   
}
