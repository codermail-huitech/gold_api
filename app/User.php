<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $visible = ['id',
        'person_name',
        'email',
        'mobile1',
        'mobile2',
        'customer_category_id',
        'address1',
        'address2',
        'state',
        'city',
        'po',
        'area',
        'pin'];
    protected $guarded = ['id'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'inforced' => 'boolean','email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }


}
