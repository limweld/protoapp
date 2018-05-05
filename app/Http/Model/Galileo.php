<?php

namespace App\Http\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\QueryException;
use Laravel\Lumen\ErrorException;

use DB;

class Galileo extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [];

    private static $prev_id = null;

    /*
    |--------------------------------------------------------------
    |   GALILEO SLAVE
    |--------------------------------------------------------------
    */
        public static function galileo_data_slave(){

        }

        public static function galileo_data_slave_read($elements, $parentId = 0){
            $branch = array();
            foreach ($elements as $element) {
                if ($element['parent_path_id'] == $parentId) {
                    $children = Galileo::galileo_dev_pathmap($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                        
                    }
                    $branch[] = $element;
                }
            }

            return $branch;            
        }

        public static function get_datalink($link,$group,$date){    
            
            try {

                $data_obj = DB::connection('GALILEO_DATA_slave')
                ->table($group)
                ->select($link.'.*')
                ->join($link, $group.'.id', '=', $link.'.parent_id')
                ->whereBetween($group.'.date_insert', [$date, date("Y-m-d H:i:s")])
                ->get();

            } catch(QueryException $ex){ 
                return null;
            }

            return $data_obj;
        }
    
        public static function get_datagroup($link,$group,$date){            
             
            try {
              
                $data_obj = DB::connection('GALILEO_DATA_slave')
                ->table($link)
                ->select($group.'.*')
                ->join($group, $group.'.id', '=', $link.'.child_id')
                ->whereBetween($group.'.date_insert', [$date, date("Y-m-d H:i:s")])
                ->get();
           
            } catch(QueryException $ex){ 
                return null;    
            }

            return $data_obj;
        }
    
        

    /*
    |--------------------------------------------------------------
    |   GALILEO DEV
    |--------------------------------------------------------------
    */
        public static function galileo_dev_path($pathmap_id){
            $arr = DB::connection('GALILEO_dev')
            ->table('s_path')
            ->select('id','parent_path_id','custom_path_id','group_id','pathmap_id')
            ->where('pathmap_id','=',$pathmap_id)
            ->get();

            return json_decode(json_encode($arr),true);
        }

        public static function galileo_dev_pathmap($elements, $date_from, $date_to, $parentId = 0) {
            $branch = array();

            foreach ($elements as $element) {
                if ($element['parent_path_id'] == $parentId) {

                    $children = Galileo::galileo_dev_pathmap($elements, $date_from, $date_to, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }

                    $element['parent_group_id'] = Galileo::galileo_dev_findparentgroup($element['parent_path_id']);
                    $element['link']['table'] = "t_galileo_link_".$element['custom_path_id'];
                    //$element['link']['table_group'] = 't_galileo_group_'.$element['parent_group_id'];

                    $element['link']['row'] =  Galileo::get_datalink($element['link']['table'],'t_galileo_group_'.$element['parent_group_id'],$date_from);
                    
                    $element['group']['table'] = "t_galileo_group_".$element['group_id'];
                    $element['group']['row'] =  Galileo::get_datagroup($element['link']['table'],$element['group']['table'],$date_from);
                    
                    $element['date_from'] = $date_from;
                    $element['date_to'] = $date_to;
                    
                    $branch[] = $element;
                }                
            }

            return  json_decode(json_encode($branch),true);    
        }

        public static function galileo_data_dev_insert($data_obj){   
//            foreach   ($data_obj['row'] as $data){
//                  DB::table($data_obj['table'])->where('id', '=', $data['id'])->delete();
//                  DB::table($data _obj['table'])->insert($data);
//            }
        } 
        
        public static function galileo_dev_findparentgroup($custom_path_id){
            
            $arr = DB::connection('GALILEO_dev')
            ->table('s_path')
            ->select('group_id')
            ->where('custom_path_id','=',$custom_path_id)
            ->first();

            return json_decode(json_encode($arr),true)['group_id']; 
        }
}