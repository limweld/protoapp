<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Event extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

	protected $fillable = [
		'rep_id',
		'inquired_id',
		'date_from' ,
		'date_to',
		'description',
		'bookmark',
    ];
}
