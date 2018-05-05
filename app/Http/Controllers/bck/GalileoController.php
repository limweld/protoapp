<?php

namespace App\Http\Controllers;

use App\Http\Model\Galileo;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;

use Auth;

use App\Http\Controllers\Controller;

class GalileoController extends Controller
{
    public function __construct(){

    }

    public function galileo_dev_data_insert(){

    }   

    public function galileo_pathmap(Request $request){
        $temp_index_id = null;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $row = Galileo::galileo_dev_path($request->pathmap_id);
        $tree = Galileo::galileo_dev_pathmap($row,$date_from, $date_to);

        return $tree;
      
        // foreach($tree as $key => $value){
        //     if($value['group_id'] == $request['group_id']){
        //         $temp_index_id = $key;
        //     }
        // }

        //return $temp_index_id;

//        $path = json_decode(json_encode($tree), true);

//        return $path[$temp_index_id];
    }

    public function post_test(Request $request){
        return $request;
    }
}
