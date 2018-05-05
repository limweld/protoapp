<?php

namespace App\Http\Controllers;

use App\Http\Model\Store;
use App\Http\Model\Storeretailer;
use App\Http\Model\Storeretailereloading;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

class StoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function create_store(Request $request){
        
        $obj_data = Store::create($request->all());
        $request['store_id'] = $obj_data->id;
        $obj_data = Storeretailer::create($request->all());
        $obj_data = Storeretailereloading::create($request->all());

        return response()->json($request);
    }

    public function read_store(Request $request){

        $obj_data_store = Store::where('id','=',$request['store_id'])->first();
        $obj_data_retailer = Storeretailer::where('store_id','=',$request['store_id'])->first();
        $obj_data_eloading = Storeretailereloading::where('store_id','=',$request['store_id'])->first();

        $obj_data['store_id'] = $obj_data_retailer->store_id;
        $obj_data['name'] = $obj_data_store->name;
        $obj_data['location'] = $obj_data_store->location;
        $obj_data['telco'] = $obj_data_eloading->telco;
        $obj_data['telcoproducts'] = $obj_data_eloading->telcoproducts;
        $obj_data['mobilenumber'] = $obj_data_eloading->mobilenumber;
        $obj_data['fullname'] = $obj_data_retailer->fullname;
        $obj_data['sales_id'] = $obj_data_retailer->sales_id;

        return response()->json($obj_data);
    }

    public function update_store(Request $request){
        
        $obj_data_store = Store::where('id','=',$request['store_id'])->first();
        $obj_data_store->name = $request['name'];
        $obj_data_store->location = $request['location'];
        $obj_data_store->save();
        
        $obj_data_eloading = Storeretailereloading::where('store_id','=',$request['store_id'])->first();
        $obj_data_eloading->telco = $request['telco'];
        $obj_data_eloading->telcoproducts = $request['telcoproducts'];
        $obj_data_eloading->mobilenumber = $request['mobilenumber'];
        $obj_data_eloading->save();

        $obj_data_retailer = Storeretailer::where('store_id','=',$request['store_id'])->first();
        $obj_data_retailer->fullname = $request['fullname'];
        $obj_data_retailer->sales_id = $request['sales_id'];    
        $obj_data_retailer->save();

        $obj_data['name'] = $obj_data_store->name;
        $obj_data['location'] = $obj_data_store->location;
        $obj_data['telco'] = $obj_data_eloading->telco;
        $obj_data['telcoproducts'] = $obj_data_eloading->telcoproducts;
        $obj_data['mobilenumber'] = $obj_data_eloading->mobilenumber;
        $obj_data['fullname'] = $obj_data_retailer->fullname;
        $obj_data['sales_id'] = $obj_data_retailer->sales_id;

        return response()->json($obj_data);
    }

    public function delete_store(Request $request){
        
        $obj_data_store = Store::where('id','=',$request['store_id'])->first();
        $obj_data = Store::where('id','=',$request['store_id'])->delete();
        $obj_data = Storeretailer::where('store_id','=',$request['store_id'])->delete();
        $obj_data = Storeretailereloading::where('store_id','=',$request['store_id'])->delete();

        return response()->json($obj_data_store);
    }
    

    
}
