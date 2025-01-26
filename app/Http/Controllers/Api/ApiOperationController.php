<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Consult_Reqlab;
use App\Models\M_Consult_Operation_Agreement;
use DB;

class ApiOperationController extends Controller{

    public function getQueueOp($params){

        foreach($params['additional_filter'] as $par){
            $filter[$par['name']] = $par['value'];
        }
        
        if($filter['date_from']){
            $myDateTime = \DateTime::createFromFormat('D, d M Y', $filter['date_from']);
            $date_from = $myDateTime->format('Y-m-d');
        }else{
            $date_from = date('Y-m-d');
        }

        if($filter['date_to']){
            $myDateTime = \DateTime::createFromFormat('D, d M Y', $filter['date_to']);
            $date_to = $myDateTime->format('Y-m-d');
        }else{
            $date_to = date('Y-m-d');
        }

        // MAIN QUERY
        $datas =  M_Consult_Operation_Agreement::
        
            leftJoin('kmu_ps_consult as a', 
                'kmu_ps_afct_operation_agreement.code_consult',         '=', 'a.code_consult')->
                
            leftJoin('kmu_ps_queue_docter as b', 
                'a.code_queue_docter',                                  '=', 'b.code_queue_docter')->

            leftJoin('kmu_ps_visus as c', 
                'b.code_visus',                                         '=', 'c.code_visus')->

            leftJoin('kmu_ps_queue_visus_normal as d', 
                'c.code_queue_visus_normal',                            '=', 'd.code_queue_visus_normal')->

            leftJoin('kmu_ps_booking as e', 
                'd.code_booking',                                       '=', 'e.code_booking')->

            leftJoin('kmu_us_patient as f', 
                'e.code_patient',                                       '=', 'f.code_patient')->

            leftJoin('kmu_us_docter as g', 
                'kmu_ps_afct_operation_agreement.docter_code_of_operation', '=', 'g.code_docter')->

            leftJoin('kmu_ps_afct_reqlab as h', 
                'a.code_consult', '=', 'h.code_consult')->

            leftJoin('kmu_us_docter_schedule_time as i', 
                'e.code_us_docter_booking_time',                        '=', 'i.code_us_docter_schedule_time')->

            leftJoin('kmu_us_docter_schedule_day as j', 
                'i.code_us_docter_schedule_day',                        '=', 'j.code_us_docter_schedule_day')->

            leftJoin('kmu_ps_afct_operation as k', 
                'k.code_operation_agreement',                        '=', 'kmu_ps_afct_operation_agreement.code_operation_agreement');


        $datas->where('kmu_ps_afct_operation_agreement.state',                    '=', 'Y');
        $datas->where('kmu_ps_afct_operation_agreement.isAgree',                  '=', 'Y');
        $datas->where('h.is_done',                                                '=', 'Y');
        $datas->where('h.state',                                                  '=', 'Y');
        // $datas->where('k.state',                                                  '=', 'Y');


        if(isset($filter['current'])){
            if($filter['current'] == 'on'){
                $datas->where(function($query){
                    $query->where('k.is_done', '=', 'N')->orWhereNull('k.id');
                });
                // $datas->where('i.time_start',               '<=', date('H:i:s'));
                // $datas->where('j.day',                      '=', strtoupper(date('D')));
            }
        }

        $datas->whereBetween('e.booking_tanggal', [$date_from, $date_to]);

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('id_rekam_medis',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('nama_pasien',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('nama_dokter',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ps_afct_operation_agreement.created_at',       'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY substr($data->created_at, 11, 8)
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_ps_afct_operation_agreement.id';
        }elseif($params['order'][0]['column'] == 1){
            $column = 'kmu_ps_afct_operation_agreement.id';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'id_rekam_medis';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'nama_pasien';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'substr(kmu_ps_afct_operation_agreement.created_at, 0, 10)';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'substr(kmu_ps_afct_operation_agreement.created_at, 11, 8)';
        }else{
            $column = 'kmu_ps_afct_operation_agreement.id';
        }
        $datas->select('kmu_ps_afct_operation_agreement.code_operation_agreement', 'kmu_ps_afct_operation_agreement.created_at', 'j.day', 'id_rekam_medis', 'nama_pasien', 'nama_dokter', 'k.is_done', 'e.booking_tanggal');

        // $datas->groupBy('a.code_consult');

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
            $state = ($data->is_done == "Y")? "done" : "clear";
            $stateName = ($data->is_done == "Y")? "Status : Selesai" : "Status : Belum Selesai";
            $btncolor = ($data->is_done == "Y")? "success" : "danger";

            $rows[$x][0] = $data->code_operation_agreement;
            $rows[$x][1] = '<b>OPERASI</b>';
            $rows[$x][2] = '<span data-toggle="tooltip" data-placement="top" title="'.$data->nama_pasien.'"><u>'.$data->id_rekam_medis.'</u></span>';
            $rows[$x][3] = $data->nama_dokter;
            $rows[$x][4] = indoDay($data->day).', '.$data->booking_tanggal;
            $rows[$x][5] = substr($data->created_at, 0, 10);
            $rows[$x][6] = substr($data->created_at, 11, 8);
            $rows[$x][7] = '
            
            <span data-toggle="tooltip" data-placement="top" title="Isi Konsultasi Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-lab" >
                    <i class="material-icons" style="font-size:15px">edit</i>
                </button>
            </span>
            
            <button data-toggle="tooltip" style="margin-left:3px" class="btn btn-xs btn-'.$btncolor.' waves-effect untouch-column status-consult" data-toggle="tooltip" data-placement="top" title="'.$stateName.'">
                <i class="material-icons" style="font-size:15px">'.$state.'</i>
            </button>';
            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    
}


