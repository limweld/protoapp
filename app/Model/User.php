<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
		'fullname',
		'contact',                        
		'email',
		'username',
		'permission',
		'password',
		'api_token',
		'type',
    ];

    protected $hidden = [
        'password',
		'api_token',
    ];
}
