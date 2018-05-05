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

use Carbon\Carbon;


class ManagementController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
    }

/*
|--------------------------------------------------------------------------
| LEADS
|--------------------------------------------------------------------------
*/		
	
	public function delete_leads(Request $request){
				
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

	 	$data_obj = null;
	 	$data_obj['success'] = false;

		$account_obj = User::where('username','=',$pieces[0])
						->where('api_token','=',$request->api_token)
						->first();

		if($account_obj!=null){

	  		$data_obj['content'] = Inquiredpackage::where('id','=',$request->inquired_id)
	  			->where('rep_id','=',$account_obj->id)
	  			->delete();

	  		$data_obj['success'] = $data_obj['content'] == 1 ? true : false;
	
	  		return response()->json($data_obj);
		}

		return response()->json($data_obj);					
	}

	public function view_leads(Request $request){		
		
		$pieces = explode(":",base64_decode($request->account));	
		$find_obj = User::where('username','=',$pieces[0])->first();	
		$data_obj = null;	
		
		if($request->status == 4){

		$data_obj["totalrows"] = Inquiredpackage::
				join('tracks', 'inquiredpackages.track_id', '=', 'tracks.id')
				->select('inquiredpackages.id')
				->where('inquiredpackages.rep_id','=',$find_obj->id)
				->where('tracks.client_fullname','like','%'.$request->filtered.'%')
				->count();

		$data_obj["leading"] = Inquiredpackage::
				join('tracks', 'inquiredpackages.track_id', '=', 'tracks.id')
				->select(
					'inquiredpackages.id as inquired_id',
					'tracks.id',
					'inquiredpackages.package_id',
					'inquiredpackages.cost',
					'inquiredpackages.rep_id',
					'inquiredpackages.status',
					'inquiredpackages.sales_stage',
					'inquiredpackages.source',
					'tracks.client_fullname',
					'tracks.client_position',
					'tracks.client_email',
					'tracks.client_contact',
					'tracks.client_location',
					'tracks.company_name',
					'tracks.company_email',
					'tracks.company_location',
					'tracks.company_contact',
					'tracks.remarks')
				->where('inquiredpackages.rep_id','=',$find_obj->id)
				->where('tracks.client_fullname','like','%'.$request->filtered.'%')
				->orderBy('tracks.client_fullname', 'asc')
	 	        ->take($request->rangerow)->skip($request->skiprow)
		 		->get();

        return $data_obj;

		}

		$data_obj["totalrows"] = Inquiredpackage::
				join('tracks', 'inquiredpackages.track_id', '=', 'tracks.id')
				->select('inquiredpackages.id')
				->where('inquiredpackages.rep_id','=',$find_obj->id)
				->where('tracks.client_fullname','like','%'.$request->filtered.'%')
				->where('inquiredpackages.status','=',$request->status)
				->count();

		$data_obj["leading"] = Inquiredpackage::
				join('tracks', 'inquiredpackages.track_id', '=', 'tracks.id')
				->select(
					'inquiredpackages.id as inquired_id',
					'tracks.id',
					'inquiredpackages.package_id',
					'inquiredpackages.cost',
					'inquiredpackages.rep_id',
					'inquiredpackages.status',
					'inquiredpackages.sales_stage',
					'inquiredpackages.source',
					'tracks.client_fullname',
					'tracks.client_position',
					'tracks.client_email',
					'tracks.client_contact',
					'tracks.client_location',
					'tracks.company_name',
					'tracks.company_email',
					'tracks.company_location',
					'tracks.company_contact',
					'tracks.remarks')
				->where('inquiredpackages.rep_id','=',$find_obj->id)
				->where('tracks.client_fullname','like','%'.$request->filtered.'%')
				->where('inquiredpackages.status','=',$request->status)
				->orderBy('tracks.client_fullname', 'asc')
	 	        ->take($request->rangerow)->skip($request->skiprow)
		 		->get();

        return $data_obj;

	}

/*
|--------------------------------------------------------------------------
| MANAGMENT
|--------------------------------------------------------------------------
*/		

	/*
	| PACKAGES
	|--------------------------------------------------------------------------
	*/

	// public function add_packages(Request $request){
		// return "test";
	// }

	// public function update_packages(Request $request){
		// return "test";
	// }

	// public function delete_packages(Request $request){
		// return "test";
	// }

	public function view_packages(Request $request){

		$data_obj = null;	
		
		$data_obj["totalrows"] = Hilsoftmatrixpackage::
			where('name','like','%'.$request->filtered.'%')
			->count();
			
	 	$data_obj["packages"] = 		
		 		Hilsoftmatrixpackage::where('name','like','%'.$request->filtered.'%')
		 		->orderBy('name', 'asc')
	 	        ->take($request->rangerow)->skip($request->skiprow)
		 		->get();
		
		return $data_obj;

	}
	
	/*
	| INQUIRED PACKAGES
	|--------------------------------------------------------------------------
	*/

	public function add_inquired_packages(Request $request){
		return "test";	
	}

	public function update_inquired_packages(Request $request){

		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);	

		$account_obj = User::where('username','=',$pieces[0])
		 				->where('api_token','=',$request->api_token)
		 				->first();

		$data_obj = null;
		$data_obj['success'] = false;

	  if($account_obj!=null){

  		 $data_obj['content'] = Inquiredpackage::
  			where('id','=',$request->inquired_id)
  			->where('rep_id','=',$account_obj->id)
  			->first();

			$data_obj['content']->package_id = $request->package_id;
			$data_obj['content']->cost = $request->cost;
			$data_obj['content']->status = $request->status;
			
			$data_obj['content']->sales_stage = $request->sales_stage;
			$data_obj['content']->source = $request->source;

			$data_obj['content']->save();
			$data_obj['success'] = true ;

			return $data_obj;	
	  	}

		return response()->json($data_obj);					
	
	}

	public function delete_inquired_packages(Request $request){
		return "test";	
	}

	public function view_inquired_packages(Request $request){
		
		$data_obj = null;
		
		$data_obj['title'] = Hilsoftmatrixpackage::where("id","=",$request->package_id)->first();

		$data_obj['packages'] = Hilsoftmatrixprice::
			join('hilsoftmatrixmodules', 'hilsoftmatrixprices.module_id', '=', 'hilsoftmatrixmodules.id')
			->join('hilsoftmatrixlicenses','hilsoftmatrixprices.license_id','=', 'hilsoftmatrixlicenses.id')
			->join('hilsoftmatrixpackages','hilsoftmatrixprices.package_id','=', 'hilsoftmatrixpackages.id')
			->select(
				'hilsoftmatrixprices.package_id',
				'hilsoftmatrixpackages.name as package',
				'hilsoftmatrixlicenses.name as license',
				'hilsoftmatrixmodules.name as module',
				'hilsoftmatrixprices.price'
			)
			->where('hilsoftmatrixprices.package_id','=',$request->package_id)
			->get();

		return $data_obj;
	}

	/*
	| LEADING LOGS
	|--------------------------------------------------------------------------
	*/
		/*
		| TASKS
		|--------------------------------------------------------------------------
		*/
			public function add_tasks(Request $request){
				//return "test";
			
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$account_obj = User::where('username','=',$pieces[0])
								->where('api_token','=',$request->api_token)
								->first();

				$data_obj = null;
				$data_obj['success'] = false;

				if($account_obj!=null){

					$data_obj['success'] = true;
					$data_obj['content'] = Task::create($request->all());
					
					return response()->json($data_obj);
				}

				return response()->json($data_obj);					
			}

		
			
			public function update_tasks(Request $request){
				
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$account_obj = User::where('username','=',$pieces[0])
								->where('api_token','=',$request->api_token)
								->first();

				$data_obj = null;
				$data_obj['success'] = false;

				if($account_obj!=null){

				$data_obj['content'] = Task::where('id','=',$request->id)->first();
				
				$data_obj['content']->commit = $request->commit;
				$data_obj['content']->save();
				$data_obj['success'] = true ;

				return $data_obj;	
				}

				return response()->json($data_obj);					
			}
			
			public function delete_tasks(Request $request){

				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$data_obj = null;
				$data_obj['success'] = false;

				$account_obj = User::where('username','=',$pieces[0])
				->where('api_token','=',$request->api_token)
				->first();

				if($account_obj!=null){

				$data_obj['content'] = Task::where('id','=',$request->id)->delete();

				$data_obj['success'] = $data_obj['content'] == 1 ? true : false;
				return response()->json($data_obj);
				}

				return response()->json($data_obj);									

			}

			public function view_tasks(Request $request){
				$data_obj = null;

				$data_obj["totalrows"] = Task::
					where('event_id','=',$request->event_id)
					->count();
					
				$data_obj["commited"] = Task::
					where('event_id','=',$request->event_id)
					->where('commit','=',1)
					->count();

				
				$data_obj["content"] = Task::
					where('event_id','=',$request->event_id)
					->take($request->rangerow)->skip($request->skiprow)
					->orderBy('id', 'desc')
					->get();
				
				return $data_obj;		
			}

		/*
		| TIMELINE
		|--------------------------------------------------------------------------
		*/
			public function add_event(Request $request){
				
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$account_obj = User::where('username','=',$pieces[0])
					->where('api_token','=',$request->api_token)
					->first();
					
				$data_obj = null;
				$data_obj['success'] = false;

				if($account_obj!=null){
									
					$date_from = Carbon::createFromFormat('Y-m-d H:i a', $request->date_from, 'asia/taipei');
					$date_to = Carbon::createFromFormat('Y-m-d H:i a', $request->date_to, 'asia/taipei');
					
					$request['date_from'] = $date_from->setTimezone('UTC');
					$request['date_to'] = $date_to->setTimezone('UTC');
					
					$request['rep_id'] = $account_obj->id;
					$data_obj['success'] = true;
					$data_obj['content'] = Event::create($request->all());
				
				}
			
				return response()->json($data_obj);
			}
			
			public function update_event(Request $request){
				//return "test";
				
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$data_obj = null;
				$data_obj['success'] = false;

				$account_obj = User::where('username','=',$pieces[0])
					->where('api_token','=',$request->api_token)
					->first();
					
				if($account_obj!=null){

					 $data_obj['content'] = Event::
						where('inquired_id','=',$request->inquired_id)
						->where('id','=',$request->id)->first();

					$date_from = Carbon::createFromFormat('Y-m-d H:i a', $request->date_from, 'asia/taipei');
					$date_to = Carbon::createFromFormat('Y-m-d H:i a', $request->date_to, 'asia/taipei');

					$data_obj['content']->date_from = $date_from->setTimezone('UTC');
					$data_obj['content']->date_to = $date_to->setTimezone('UTC');
					
					//$data_obj['content']->date_from = $request->$date_from;
					//$data_obj['content']->date_to = $request->$date_to;

					$data_obj['content']->bookmark = $request->bookmark;
					$data_obj['content']->description = $request->description;

					$data_obj['content']->save();

					$data_obj['success'] =  true ;

					return $data_obj;	
				}

				return response()->json($data_obj);					


			}

			public function delete_event(Request $request){				
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$data_obj = null;
				$data_obj['success'] = false;

				$account_obj = User::where('username','=',$pieces[0])
					->where('api_token','=',$request->api_token)
					->first();

				if($account_obj!=null){

				$data_obj['content'] = Event::where('id','=',$request->event_id)->delete();

				$data_obj['success'] = $data_obj['content'] == 1 ? true : false;
					return response()->json($data_obj);
				}
				
				return response()->json($data_obj);									
			}

			public function view_event(Request $request){
				$data_obj = null;
				
				$data_obj["totalrows"] = Event::
					where('inquired_id','=',$request->inquired_id)
					->count();

				$data_obj["content"] = Event::
					where('inquired_id','=',$request->inquired_id)
					->orderBy('date_from', 'desc')
					->take($request->rangerow)->skip(0)
					->get();
				
				return $data_obj;				
			}

		/*
		| LEADING STATUS
		|--------------------------------------------------------------------------
		*/
			public function update_leading_status(Request $request){
				return "test";
				
				$encrypted_cookies = base64_decode($request->account);
				$pieces = explode(":",$encrypted_cookies);	

				$data_obj = null;
				$data_obj['success'] = false;

				$account_obj = User::where('username','=',$pieces[0])
					->where('api_token','=',$request->api_token)
					->first();
			}

		
	/*
	| PROPOSAL
	|--------------------------------------------------------------------------
	*/		
		
	// public function add_proposal(Request $request){
		// return "test";	
	// }

	// public function update_proposal(Request $request){
		// return "test";	
	// }

	// public function delete_proposal(Request $request){
		// return "test";	
	// }

	// public function view_proposal(Request $request){
		// return "test";		
	// }
		

}
