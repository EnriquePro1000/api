<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Seguridad\Usuario;
//use Session;


class RegisterController extends Controller
{

    public function register(Request $request) {
        
        $this->validate($request, ['numide' => 'required|string|max:50|unique:usuarios']);
        $this->validate($request, ['email' => 'required|string|email|max:255|unique:usuarios']);
        
         $user['tipide_id']=1;
         $user['numide']=$request->numide;
         $user['nom1']=$request->nom1;
         $user['ape1']=$request->ape1;
         $user['email']= $request->email;
         $user['password']= bcrypt($request->password);
        
         if(Auth::check()){
              $user['usuario_id']= auth()->id();
         } else{
              $user['usuario_id']= 99999;
         }
         
         
         Usuario::create($user);
         
         
        $data = ['success'=> true,'usuario'=>$user];
        return response()->json($data,200,[]);

    
    }
   
}
