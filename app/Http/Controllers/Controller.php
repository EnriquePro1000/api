<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
      public function __construct() {
         header('Access-Controll-Allow-Origin',"*");
         header('Access-Controll-Allow-Methods',"PUT,POST,DELETE,GET,OPTIONS");
         header('Access-Controll-Allow-Headers',"Accept,Authorization,Content-Type");
        $this->middleware('auth:api', ['except' => ['unauthorized','login','users']]);
        $this->guard = "api";
    }
    
}
