<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use DB;

class ApiUserController extends Controller{

    public function getUsers($params){

        // MAIN QUERY
        $datas = User::
        
            leftJoin('role_user as a', 
                'users.id',                      '=', 'a.user_id')->
                
            leftJoin('roles as b', 
                'a.role_id',                     '=', 'b.id');

        // FILTER WHERE
        $datas->where('b.name', '!=', 'patient');
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('email',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('display_name',              'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('users.created_at',          'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('users.updated_at',          'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        if($params['order'][0]['column'] == 0){
            $column = 'users.id';
        }elseif($params['order'][0]['column'] == 1){
            $column = 'users.id';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'email';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'display_name';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'users.created_at';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'users.updated_at';
        }else{
            $column = 'users.id';
        }

        $datas->select('users.id', 'email', 'username', 'display_name', 'users.created_at', 'users.updated_at');

        $datas->orderBy($column, $params['order'][0]['dir']);
        
        //FILTER PAGINATION & LIMIT
        $alldatas = $datas->get();
        if($params['length'] != -1){
            $datas->limit($params['length'])->offset($params['start']);
        }

        //READY TO PASSING !
        $datas = $datas->get();
        $total = $alldatas->count();

        $rows   = array();
        $x      = 0;
        
        foreach($datas as $key => $data){

            $rows[$x][0] = $data->id;
            $rows[$x][1] = $data->id;
            $rows[$x][2] = $data->email;
            $rows[$x][3] = $data->username;
            $rows[$x][4] = $data->display_name;
            $rows[$x][5] = $data->created_at != null? $data->created_at->toDateTimeString() : '';
            $rows[$x][6] = $data->created_at != null? $data->updated_at->toDateTimeString() : '';
            $rows[$x][7] = '';

            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

}


