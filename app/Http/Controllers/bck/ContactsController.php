<?php

namespace App\Http\Controllers;

use App\Model\Track;
use App\Model\Inquiredpackage;
use App\Model\User;
use App\Model\Hilsoftmatrixprice;
use App\Model\Hilsoftmatrixmodule;
use App\Model\Hilsoftmatrixpackage;
use App\Model\Task;
use App\Model\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

class ContactsController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');        
    }

/*
|--------------------------------------------------------------------------
| CONTACTS
|--------------------------------------------------------------------------
*/	
	public function add_contacts(Request $request){
					
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

		$account_obj = User::where('username','=',$pieces[0])
						->where('api_token','=',$request->api_token)
						->first();

	 	$data_obj = null;
	 	$data_obj['success'] = false;

		if($account_obj!=null){

	  		$request['rep_id'] = $account_obj->id;
		 	$data_obj['success'] = true;
	  		$data_obj['content'] = Track::create($request->all());
			
	  		return response()->json($data_obj);
		}

		return response()->json($data_obj);					
	}
	
	public function update_contacts(Request $request){
		
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

		$account_obj = User::where('username','=',$pieces[0])
		 				->where('api_token','=',$request->api_token)
		 				->first();

		$data_obj = null;
		$data_obj['success'] = false;

		if($account_obj!=null){

	   		$data_obj['content'] = Track::where('id','=',$request->track_id)
	   					->where('rep_id','=',$account_obj->id)
	   					->first();

			$data_obj['content']->client_fullname = $request->client_fullname;
			$data_obj['content']->client_position = $request->client_position;
			$data_obj['content']->client_email = $request->client_email;
			$data_obj['content']->client_contact = $request->client_contact;
			$data_obj['content']->client_location = $request->client_location;
			$data_obj['content']->company_name = $request->company_name;
			$data_obj['content']->company_email = $request->company_email;
			$data_obj['content']->company_contact = $request->company_contact;
			$data_obj['content']->company_location = $request->company_location;
			$data_obj['content']->remarks = $request->remarks;

			$data_obj['content']->save();

			$data_obj['success'] =  true ;

			return $data_obj;	
		}

		return response()->json($data_obj);					
		
	}
	
	public function delete_contacts(Request $request){
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

		$account_obj = User::where('username','=',$pieces[0])
						->where('api_token','=',$request->api_token)
						->first();

	 	$data_obj = null;
	 	$data_obj['success'] = false;

		if($account_obj!=null){

	  		$data_obj['content'] = Track::where('id','=',$request->track_id)
	  			->where('rep_id','=',$account_obj->id)
	  			->delete();

	  		$data_obj['success'] = $data_obj['content'] == 1 ? true : false;
	
	  		return response()->json($data_obj);
		}

		return response()->json($data_obj);					
	}

	public function view_contacts(Request $request){		
		
		$pieces = explode(":",base64_decode($request->account));	
		
		$find_obj = User::where('username','=',$pieces[0])->first();	

		$data_obj = null;	
		
		$data_obj["totalrows"] = Track::where('client_fullname','like','%'.$request->filtered.'%')
		 		->where('rep_id','=',$find_obj->id)
		 		->count();
			
	 	$data_obj["contacts"] = 		
		 		Track:: where('client_fullname','like','%'.$request->filtered.'%')
		 		->where('rep_id','=',$find_obj->id)
		 		->orderBy('client_fullname', 'asc')
	 	        ->take($request->rangerow)->skip($request->skiprow)
		 		->get();
		
		return $data_obj;
	}

	public function view_users(Request $request){
		
		$pieces = explode(":",base64_decode($request->account));	

		$data_obj = null;	
		
		$data_obj["totalrows"] = User::where('type','=',$request->type)
				->where('genealogy_id','=',$request->user_id)
				->where('fullname','like','%'.$request->filtered.'%')
		 		->count();
			
	 	$data_obj["users"] = User::where('type','=',$request->type)
	 			->where('genealogy_id','=',$request->user_id)
	 			->where('fullname','like','%'.$request->filtered.'%')
		 		->orderBy('fullname', 'asc')
	 	        ->take($request->rangerow)->skip($request->skiprow)
		 		->get();

		$data_obj["status"] = true;
		
		return response()->json($data_obj);
	}

	public function view_clients(Request $request){		

		$data_obj = null;	
		
		$data_obj["totalrows"] = Track::where('rep_id','=',$request->rep_id)
				->where('client_fullname','like','%'.$request->filtered.'%')
		 		->count();
			
	 	$data_obj["clients"] = Track::where('rep_id','=',$request->rep_id)
	  			->where('client_fullname','like','%'.$request->filtered.'%')
		  		->orderBy('client_fullname', 'asc')
	  	        ->take($request->rangerow)->skip($request->skiprow)
		  		->get();

		return response()->json($data_obj);
	}


/*
|--------------------------------------------------------------------------
| LEADS
|--------------------------------------------------------------------------
*/		
	public function add_leads(Request $request){
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

		$account_obj = User::where('username','=',$pieces[0])
						->where('api_token','=',$request->api_token)
						->first();

	 	$data_obj = null;
	 	$data_obj['success'] = false;

		if($account_obj!=null){

			$request['status'] = 0;
			$request['sales_stage'] = 0;
			$request['cost'] = 0;
	  		$request['rep_id'] = $account_obj->id;
		 	$data_obj['success'] = true;
	  		$data_obj['content'] = Inquiredpackage::create($request->all());
			
	  		return response()->json($data_obj);
		}

		return response()->json($data_obj);					
	}

	public function view_lead(Request $request){
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

	 	$data_obj = null;
	 	$data_obj['success'] = false;

		$account_obj = User::where('username','=',$pieces[0])
						->where('api_token','=',$request->api_token)
						->first();

		if($account_obj!=null){
	  		return response()->json($data_obj);
		}

		return response()->json($data_obj);					
	}

	public function check_leads(Request $request){

		$data_obj["totalrows"] = Inquiredpackage::where('track_id','=',$request->track_id)->count();
	
		return response()->json($data_obj);					

	}
}
