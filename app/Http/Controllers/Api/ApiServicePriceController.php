<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Service;
use DB;

class ApiServicePriceController extends Controller{

    public function getAllPrice($params){

        if(isset($params['additional_filter'])){
            foreach($params['additional_filter'] as $par){
                $filter[$par['name']] = $par['value'];
            }
        }
        
        /*if($filter['date_from']){
            $myDateTime = \DateTime::createFromFormat('D, d M Y', $filter['date_from']);
            $date_from = $myDateTime->format('Y-m-d');
        }else{
            $date_from = date('Y-m-d');
        }*/

        // MAIN QUERY
        $datas = M_Service::whereRaw('1 = 1');

        if(isset($filter['state_active'])){
            if($filter['state_active'] == 'on'){
                $datas->where(function($query){
                    $query->where('state', '=', 'Y');
                });
            }
        }
        if(isset($filter['select_type'])){
            if($filter['select_type'] != ''){
                $service_category = $filter['select_type'];
                $datas->where(function($query) use($service_category){
                    $query->where('service_category', '=', $service_category);
                });
            }
        }

        // FILTER WHERE

        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){

                $q->orWhere('service_name', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('service_category', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('service_subcategory', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('price', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('created_at', 'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'id';
        }elseif($params['order'][0]['column'] == 1){
            $column = 'service_name';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'service_category';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'service_subcategory';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'price';
        }else{
            $column = 'id';
        }

        $datas->select('code_service', 'service_name', 'service_category', 'service_subcategory', 'price', 'created_at', 'state');
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

            $rows[$x][0] = $data->code_service;
            $rows[$x][1] = $data->service_name;
            $rows[$x][2] = $data->service_category;
            $rows[$x][3] = $data->service_subcategory;
            $rows[$x][4] = 'Rp. '.number_format($data->price,0,',','.').',-';
            $rows[$x][5] = substr($data->created_at, 0, 10);
            $rows[$x][6] = $data->state == 'Y'? 'Aktif' : 'Tidak Aktif';
            $rows[$x][7] = '
            <span style="cursor:pointer;color:blue;" data-toggle="tooltip" data-placement="top" title="Detail data harga pelayanan">
                <div class="btn btn-xs btn-info waves-effect form-service" id="dt-'.$x.'" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">launch</i>
                </div>
            </span>';

            if($data->state == 'Y'){
                $rows[$x][7] .= '<span data-toggle="tooltip" data-placement="top" title="Edit harga pelayanan">
                    <button  id="up-'.$x.'" data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column form-service" >
                        <i class="material-icons" style="font-size:15px">edit</i>
                    </button>
                </span>
                
                <span data-toggle="tooltip" data-placement="top" title="Non aktifkan harga pelayanan">
                    <div class="btn btn-xs btn-danger waves-effect delete-service" data-toggle="modal" data-target="#largeModal">
                        <i class="material-icons" style="font-size:15px">delete_forever</i>
                    </div>
                </span>';
            }
            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    
}


