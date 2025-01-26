<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Queue_Consult;
use DB;

class ApiConsultController extends Controller{

    public function getQueueConsult($params){

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
        $datas = M_Queue_Consult::
        

            leftJoin('kmu_ps_visus as a', 
                'kmu_ps_queue_docter.code_visus',                       '=', 'a.code_visus')->
                
            leftJoin('kmu_ps_queue_visus_normal as b', 
                'a.code_queue_visus_normal',                            '=', 'b.code_queue_visus_normal')->

            leftJoin('kmu_ps_booking as c', 
                'b.code_booking',                                       '=', 'c.code_booking')->

            leftJoin('kmu_us_docter_schedule_time as d', 
                'c.code_us_docter_booking_time',                        '=', 'd.code_us_docter_schedule_time')->

            leftJoin('kmu_us_docter_schedule_day as e', 
                'd.code_us_docter_schedule_day',                        '=', 'e.code_us_docter_schedule_day')->

            leftJoin('kmu_us_patient as f', 
                'c.code_patient',                                       '=', 'f.code_patient')->

            leftJoin('kmu_us_docter as g', 
                'c.code_docter',                                        '=', 'g.code_docter')->

            leftJoin('kmu_ps_consult as h', 
                'kmu_ps_queue_docter.code_queue_docter',                '=', 'h.code_queue_docter');


        $datas->where('a.state', 'Y')->where('g.code_docter', auth()->user()->docter->code_docter);

        if(isset($filter['current'])){
            if($filter['current'] == 'on'){
                $datas->where(function($query){
                    $query->where('h.is_done', '=', 'N')->orWhereNull('h.id');
                });
                // $datas->where('d.time_start', '<=', date('H:i:s'))->where('e.day', strtoupper(date('D')));
            }
        }

        $datas->whereBetween('c.booking_tanggal', [$date_from, $date_to]);

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('kmu_ps_queue_docter.queue_no',         'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('f.id_rekam_medis',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('f.nama_pasien',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('e.day',                                'LIKE', '%'.engDay($params['search']['value']).'%');
                $q->orWhere('c.booking_tanggal',                    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.time_start',                         'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.time_end',                           'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('g.nama_dokter',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ps_queue_docter.created_at',       'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_ps_queue_docter.id';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'kmu_ps_queue_docter.queue_no';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'f.id_rekam_medis';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'g.nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'c.booking_tanggal';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'd.time_start';
        }elseif($params['order'][0]['column'] == 7){
            $column = 'kmu_ps_queue_docter.created_at';
        }else{
            $column = 'kmu_ps_queue_docter.queue_no';
        }
        $datas->select('kmu_ps_queue_docter.code_queue_docter', 'kmu_ps_queue_docter.queue_no', 'kmu_ps_queue_docter.created_at', 'f.id_rekam_medis', 'f.nama_pasien', 'e.day', 'd.time_start', 'd.time_end', 'g.nama_dokter', 'c.booking_tanggal', 'h.is_done');

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

            $rows[$x][0] = $data->code_queue_docter;
            $rows[$x][1] = '<b>KONSULTASI</b>';
            $rows[$x][2] = $data->queue_no;
            $rows[$x][3] = '<span>'.$data->id_rekam_medis.'</span>';
            $rows[$x][4] = $data->nama_pasien;
            $rows[$x][5] = $data->nama_dokter;
            $rows[$x][6] = indoDay($data->day).', '.$data->booking_tanggal;
            $rows[$x][7] = $data->time_start.' - '.$data->time_end;
            // $rows[$x][7] = substr($data->created_at, 11, 8);
            
            $rows[$x][8] = '<button onclick="play  (\''.$data->queue_no.'\', \''.str_replace(' ', '. ', $data->nama_pasien).'\', \'dokter\');" class="untouch-column btn btn-xs btn-info waves-effect" data-toggle="tooltip" data-placement="top" title="Panggil Pasien '.$data->nama_pasien.'"><i class="material-icons" style="font-size:15px">volume_up</i></button>
            
            <span data-toggle="tooltip" data-placement="top" title="Isi Konsultasi Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-consult" >
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


