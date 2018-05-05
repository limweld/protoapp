<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Track extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
		'client_fullname',
		'client_position',
		'client_email',
		'client_contact',
		'client_location',
		'company_name',
		'company_email',
		'company_contact',
		'company_location',
		'remarks',
		'rep_id',
    ];
}
