<?php

namespace App\Http\Controllers;

use App\Http\Model\Store;
use App\Http\Model\Storeretailer;
use App\Http\Model\Storeretailereloading;
use App\Http\Model\Bugtracker;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

class BugtrackerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function create_bugtracker(Request $request){
        $obj_data = Bugtracker::create($request->all());
        return response()->json($obj_data);
    }

    public function read_bugtracker(Request $request){

    }

    public function update_bugtracker(Request $request){

    }

    public function delete_bugtracker(Request $request){

    }
}