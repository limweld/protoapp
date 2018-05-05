<?php

namespace App\Http\Controllers;

use App\Model\Track;
use App\Model\Inquiredpackage;
use App\Model\User;
use App\Model\Hilsoftmatrixprice;
use App\Model\Hilsoftmatrixmodule;
use App\Model\Hilsoftmatrixpackage;
use App\Model\Event;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Auth;

use Illuminate\Support\Facades\DB;

//use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');        
    }

/*
|--------------------------------------------------------------------------
| NOTIFICATION
|--------------------------------------------------------------------------
*/
    public function total_status_counts(Request $request){	
        $encrypted_cookies = base64_decode($request->account);
        $pieces = explode(":",$encrypted_cookies);  

        $data_obj = null;
        $data_obj['success'] = false;

        $account_obj = User::where('username','=',$pieces[0])
                        ->where('api_token','=',$request->api_token)
                        ->first();

        if($account_obj!=null){			
           $data_obj['total'] = Inquiredpackage::
					where('rep_id','=',$account_obj->id)
					 ->selectRaw('status,count(status) as quantity, sum(cost) as total')
					->groupBy('status')
					->get();
                   
            $data_obj['success'] = true;
    
            return response()->json($data_obj);
        }

        return response()->json($data_obj);
    }

    public function total_reminders_counts(){
        return "test";
    }

/*
|--------------------------------------------------------------------------
| CHARTS
|--------------------------------------------------------------------------
*/
    public function view_bar_chart(Request $request){
        return "test";
		
		
    }

    // public function view_pie_chart(){
        // return "test";
		
    // }

/*
|--------------------------------------------------------------------------
| LOGS
|--------------------------------------------------------------------------
*/
    public function view_reminders_logs(Request $request){
		
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);  

		$data_obj = null;
		$data_obj['success'] = false;

		$account_obj = User::where('username','=',$pieces[0])
		->where('api_token','=',$request->api_token)
		->first();

		if($account_obj!=null){			
			$data_obj['total'] = Event::
			where('rep_id','=',$account_obj->id)
			->count();
						
			$data_obj["content"] = Event::where('rep_id','=',$account_obj->id)
				->orderBy('date_from', 'desc')
				->take($request->rangerow)
				->skip($request->skiprow)
				->get();
			
			$data_obj['success'] = true;
			
			return response()->json($data_obj);
		}

		return response()->json($data_obj);
    } 
    
    public function view_bookmarks_logs(Request $request){
		
		$encrypted_cookies = base64_decode($request->account);
		$pieces = explode(":",$encrypted_cookies);  

		$data_obj = null;
		$data_obj['success'] = false;

		$account_obj = User::where('username','=',$pieces[0])
		->where('api_token','=',$request->api_token)
		->first();

		if($account_obj!=null){			
			$data_obj['total'] = Event::
			where('rep_id','=',$account_obj->id)
				->where('bookmark','=',1)
				->count();
						
			$data_obj["content"] = Event::where('rep_id','=',$account_obj->id)
				->where('bookmark','=',1)
				->orderBy('date_from', 'desc')
				->take($request->rangerow)
				->skip($request->skiprow)
				->get();
			
			$data_obj['success'] = true;
			
			return response()->json($data_obj);
		}

		return response()->json($data_obj);
	}
	

/*
|--------------------------------------------------------------------------
| Dash 1
|--------------------------------------------------------------------------
*/

	public function dashboard_00001_create(Request $request){

	}

	public function dashboard_00001_read(Request $request){
		
		$data_obj = DB::select("
			select count(*) as totalrows
			from(
				select
				SUM(amount) as 'Total Amount'
				from (
				select date_insert, gm_704 as amount, 'f' as type from t_galileo_group_117
				union all
				select date_insert, gm_798 as amount, 'p' as type from t_galileo_group_129
				union all 
				select date_insert, gm_657 as amount, 's' as type from t_galileo_group_106
			)x
			group by
			year(x.date_insert), 
			month(x.date_insert),
			quarter(x.date_insert),
			week(x.date_insert))
			as x;
		");

		$data_obj['data'] = DB::select("select
			year(x.date_insert) as 'Year',
			quarter(x.date_insert) as 'Quarter',
			monthname(x.date_insert) as 'Month',
			week(x.date_insert) as 'Week',
			sum(CASE WHEN x.type = 's' THEN amount ELSE 0 END) as sample_1, 
			sum(CASE WHEN x.type = 'f' THEN amount ELSE 0 END) as sample_2,
			sum(CASE WHEN x.type = 'P' THEN amount ELSE 0 END) as sample_3,
			SUM(amount) as 'Total Amount'
			from (
			select date_insert, gm_704 as amount, 'f' as type from t_galileo_group_117
			union all
			select date_insert, gm_798 as amount, 'p' as type from t_galileo_group_129
			union all 
			select date_insert, gm_657 as amount, 's' as type from t_galileo_group_106
			)x
			group by
			year(x.date_insert), 
			month(x.date_insert),
			quarter(x.date_insert),
			week(x.date_insert)
 
			limit 10 offset 120;
		");

		return response()->json($data_obj);
	}

}
