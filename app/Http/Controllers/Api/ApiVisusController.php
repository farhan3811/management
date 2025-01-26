<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Queue_Visus;
use App\Models\M_Visus;
use App\Models\M_Queue_Kacamata;
use DB;

class ApiVisusController extends Controller{

    public function getQueueVisus($params){

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
        $datas = M_Queue_Visus::
        

            leftJoin('kmu_ps_booking as a', 
                'kmu_ps_queue_visus_normal.code_booking',               '=', 'a.code_booking')->

            leftJoin('kmu_us_docter_schedule_time as b', 
                'a.code_us_docter_booking_time',                        '=', 'b.code_us_docter_schedule_time')->

            leftJoin('kmu_us_docter_schedule_day as c', 
                'b.code_us_docter_schedule_day',                        '=', 'c.code_us_docter_schedule_day')->

            leftJoin('kmu_us_patient as d', 
                'a.code_patient',                                       '=', 'd.code_patient')->

            leftJoin('kmu_us_docter as e', 
                'a.code_docter',                                        '=', 'e.code_docter')->

            leftJoin('kmu_ps_visus as f', 
                'kmu_ps_queue_visus_normal.code_queue_visus_normal',    '=', 'f.code_queue_visus_normal');


        $datas->where('a.state',                    '=', 'Y');

        if(isset($filter['current'])){
            if($filter['current'] == 'on'){
                $datas->where(function($query){
                    $query->where('f.is_done', '=', 'N')->orWhereNull('f.id');
                });
                // $datas->where('b.time_start', '<=', date('H:i:s'))->where('c.day', strtoupper(date('D')));
            }
        }

        $datas->whereBetween('a.booking_tanggal', [$date_from, $date_to]);

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('queue_no',         'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.id_rekam_medis', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.nama_pasien',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('c.day',            'LIKE', '%'.engDay($params['search']['value']).'%');
                $q->orWhere('a.booking_tanggal','LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_start',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_end',       'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('e.nama_dokter',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ps_queue_visus_normal.created_at', 'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_ps_queue_visus_normal.id';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'queue_no';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'd.id_rekam_medis';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'e.nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'a.booking_tanggal';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'b.time_start';
        }elseif($params['order'][0]['column'] == 7){
            $column = 'kmu_ps_queue_visus_normal.created_at';
        }else{
            $column = 'kmu_ps_queue_visus_normal.queue_no';
        }
        $datas->select('kmu_ps_queue_visus_normal.code_queue_visus_normal', 'queue_no', 'kmu_ps_queue_visus_normal.created_at', 'd.id_rekam_medis', 'd.nama_pasien', 'c.day', 'b.time_start', 'b.time_end', 'e.nama_dokter', 'a.booking_tanggal', 'f.is_done');
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

            $rows[$x][0] = $data->code_queue_visus_normal;
            $rows[$x][1] = '<b>PEMERIKSAAN</b>';
            $rows[$x][2] = $data->queue_no;
            $rows[$x][3] = '<span>'.$data->id_rekam_medis.'</span>';
            $rows[$x][4] = $data->nama_pasien;
            $rows[$x][5] = $data->nama_dokter;
            $rows[$x][6] = indoDay($data->day).', '.$data->booking_tanggal;
            $rows[$x][7] = $data->time_start.' - '.$data->time_end;
            // $rows[$x][7] = substr($data->created_at, 11, 8);
            $rows[$x][8] = '<button  onclick="play(\''.$data->queue_no.'\', \''.str_replace(' ', '. ', $data->nama_pasien).'\', \'visus\');" class="untouch-column btn btn-xs btn-info waves-effect" data-toggle="tooltip" data-placement="top" title="Panggil Pasien '.$data->nama_pasien.'"><i class="material-icons" style="font-size:15px">volume_up</i></button>
            
            <span data-toggle="tooltip" data-placement="top" title="Isi Visus Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-visus" >
                    <i class="material-icons" style="font-size:15px">edit</i>
                </button>
            </span>
            
            <button data-toggle="tooltip" style="margin-left:3px" class="btn btn-xs btn-'.$btncolor.' waves-effect untouch-column status-visus" data-toggle="tooltip" data-placement="top" title="'.$stateName.'">
                <i class="material-icons" style="font-size:15px">'.$state.'</i>
            </button>';
            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    public function getQueueKacamata($params){

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
        $datas = M_Queue_Kacamata::
        

            leftJoin('kmu_ps_booking as a', 
                'kmu_ps_queue_visus_glasses.code_booking',              '=', 'a.code_booking')->

            leftJoin('kmu_us_docter_schedule_time as b', 
                'a.code_us_docter_booking_time',                        '=', 'b.code_us_docter_schedule_time')->

            leftJoin('kmu_us_docter_schedule_day as c', 
                'b.code_us_docter_schedule_day',                        '=', 'c.code_us_docter_schedule_day')->

            leftJoin('kmu_us_patient as d',     
                'a.code_patient',                                       '=', 'd.code_patient')->

            leftJoin('kmu_us_docter as e', 
                'a.code_docter',                                        '=', 'e.code_docter')->

            leftJoin('kmu_ps_afct_glasses as f', 
                'kmu_ps_queue_visus_glasses.code_queue_visus_glasses',  '=', 'f.code_queue_visus_glasses')->
        ////
            leftJoin('kmu_ps_queue_visus_normal as v', 
                'v.code_booking',                        '=', 'a.code_booking')->
            leftJoin('kmu_ps_visus as w', 
                'v.code_queue_visus_normal',                        '=', 'w.code_queue_visus_normal')->
            leftJoin('kmu_ps_queue_docter as x', 
                'x.code_visus',                        '=', 'w.code_visus')->
            leftJoin('kmu_ps_consult as y', 
                'y.code_queue_docter',                        '=', 'x.code_queue_docter');


        $datas->where('a.state',        '=', 'Y');

        $datas->where(function($query){
            $query->where('y.is_done',        '=', 'Y')->orWhere('w.is_glasses_direct_from_visus', 'Y');
        });

        if(isset($filter['current'])){
            if($filter['current'] == 'on'){
                $datas->where(function($query){
                    $query->where('f.is_done', '=', 'N')->orWhereNull('f.id');
                });
                $datas->where('b.time_start',               '<=', date('H:i:s'));
            }
        }

        $datas->where('w.is_done', '=', 'Y');
        // $datas->where('c.day',          '=', strtoupper(date('D')));

        $datas->whereBetween('a.booking_tanggal', [$date_from, $date_to]);

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('kmu_ps_queue_visus_glasses.queue_no',         'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.id_rekam_medis', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.nama_pasien',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('c.day',            'LIKE', '%'.engDay($params['search']['value']).'%');
                $q->orWhere('a.booking_tanggal','LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_start',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_end',       'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('e.nama_dokter',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ps_queue_visus_glasses.created_at', 'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_ps_queue_visus_glasses.id';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'kmu_ps_queue_visus_glasses.queue_no';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'd.id_rekam_medis';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'e.nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'a.booking_tanggal';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'b.time_start';
        }elseif($params['order'][0]['column'] == 7){
            $column = 'kmu_ps_queue_visus_glasses.created_at';
        }else{
            $column = 'kmu_ps_queue_visus_glasses.queue_no';
        }
        $datas->select('kmu_ps_queue_visus_glasses.code_queue_visus_glasses', 'kmu_ps_queue_visus_glasses.queue_no', 'kmu_ps_queue_visus_glasses.created_at', 'd.id_rekam_medis', 'd.nama_pasien', 'c.day', 'b.time_start', 'b.time_end', 'e.nama_dokter', 'a.booking_tanggal', 'f.is_done');
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

            $rows[$x][0] = $data->code_queue_visus_glasses;
            $rows[$x][1] = '<b>KACAMATA</b>';
            $rows[$x][2] = $data->queue_no;
            $rows[$x][3] = '<span data-toggle="tooltip" data-placement="top" title="'.$data->nama_pasien.'"><u>'.$data->id_rekam_medis.'</u></span>';
            $rows[$x][4] = $data->nama_dokter;
            $rows[$x][5] = indoDay($data->day).', '.$data->booking_tanggal;
            $rows[$x][6] = $data->time_start.' - '.$data->time_end;
            $rows[$x][7] = substr($data->created_at, 11, 8);
            $rows[$x][8] = '<button  onclick="play(\''.$data->queue_no.'\', \''.str_replace(' ', '. ', $data->nama_pasien).'\', \'kacamata\');" class="untouch-column btn btn-xs btn-info waves-effect" data-toggle="tooltip" data-placement="top" title="Panggil Pasien '.$data->nama_pasien.'"><i class="material-icons" style="font-size:15px">volume_up</i> </button>
            
            <span data-toggle="tooltip" data-placement="top" title="Isi Kacamata Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-kacamata" >
                    <i class="material-icons" style="font-size:15px">edit</i>
                </button>
            </span>
            
            <button style="margin-left:3px" class="btn btn-xs btn-'.$btncolor.' untouch-column status-visus" data-toggle="tooltip" data-placement="top" title="'.$stateName.'"><i class="material-icons" style="font-size:15px">'.$state.'</i></button>';
            $x++;
        }

        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;


        // $result = $this->getQueueDirectFromVisus($result, $params, $x+1);

        return $result;
    }



    public function getQueueDirectFromVisus($result, $params, $x){

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
        $datas = M_Visus::
        
            leftJoin('kmu_ps_booking as a', 
                'kmu_ps_visus.code_booking',              '=', 'a.code_booking')->

            leftJoin('kmu_us_docter_schedule_time as b', 
                'a.code_us_docter_booking_time',                        '=', 'b.code_us_docter_schedule_time')->

            leftJoin('kmu_us_docter_schedule_day as c', 
                'b.code_us_docter_schedule_day',                        '=', 'c.code_us_docter_schedule_day')->

            leftJoin('kmu_us_patient as d',     
                'a.code_patient',                                       '=', 'd.code_patient')->

            leftJoin('kmu_us_docter as e', 
                'a.code_docter',                                        '=', 'e.code_docter')->

            leftJoin('kmu_ps_afct_glasses as f', 
                'kmu_ps_visus.code_visus',  '=', 'f.code_visus_direct');


        $datas->where('a.state',        '=', 'Y');

        if(isset($filter['current'])){
            if($filter['current'] == 'on'){
                $datas->where(function($query){
                    $query->where('f.is_done', '=', 'N')->orWhereNull('f.id');
                });
                $datas->where('b.time_start',               '<=', date('H:i:s'));
            }
        }

        $datas->where('kmu_ps_visus.is_glasses_direct_from_visus',        '=', 'Y');

        $datas->where('c.day',          '=', strtoupper(date('D')));

        $datas->whereBetween('a.booking_tanggal', [$date_from, $date_to]);

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('kmu_ps_queue_visus_glasses.queue_no',         'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.id_rekam_medis', 'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('d.nama_pasien',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('c.day',            'LIKE', '%'.engDay($params['search']['value']).'%');
                $q->orWhere('a.booking_tanggal','LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_start',     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('b.time_end',       'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('e.nama_dokter',    'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_ps_visus.created_at', 'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_ps_visus.id';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'd.id_rekam_medis';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'e.nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'a.booking_tanggal';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'b.time_start';
        }elseif($params['order'][0]['column'] == 7){
            $column = 'kmu_ps_visus.created_at';
        }else{
            $column = 'kmu_ps_visus.id';
        }
        $datas->select('kmu_ps_visus.code_visus', 'kmu_ps_visus.code_visus as asd', 'kmu_ps_visus.created_at', 'd.id_rekam_medis', 'd.nama_pasien', 'c.day', 'b.time_start', 'b.time_end', 'e.nama_dokter', 'a.booking_tanggal', 'f.is_done');
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
       
        foreach($datas as $key => $data){
            $state = ($data->is_done == "Y")? "done" : "clear";
            $stateName = ($data->is_done == "Y")? "Status : Selesai" : "Status : Belum Selesai";
            $btncolor = ($data->is_done == "Y")? "success" : "danger";

            $result['aaData'][$x][0] = $data->code_visus;
            $result['aaData'][$x][1] = '<b>KACAMATA</b>';
            $result['aaData'][$x][2] = $data->asd;
            $result['aaData'][$x][3] = '<span data-toggle="tooltip" data-placement="top" title="'.$data->nama_pasien.'"><u>'.$data->id_rekam_medis.'</u></span>';
            $result['aaData'][$x][4] = $data->nama_dokter;
            $result['aaData'][$x][5] = indoDay($data->day).', '.$data->booking_tanggal;
            $result['aaData'][$x][6] = $data->time_start.' - '.$data->time_end;
            $result['aaData'][$x][7] = substr($data->created_at, 11, 8);
            $result['aaData'][$x][8] = '<button  onclick="play(\''.$data->queue_no.'\', \''.str_replace(' ', '. ', $data->nama_pasien).'\', \'kacamata\');" class="untouch-column btn btn-xs btn-info waves-effect" data-toggle="tooltip" data-placement="top" title="Panggil Pasien '.$data->nama_pasien.'"><i class="material-icons" style="font-size:15px">volume_up</i> </button>
            
            <span data-toggle="tooltip" data-placement="top" title="Isi Kacamata Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-kacamata" >
                    <i class="material-icons" style="font-size:15px">edit</i>
                </button>
            </span>
            
            <button style="margin-left:3px" class="btn btn-xs btn-'.$btncolor.' untouch-column status-visus" data-toggle="tooltip" data-placement="top" title="'.$stateName.'"><i class="material-icons" style="font-size:15px">'.$state.'</i></button>';
            $x++;
        }

        $result['iTotalRecords'] = $result['iTotalRecords'] + $total;
        $result['iTotalDisplayRecords'] = $result['iTotalDisplayRecords'] + $total;

        return $result;

    }






    public function getQueueVisusAll($params){

        // FILTER WHERE
        $where = '';
        $order = '';
        $limit = '';

        
        if($params['search']['value'] != ''){
            $where .= ' AND ( ';
            $where .= " a.queue_no LIKE '%".$params['search']['value']."%'";
            $where .= " OR id_rekam_medis LIKE '%".$params['search']['value']."%'";
            $where .= " OR nama_pasien LIKE '%".$params['search']['value']."%'";
            $where .= " OR booking_tanggal LIKE '%".$params['search']['value']."%'";
            $where .= " OR day LIKE '%".$params['search']['value']."%'";
            $where .= " OR time_start LIKE '%".$params['search']['value']."%'";
            $where .= " OR time_end LIKE '%".$params['search']['value']."%'";
            $where .= " OR nama_dokter LIKE '%".$params['search']['value']."%'";
            $where .= " OR a.created_at LIKE '%".$params['search']['value']."%'";
            $where .= ' ) ';
        }

        //ORDER BY
        if($params['order'][0]['column'] == 0){
            $column = 'created_at';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'queue_no';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'id_rekam_medis';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'nama_dokter';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'booking_tanggal';
        }elseif($params['order'][0]['column'] == 6){
            $column = 'time_start';
        }elseif($params['order'][0]['column'] == 7){
            $column = 'created_at';
        }else{
            $column = 'created_at';
        }

        $order = " ORDER BY ".$column." ".$params['order'][0]['dir'];


        if($params['length'] != -1){
            $limit .= " LIMIT ". $params['start'] .", ".$params['length'];
        }

        $datas = DB::select( 
            DB::raw("
                SELECT 
                    * 
                FROM
                (
                    (
                        SELECT 
                            'VISUS' AS tipe,
                            a.code_queue_visus_normal,
                            queue_no,
                            a.created_at,
                            b.booking_tanggal,
                            e.id_rekam_medis,
                            e.nama_pasien,
                            d.day,
                            c.time_start,
                            c.time_end,
                            f.nama_dokter,
                            a.state, 
                            g.is_done 
                        FROM
                            kmu_ps_queue_visus_normal a 
                        LEFT JOIN kmu_ps_booking b 
                            ON a.`code_booking` = b.`code_booking` 
                        LEFT JOIN kmu_us_docter_schedule_time c 
                            ON b.`code_us_docter_booking_time` = c.`code_us_docter_schedule_time` 
                        LEFT JOIN kmu_us_docter_schedule_day d 
                            ON c.`code_us_docter_schedule_day` = d.`code_us_docter_schedule_day` 
                        LEFT JOIN kmu_us_patient e 
                            ON b.`code_patient` = e.`code_patient` 
                        LEFT JOIN kmu_us_docter f 
                            ON b.`code_docter` = f.`code_docter` 
                        LEFT JOIN kmu_ps_visus g 
                            ON g.`code_queue_visus_normal` = a.`code_queue_visus_normal` 
                        WHERE a.state = 'Y'
                        AND time_start <= CURRENT_TIME
                        AND day <= DAY
                        AND b.booking_tanggal = CURRENT_DATE()
                        ".$where."
                    )UNION(
                        SELECT 
                            'KACAMATA' AS tipe,
                            a.code_queue_visus_glasses,
                            queue_no,
                            a.created_at,
                            b.booking_tanggal,
                            e.id_rekam_medis,
                            e.nama_pasien,
                            d.day,
                            c.time_start,
                            c.time_end,
                            f.nama_dokter,
                            a.state,
                            g.is_done 
                        FROM
                        kmu_ps_queue_visus_glasses a 
                        LEFT JOIN kmu_ps_booking b 
                            ON a.`code_booking` = b.`code_booking` 
                        LEFT JOIN kmu_us_docter_schedule_time c 
                            ON b.`code_us_docter_booking_time` = c.`code_us_docter_schedule_time` 
                        LEFT JOIN kmu_us_docter_schedule_day d 
                            ON c.`code_us_docter_schedule_day` = d.`code_us_docter_schedule_day` 
                        LEFT JOIN kmu_us_patient e 
                            ON b.`code_patient` = e.`code_patient` 
                        LEFT JOIN kmu_us_docter f 
                            ON b.`code_docter` = f.`code_docter` 
                        LEFT JOIN kmu_ps_afct_glasses g 
                            ON g.`code_queue_visus_glasses` = a.`code_queue_visus_glasses` 
                        WHERE a.state = 'Y'
                        AND time_start <= CURRENT_TIME
                        AND day <= DAY
                        AND b.booking_tanggal = CURRENT_DATE()
                        ".$where."
                    )
                ) uni
                WHERE state = 'Y'
                ".$order."
                ".$limit."
            
            ")
        );


        $datastotal = DB::select( 
            DB::raw("
                SELECT 
                    count(*) total
                FROM
                (
                    (
                        SELECT 
                            'VISUS' AS tipe,
                            code_queue_visus_normal,
                            queue_no,
                            a.created_at,
                            b.booking_tanggal,
                            e.id_rekam_medis,
                            e.nama_pasien,
                            d.day,
                            c.time_start,
                            c.time_end,
                            f.nama_dokter,
                            a.state 
                        FROM
                            kmu_ps_queue_visus_normal a 
                        LEFT JOIN kmu_ps_booking b 
                            ON a.`code_booking` = b.`code_booking` 
                        LEFT JOIN kmu_us_docter_schedule_time c 
                            ON b.`code_us_docter_booking_time` = c.`code_us_docter_schedule_time` 
                        LEFT JOIN kmu_us_docter_schedule_day d 
                            ON c.`code_us_docter_schedule_day` = d.`code_us_docter_schedule_day` 
                        LEFT JOIN kmu_us_patient e 
                            ON b.`code_patient` = e.`code_patient` 
                        LEFT JOIN kmu_us_docter f 
                            ON b.`code_docter` = f.`code_docter` 
                        WHERE a.state = 'Y'
                        AND time_start <= CURRENT_TIME
                        AND day <= DAY
                        ".$where."
                    )UNION(
                        SELECT 
                            'KACAMATA' AS tipe,
                            code_queue_visus_glasses,
                            queue_no,
                            a.created_at,
                            b.booking_tanggal,
                            e.id_rekam_medis,
                            e.nama_pasien,
                            d.day,
                            c.time_start,
                            c.time_end,
                            f.nama_dokter,
                            a.state 
                        FROM
                        kmu_ps_queue_visus_glasses a 
                        LEFT JOIN kmu_ps_booking b 
                            ON a.`code_booking` = b.`code_booking` 
                        LEFT JOIN kmu_us_docter_schedule_time c 
                            ON b.`code_us_docter_booking_time` = c.`code_us_docter_schedule_time` 
                        LEFT JOIN kmu_us_docter_schedule_day d 
                            ON c.`code_us_docter_schedule_day` = d.`code_us_docter_schedule_day` 
                        LEFT JOIN kmu_us_patient e 
                            ON b.`code_patient` = e.`code_patient` 
                        LEFT JOIN kmu_us_docter f 
                            ON b.`code_docter` = f.`code_docter` 
                        WHERE a.state = 'Y'
                        AND time_start <= CURRENT_TIME
                        AND day <= DAY
                        ".$where."
                    )
                ) uni
                WHERE state = 'Y'
                ".$order."
            
            ")
        );

        $datastotal = $datastotal[0]->total;

        $rows   = array();
        $x      = 0;
       
        foreach($datas as $key => $data){
            $state = ($data->is_done == "Y")? "done" : "clear";
            $stateName = ($data->is_done == "Y")? "Status : Selesai" : "Status : Belum Selesai";
            $btncolor = ($data->is_done == "Y")? "success" : "danger";

            $tipe = ($data->tipe == "VISUS")? "visus" : "kacamata";

            $rows[$x][0] = $data->code_queue_visus_normal;
            $rows[$x][1] = '<b>'.$data->tipe.'</b>';
            $rows[$x][2] = $data->queue_no;
            $rows[$x][3] = '<span data-toggle="tooltip" data-placement="top" title="'.$data->nama_pasien.'"><u>'.$data->id_rekam_medis.'</u></span>';
            $rows[$x][4] = $data->nama_dokter;
            $rows[$x][5] = indoDay($data->day).', '.$data->booking_tanggal;
            $rows[$x][6] = $data->time_start.' - '.$data->time_end;
            $rows[$x][7] = substr($data->created_at, 11, 8);
            $rows[$x][8] = '<button onclick="play(\''.$data->queue_no.'\', \''.str_replace(' ', '. ', $data->nama_pasien).'\', \''.$tipe.'\');" class="untouch-column btn btn-xs btn-info waves-effect" data-toggle="tooltip" data-placement="top" title="Panggil Pasien '.$data->nama_pasien.'"><i class="material-icons" style="font-size:15px">volume_up</i> </button>
            
            <span data-toggle="tooltip" data-placement="top" title="Isi '.$tipe.' Pasien '.$data->nama_pasien.'">
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="btn btn-xs btn-warning waves-effect untouch-column entry-'.$tipe.'" >
                    <i class="material-icons" style="font-size:15px">edit</i>
                </button>
            </span>
            
            <button style="margin-left:3px" class="btn btn-xs btn-'.$btncolor.' untouch-column status-visus" data-toggle="tooltip" data-placement="top" title="'.$stateName.'"><i class="material-icons" style="font-size:15px">'.$state.'</i></button>';
            $x++;
        }
                            
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $datastotal;
        $result['iTotalDisplayRecords'] = $datastotal;
        return $result;
    }
}


