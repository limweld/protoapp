<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        
    }
	
	
	public function login(Request $request){

		$data_obj = null;

		$username = User::where('username','=',$request['username'])->first();

		if(is_null($username)){
	
		 	$email = User::where('email','=',$request['username'])->first();

		 	if(is_null($email)){
				
			 	$contact = User::where('contact','=',$request['username'])->first();

		 		if(is_null($contact)){
				
					$data_obj["success"] = false;
					$data_obj["token"] = "";

					return $data_obj;
		 		}
	
				$data_obj["success"] = password_verify($request['password'], $contact->password)?true : false;
				$data_obj["token"] = password_verify($request['password'], $contact->password)?$contact->api_token : "";
				$data_obj["fullname"] = password_verify($request['password'], $contact->password)? $contact->fullname : "";
				$data_obj["permission"] = password_verify($request['password'], $contact->password)? $contact->permission : "";
				$data_obj["id"] = password_verify($request['password'], $contact->password)? $contact->id : "";
				$data_obj["type"] = password_verify($request['type'], $contact->password)? $contact->type : "";


				return $data_obj;
			
		 	}
	
			$data_obj["success"] = password_verify($request['password'], $email->password)?true : false;
			$data_obj["token"] = password_verify($request['password'], $email->password)?$email->api_token : "";
			$data_obj["fullname"] = password_verify($request['password'], $email->password)? $email->fullname : "";
			$data_obj["permission"] = password_verify($request['password'], $email->password)? $email->permission : "";
			$data_obj["id"] = password_verify($request['password'], $email->password)? $email->id : "";
			$data_obj["type"] = password_verify($request['password'], $email->password)? $email->type : "";


			return $data_obj;

		}

		$data_obj["success"] = password_verify($request['password'], $username->password)?true : false;
		$data_obj["token"] = password_verify($request['password'], $username->password)? $username->api_token : "";
		$data_obj["fullname"] = password_verify($request['password'], $username->password)? $username->fullname : "";
		$data_obj["permission"] = password_verify($request['password'], $username->password)? $username->permission : "";
		$data_obj["id"] = password_verify($request['password'], $username->password)? $username->id : "";
		$data_obj["type"] = password_verify($request['password'], $username->password)? $username->type : "";


		return $data_obj;
	}
		
	// public function register(Request $request)
	// {
	// 	$representative = Representative::where('email', '=', $request['email'])
	// 									->orWhere('contact','=', $request['contact'])
	// 									->first();
		
	// 	if ($representative === null) {

	// 		$request['api_token'] = str_random(60);
	// 		$request['password'] = app('hash')->make('default');
	// 		$request['username'] = $request->email;
			
	// 		$user = Representative::create($request->all());
	
	// 		return response("{\"success\":true}");	   
	// 	}
		
	// 	return response("{\"success\":false}");
	// }
	
	// public function reset()
	// {
	// 	return "reset"; 		
	// }
}
