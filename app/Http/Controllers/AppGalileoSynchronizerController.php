<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

use App\Model\AppGalileoSynchronizer;

class AppGalileoSynchronizerController extends Controller
{
    public function __construct()
    {
		  $this->middleware('auth');        
    }
}

