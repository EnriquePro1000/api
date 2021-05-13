<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{   //instalar  paquete tymon: composer require tymon/jwt-auth:dev-develop --prefer-source
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipide_id',
        'level',
        'cupo',
        'identidad',
        'name1',
        'name2',
        'lastname1',
        'lastname2',
        'email',
        'password',
        'api_token',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getJWTCustomClaims(): array {
        return [];
        
    }

    public function getJWTIdentifier() {
        return $this->getKey();
        
    }

}
