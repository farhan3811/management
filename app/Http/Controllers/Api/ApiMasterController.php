<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Master_Medicine;
use App\Models\M_Master_Medicine_Stock;
use App\Models\M_Master_Medicine_Detail;
use App\Models\M_Master_Lab;
use App\Models\M_Master_Lab_Group;
use DB;

class ApiMasterController extends Controller{

    public function getMedicine($params){

        // MAIN QUERY
        $datas = M_Master_Medicine::

            leftJoin('kmu_ms_dt_medicine as a', function($join)
                         {
                             $join->on('kmu_ms_medicine.code_medicine', '=', 'a.code_medicine');
                             $join->where('a.state', '=', 'Y');
                         }
                    )->
                
            leftJoin('kmu_ms_medicine_stock as b', function($join)
            {
                $join->on('kmu_ms_medicine.code_medicine', '=', 'b.code_medicine');
                $join->on('b.state','=',DB::raw("'Y'"));
            })->
                
            leftJoin('kmu_ms_medicine_unit as c', 
                'kmu_ms_medicine.code_medicine_unit',                        '=', 'c.code_medicine_unit');


        $datas->where('kmu_ms_medicine.state',                          '=', 'Y');

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('nama_obat',                            'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('c.satuan',                             'LIKE', '%'.$params['search']['value'].'%');
                // $q->orWhere('kmu_ms_medicine.created_at',           'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('harga_jual',                           'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('harga_beli_satuan',                    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('stock',                                'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 1){
            $column = 'rownum';
        }elseif($params['order'][0]['column'] == 2){
            $column = DB::raw('MAX(nama_obat)');
        }elseif($params['order'][0]['column'] == 3){
            $column = DB::raw('MAX(c.satuan)');
        }elseif($params['order'][0]['column'] == 4){
            $column = DB::raw('SUM(stock)');
        }elseif($params['order'][0]['column'] == 5){
            $column = DB::raw('MAX(harga_beli_satuan)');
        }elseif($params['order'][0]['column'] == 6){
            $column = DB::raw('MAX(harga_jual)');
        }else{
            $column = DB::raw('MAX(kmu_ms_medicine.id)');
        }
        
        $datas->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'kmu_ms_medicine.code_medicine', DB::raw('MAX(kmu_ms_medicine.created_at) AS created_at'), DB::raw('MAX(nama_obat) AS nama_obat'), DB::raw('MAX(satuan) AS satuan'), DB::raw('sum(stock) AS stock'), DB::raw('(SELECT harga_beli_satuan FROM kmu_ms_medicine_stock WHERE id = MAX(b.id)) AS harga_beli_satuan'), DB::raw('(SELECT harga_jual FROM kmu_ms_dt_medicine WHERE id = MAX(a.id)) AS harga_jual'));
        $datas->groupBy('kmu_ms_medicine.code_medicine');

        $datas->orderBy($column, $params['order'][0]['dir']);
        
        //FILTER PAGINATION & LIMIT
        $alldatas = $datas->get();
        $total = $alldatas->count();

        DB::statement(DB::raw('set @rownum=0'));

        if($params['length'] != -1){
            $datas->limit($params['length'])->offset($params['start']);
        }
        
        $datas = $datas->get();

        $rows   = array();
        $x      = 0;

        
        //READY TO PASSING !
        foreach($datas as $key => $data){

            $rows[$x][0] = $data->code_medicine;
            $rows[$x][1] = $data->rownum;
            $rows[$x][2] = $data->nama_obat;
            $rows[$x][3] = $data->satuan;
            $rows[$x][4] = ($data->stock != '')? $data->stock : 0;
            $rows[$x][5] = ($data->harga_beli_satuan != '')? $data->harga_beli_satuan : '<i>Belum Diinput</i>';
            
            if($data->harga_jual == ''){
                $harga_jual = '<i>Belum Diinput</i>';
            }else{
                $harga_jual = $data->harga_jual;
            }

            $rows[$x][6] ='
            <span style="cursor:pointer;color:blue;" data-toggle="tooltip" data-placement="top" title="click for more detail">
                <span class="waves-effect price-medicine" data-toggle="modal" data-target="#largeModal">
                    <u>'.$harga_jual.'</u>
                </span>
            </span>';
            $rows[$x][7] = '
            <span data-toggle="tooltip" data-placement="top" title="Detail Stock">
                <div class="btn btn-xs bg-indigo waves-effect stock-medicine" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">shopping_cart</i>
                </div>
            </span>

            <span data-toggle="tooltip" data-placement="top" title="Detail Obat">
                <div class="btn btn-xs btn-info waves-effect form-price-medicine" id="dt-'.$x.'" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">launch</i>
                </div>
            </span>
            
            <span data-toggle="tooltip" data-placement="top" title="Ubah Obat">
                <div class="btn btn-xs btn-warning waves-effect form-price-medicine" id="up-'.$x.'" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">edit</i>
                </div>
            </span>
            
            <span data-toggle="tooltip" data-placement="top" title="Hapus Obat">
                <div class="btn btn-xs btn-danger waves-effect delete-medicine" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">delete_forever</i>
                </div>
            </span>';
            $x++;
        }                 
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;  
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    public function getMedicineStock($params){

        // MAIN QUERY
        $datas = M_Master_Medicine_Stock::

            leftJoin('kmu_ms_medicine as a', 
                'a.code_medicine',                        '=', 'kmu_ms_medicine_stock.code_medicine');

        $datas->where('kmu_ms_medicine_stock.state',                          '=', 'Y');

        if(isset($params['additional_filter'])){
            if(!empty($params['additional_filter'])){
                foreach($params['additional_filter'] as $filter){
                    $datas->where('kmu_ms_medicine_stock.code_medicine',      '=', $filter['value']);
                }
            }
        }

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('harga_beli_satuan',                    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('harga_beli_total',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('stock',                                'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ms_medicine_stock.created_at',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ms_medicine_stock.created_by',     'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 1){
            $column = 'rownum';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'stock';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'harga_beli_satuan';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'harga_beli_total';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'kmu_ms_medicine_stock.created_at';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'kmu_ms_medicine_stock.created_by';
        }else{
            $column = 'kmu_ms_medicine_stock.id';
        }
        
        $datas->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'kmu_ms_medicine_stock.id', 'kmu_ms_medicine_stock.stock', 'kmu_ms_medicine_stock.created_at', 'harga_beli_satuan', 'harga_beli_total', 'kmu_ms_medicine_stock.created_by');

        $datas->orderBy($column, $params['order'][0]['dir']);
        
        //FILTER PAGINATION & LIMIT
        $alldatas = $datas;
        if($params['length'] != -1){
            $datas->limit($params['length'])->offset($params['start']);
        }

        DB::statement(DB::raw('set @rownum=0'));

        //READY TO PASSING !
        $datas = $datas->get();
        $total = $alldatas->count();


        $rows   = array();
        $x      = 0;

        foreach($datas as $key => $data){

            $rows[$x][0] = $data->id;
            $rows[$x][1] = $data->rownum;
            $rows[$x][2] = $data->stock;
            $rows[$x][3] = $data->harga_beli_satuan;
            $rows[$x][4] = $data->harga_beli_total;
            $rows[$x][5] = $data->created_at;
            $rows[$x][6] = $data->created_by;
            $rows[$x][7] = /*'

            <span data-toggle="tooltip" data-placement="top" title="Detail Obat">
                <div class="btn btn-xs btn-info waves-effect detail-medicine" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">launch</i>
                </div>
            </span>
            
            <span data-toggle="tooltip" data-placement="top" title="Ubah Obat">
                <div class="btn btn-xs btn-warning waves-effect entry-medicine" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">edit</i>
                </div>
            </span>'*/
            
            '<span data-toggle="tooltip" data-placement="top" title="Hapus Obat">
                <div class="btn btn-xs btn-danger waves-effect delete-stock-medicine" >
                    <i class="material-icons" style="font-size:15px">delete_forever</i>
                </div>
            </span>';
            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    public function getMedicinePrice($params){

        // MAIN QUERY
        $datas = M_Master_Medicine_Detail::

            leftJoin('kmu_ms_medicine as a', 
                'a.code_medicine',                                          '=', 'kmu_ms_dt_medicine.code_medicine');

        if(isset($params['additional_filter'])){
            if(!empty($params['additional_filter'])){
                foreach($params['additional_filter'] as $filter){
                    $datas->where('kmu_ms_dt_medicine.code_medicine',       '=', $filter['value']);
                }
            }
        }

        $datas->where('kmu_ms_dt_medicine.isShow',       '=', 'Y');

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('harga_jual',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ms_dt_medicine.created_at',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ms_dt_medicine.created_by',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ms_dt_medicine.state',          'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 1){
            $column = 'rownum';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'harga_jual';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'kmu_ms_dt_medicine.created_at';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'kmu_ms_dt_medicine.created_by';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'kmu_ms_dt_medicine.state';
        }else{
            $column = 'kmu_ms_dt_medicine.id';
        }
        
        $datas->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'kmu_ms_dt_medicine.code_detail_medicine', 'kmu_ms_dt_medicine.harga_jual', 'kmu_ms_dt_medicine.created_at', 'kmu_ms_dt_medicine.created_by', 'kmu_ms_dt_medicine.state');

        $datas->groupBy('kmu_ms_dt_medicine.id');

        $datas->orderBy($column, $params['order'][0]['dir']);
        
        //FILTER PAGINATION & LIMIT
        
        //FILTER PAGINATION & LIMIT
        $lastprice = $datas;
        
        $alldatas = $datas->get();
        $total = $alldatas->count();

        DB::statement(DB::raw('set @rownum=0'));

        if($params['length'] != -1){
            $datas->limit($params['length'])->offset($params['start']);
        }

        //READY TO PASSING !
        $datas = $datas->get();

        $rows   = array();
        $x      = 0;

        foreach($datas as $key => $data){

            $rows[$x][0] = $data->code_detail_medicine;
            $rows[$x][1] = $data->rownum;
            $rows[$x][2] = $data->harga_jual;
            $rows[$x][3] = $data->created_at;
            $rows[$x][4] = $data->created_by;
            $rows[$x][5] = ($data->state == 'Y')? 'AKTIF' : 'TIDAK AKTIF';
            $rows[$x][6] = /*'
            
            <span data-toggle="tooltip" data-placement="top" title="Ubah Obat">
                <div class="btn btn-xs btn-warning waves-effect entry-medicine" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">edit</i>
                </div>
            </span>'*/
            
            '<span data-toggle="tooltip" data-placement="top" title="Hapus Obat">
                <div class="btn btn-xs btn-danger waves-effect delete-price-medicine" >
                    <i class="material-icons" style="font-size:15px">delete_forever</i>
                </div>
            </span>';
            $x++;

        }
                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;

        $lastprice = $lastprice->Where('kmu_ms_dt_medicine.state', '=', 'Y')->orderBy('kmu_ms_dt_medicine.id', 'desc')->get()->first();

        $result['lastprice'] = isset($lastprice)? $lastprice->harga_jual : 0;
        
        return $result;
    }

    

    public function getLaboratorium($params){

        // MAIN QUERY
        $datas = M_Master_Lab::
                
            leftJoin('kmu_ms_lab_group as a', 
                'kmu_ms_lab.code_lab_group',                        '=', 'a.code_lab_group');


        $datas->where('kmu_ms_lab.state',                          '=', 'Y');

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('detail_lab',                       'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('nilai_normal',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('satuan',                           'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('group_lab',                        'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 1){
            $column = 'rownum';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'detail_lab';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'group_lab';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'nilai_normal';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'satuan';
        }else{
            $column = 'kmu_ms_lab.id';
        }
        
        $datas->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'kmu_ms_lab.code_lab', 'kmu_ms_lab.created_at', 'detail_lab', 'nilai_normal', 'group_lab', 'satuan', 'kmu_ms_lab.code_lab_group');

        $datas->groupBy('kmu_ms_lab.id');

        $datas->orderBy($column, $params['order'][0]['dir']);
        
        //FILTER PAGINATION & LIMIT
        $alldatas = $datas->get();
        $total = $alldatas->count();

        DB::statement(DB::raw('set @rownum=0'));

        if($params['length'] != -1){
            $datas->limit($params['length'])->offset($params['start']);
        }
        
        $datas = $datas->get();

        $rows   = array();
        $x      = 0;

        
        //READY TO PASSING !
        foreach($datas as $key => $data){

            $rows[$x][0] = $data->code_lab;
            $rows[$x][1] = $data->rownum;
            $rows[$x][2] = $data->detail_lab;
            $rows[$x][3] = $data->group_lab;
            $rows[$x][4] = $data->nilai_normal;
            $rows[$x][5] = $data->satuan;
            $rows[$x][6] = '

            <span data-toggle="tooltip" data-placement="top" title="Detail Lab">
                <div class="btn btn-xs btn-info waves-effect form-price-medicine" id="dt-'.$x.'" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">launch</i>
                </div>
            </span>
            
            <span data-toggle="tooltip" data-placement="top" title="Ubah Lab">
                <div class="btn btn-xs btn-warning waves-effect form-price-medicine" id="up-'.$x.'" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">edit</i>
                </div>
            </span>
            
            <span data-toggle="tooltip" data-placement="top" title="Hapus Lab">
                <div class="btn btn-xs btn-danger waves-effect delete-lab" data-toggle="modal" data-target="#largeModal">
                    <i class="material-icons" style="font-size:15px">delete_forever</i>
                </div>
            </span>';
            $x++;
        }                 
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;  
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }
}


