<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Consult_Medicine;
use App\Models\M_Income_Medicine;
use DB;

class ApiCashierController extends Controller{

    // public function getQueueCashier($params){

    //     // MAIN QUERY
    //     $datas = M_Consult_Medicine::
        
    //         leftJoin('kmu_ps_consult as a', 
    //             'kmu_ps_afct_medicine.code_consult',                      '=', 'a.code_consult')->
                
    //         leftJoin('kmu_ps_queue_docter as b', 
    //             'a.code_queue_docter',                                  '=', 'b.code_queue_docter')->

    //         leftJoin('kmu_ps_visus as c', 
    //             'b.code_visus',                                         '=', 'c.code_visus')->

    //         leftJoin('kmu_ps_queue_visus_normal as d', 
    //             'c.code_queue_visus_normal',                            '=', 'd.code_queue_visus_normal')->

    //         leftJoin('kmu_ps_booking as e', 
    //             'd.code_booking',                                       '=', 'e.code_booking')->

    //         leftJoin('kmu_us_patient as f', 
    //             'e.code_patient',                                       '=', 'f.code_patient')->

    //         leftJoin('kmu_us_docter as g', 
    //             'a.on_behalf_of',                                       '=', 'g.code_docter')->

    //         leftJoin('kmu_ps_afct_medicine_details as i', function($join)
    //         {
    //             $join->on('kmu_ps_afct_medicine.code_afct_medicine',    '=', 'i.code_afct_medicine');
    //             $join->on('i.state','=',DB::raw("'Y'"));
    //         })->

    //         leftJoin('kmu_ps_income_medicine as h', function($join)
    //         {
    //             $join->on('i.code_afct_medicine_details',    '=', 'h.code_afct_medicine_details');
    //             $join->on('h.state','=',DB::raw("'Y'"));
    //         });


    //     $datas->where('kmu_ps_afct_medicine.state',                  '=', 'Y');
    //     $datas->where('a.is_done',                                   '=', 'Y');
    //     $datas->where('a.is_medicine',                               '=', 'Y');

    //     $datas->where('e.booking_tanggal',          '=', date('Y-m-d'));

    //     // FILTER WHERE
    //     if($params['search']['value'] != ''){
    //         $datas->where(function($q) use($datas, $params){
    //             $q->orWhere('id_rekam_medis',                     'LIKE', '%'.$params['search']['value'].'%');
    //             $q->orWhere('nama_pasien',                        'LIKE', '%'.$params['search']['value'].'%');
    //         });
    //     }

    //     $datas->select(DB::raw('MAX(nama_pasien) AS nama_pasien'), DB::raw('SUM(price) AS price'), DB::raw('MAX(id_rekam_medis) AS id_rekam_medis'), DB::raw('MIN(kmu_ps_afct_medicine.created_at) AS created_at'), 'a.code_consult',  DB::raw('MAX(kmu_ps_afct_medicine.is_taken) AS isTaken'),  DB::raw('MAX(h.code_ps_income_medicine) AS code_ps_income_medicine'), DB::raw("IF(SUM(h.is_paid = 'Y'), 'Y', 'N') AS is_paid"));

    //     $datas->groupBy('kmu_ps_afct_medicine.code_consult');
    //     $datas->orderBy(DB::raw('MAX(kmu_ps_afct_medicine.id)'), $params['order'][0]['dir']);
        
    //     //FILTER PAGINATION & LIMIT
    //     $alldatas = $datas->get();

    //     //READY TO PASSING !
    //     $datas = $datas->get();
    //     $total = $alldatas->count();

    //     $rows   = array();
    //     $x      = 0;
       
    //     foreach($datas as $key => $data){
    //         $stateAssign = ($data->price == 0 or $data->id_rekam_medis == '')? "edit" : "check";
    //         $statePaid = ($data->is_paid == 'Y')? "attach_money" : "money_off";
    //         $stateTake = ($data->isTaken == 'Y')? "taken" : ($data->code_ps_income_medicine != '' and $data->is_paid == 'Y')? "income-in" : ""  ;
    //         $stateName = ($data->is_done == "Y")? "Status : Selesai" : "Status : Belum Selesai";
    //         $btncolor = ($data->price == 0 or $data->id_rekam_medis == '')? "warning" : "success";


    //         $rows[$x][0] = $data->code_consult;
    //         $rows[$x][1] = '
            
    //         <span data-toggle="tooltip" data-placement="top" title="'.$data->id_rekam_medis.'" style="color:#5a5a5a;font-size:16px">
    //             '.$data->nama_pasien.'
    //         </span>
            
    //         <span class="entry-cashier pull-right" data-toggle="tooltip" data-placement="top" title="Assign Obat Pasien '.$data->nama_pasien.'">
    //             <span data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" waves-effect untouch-column entry-cashier" >
    //                 <i class="material-icons" style="font-size:15px;color:#5a5a5a !important">'.$stateAssign.'</i>
    //             </span>
    //             <!-- <span data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" waves-effect untouch-column" >
    //                 <i class="material-icons" style="font-size:15px;color:#5a5a5a !important" >'.$statePaid.'</i>
    //             </span>-->
    //         </span>
            
    //         <span class="pull-right" style="color:#5a5a5a;padding-right:10px">
    //             <b>'.date('h:i A', strtotime($data->created_at)).'</b>
    //         </span>' ;
    //         $rows[$x][2] = $stateTake;

    //         $x++;
    //     }
                                
    //     $result['aaData'] = $rows;
    //     $result['iTotalRecords'] = $total;
    //     $result['iTotalDisplayRecords'] = $total;
    //     return $result;
    // }

    // public function getCashier($params){
    //     // MAIN QUERY
    //     $datas = M_Income_Medicine::
        
    //         leftJoin('kmu_ps_afct_medicine as z', 
    //             'kmu_ps_income_medicine.code_afct_medicine',            '=', 'z.code_afct_medicine')->
            
    //         leftJoin('kmu_ms_medicine as y', 
    //             'y.code_medicine',                                      '=', 'z.code_medicine')->    
            
    //         leftJoin('kmu_ps_consult as a', 
    //             'z.code_consult',                                       '=', 'a.code_consult')->
                
    //         leftJoin('kmu_ps_queue_docter as b', 
    //             'a.code_queue_docter',                                  '=', 'b.code_queue_docter')->

    //         leftJoin('kmu_ps_visus as c', 
    //             'b.code_visus',                                         '=', 'c.code_visus')->

    //         leftJoin('kmu_ps_queue_visus_normal as d', 
    //             'c.code_queue_visus_normal',                            '=', 'd.code_queue_visus_normal')->

    //         leftJoin('kmu_ps_booking as e', 
    //             'd.code_booking',                                       '=', 'e.code_booking')->

    //         leftJoin('kmu_us_patient as f', 
    //             'e.code_patient',                                       '=', 'f.code_patient')->

    //         leftJoin('kmu_us_docter as g', 
    //             'a.on_behalf_of',                                       '=', 'g.code_docter')->

    //         leftJoin('kmu_ps_income_medicine as h', function($join)
    //         {
    //             $join->on('z.code_afct_medicine',    '=', 'h.code_afct_medicine');
    //             $join->on('h.state','=',DB::raw("'Y'"));
    //         });


    //     $datas->where('kmu_ps_income_medicine.state',                '=', 'Y');
    //     $datas->where('a.is_done',                                   '=', 'Y');
    //     $datas->where('a.is_medicine',                               '=', 'Y');

    //     $datas->where('e.booking_tanggal',          '=', date('Y-m-d'));

    //     $datas->orderBy('kmu_ps_income_medicine.id', $params['order'][0]['dir']);
        
    //     //FILTER PAGINATION & LIMIT
    //     $alldatas = $datas->get();

    //     //READY TO PASSING !
    //     $datas = $datas->get();
    //     $total = $alldatas->count();

    //     $rows   = array();
    //     $x      = 0;
       
    //     foreach($datas as $key => $data){
    //         $state = ($data->price == 0 or $data->id_rekam_medis == '')? "edit" : "clear";
    //         $stateName = ($data->is_done == "Y")? "Status : Selesai" : "Status : Belum Selesai";
    //         $btncolor = ($data->price == 0 or $data->id_rekam_medis == '')? "warning" : "success";


    //         $rows[$x][0] = $data->code_consult;

    //         $rows[$x][1] = $data->nama_pasien;
    //         $rows[$x][2] = $data->nama_obat;
    //         $rows[$x][3] = $data->total;
    //         $rows[$x][4] = number_format($data->price,0,',','.');

    //         $rows[$x][5] = '<span class="entry-cashier" data-toggle="tooltip" data-placement="top" title="Assign Obat Pasien '.$data->nama_pasien.'">
    //             <span data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" waves-effect untouch-column entry-cashier" >
    //                 <i class="material-icons" style="font-size:15px">'.$state.'</i>
    //             </span>
    //         </span>';
    //         $x++;
    //     }
                                
    //     $result['aaData'] = $rows;
    //     $result['iTotalRecords'] = $total;
    //     $result['iTotalDisplayRecords'] = $total;
    //     return $result;
    // }

    // public function getCashierTrx($params){
    //     // FILTER WHERE
    //     $where = '';
    //     $order = '';
    //     $limit = '';
        
    //     if($params['search']['value'] != ''){
    //         $where .= ' AND ( ';
    //         $where .= " nama_pasien LIKE '%".$params['search']['value']."%'";
    //         $where .= " OR pasien_status LIKE '%".$params['search']['value']."%'";
    //         $where .= " OR code LIKE '%".$params['search']['value']."%'";
    //         $where .= " OR is_paid LIKE '%".$params['search']['value']."%'";
    //         $where .= " OR is_taken LIKE '%".$params['search']['value']."%'";
    //         $where .= ' ) ';
    //     }

    //     //ORDER BY
    //     if($params['order'][0]['column'] == 0){
    //         $column = 'created_at';
    //     }elseif($params['order'][0]['column'] == 2){
    //         $column = 'nama_pasien';
    //     }elseif($params['order'][0]['column'] == 3){
    //         $column = 'code';
    //     }elseif($params['order'][0]['column'] == 4){
    //         $column = 'created_at';
    //     }elseif($params['order'][0]['column'] == 5){
    //         $column = 'created_at';
    //     }else{
    //         $column = 'created_at';
    //     }

    //     $order = " ORDER BY ".$column." ".$params['order'][0]['dir'];


    //     if($params['length'] != -1){
    //         $limit .= " LIMIT ". $params['start'] .", ".$params['length'];
    //     }

    //     $datas = DB::select( 
    //         DB::raw("
    //         SELECT 
    //             * 
    //         FROM
    //             (
    //             (SELECT 
    //                 'YES' pasien_status,
    //                 MAX(d.code_consult) code_consult,
    //                 MAX(nama_pasien) NAME,
    //                 MAX(c.code_afct_medicine) CODE,
    //                 MAX(c.is_paid) AS is_paid,
    //                 MAX(is_taken) is_taken,
    //                 MAX(a.created_at) created_at,
    //                 MAX(a.price) price
    //             FROM
    //                 kmu_ps_afct_medicine c 
    //                 LEFT JOIN kmu_ps_afct_medicine_details b 
    //                 ON b.`code_afct_medicine` = c.`code_afct_medicine`
    //                 LEFT JOIN  kmu_ps_income_medicine a  
    //                 ON a.`code_afct_medicine_details` = b.`code_afct_medicine_details` 
    //                 LEFT JOIN kmu_ps_consult d 
    //                 ON c.`code_consult` = d.`code_consult` 
    //                 LEFT JOIN kmu_ps_queue_docter e 
    //                 ON d.`code_queue_docter` = e.`code_queue_docter` 
    //                 LEFT JOIN kmu_ps_visus f 
    //                 ON e.`code_visus` = f.`code_visus` 
    //                 LEFT JOIN kmu_ps_queue_visus_normal g 
    //                 ON g.`code_queue_visus_normal` = f.`code_queue_visus_normal` 
    //                 LEFT JOIN kmu_ps_booking h 
    //                 ON g.`code_booking` = h.`code_booking` 
    //                 LEFT JOIN kmu_us_patient i 
    //                 ON h.`code_patient` = i.`code_patient` 
    //             WHERE  
    //             d.is_done = 'Y'
    //             AND b.`state` = 'Y' 
    //                 AND c.`state` = 'Y' 
    //                 AND d.`state` = 'Y' 
    //                 AND e.`state` = 'Y' 
    //                 AND f.`state` = 'Y' 
    //                 AND g.`state` = 'Y' 
    //                 AND h.`state` = 'Y' 
    //                 AND h.`booking_tanggal` = CURRENT_DATE() 
    //             GROUP BY h.`code_booking`) 
    //             UNION
    //             (SELECT 
    //                 'NO' pasien_status,
    //                 MAX(c.code_ex_ps_medicine) code_consult,
    //                 MAX(customer_name) NAME,
    //                 MAX(c.code_ex_ps_medicine) CODE,
    //                 MAX(c.is_paid) AS is_paid,
    //                 MAX(is_taken) is_taken,
    //                 MAX(a.created_at) created_at,
    //                 MAX(a.price) price
    //             FROM
    //                 kmu_ex_ps_income_medicine a 
    //                 LEFT JOIN kmu_ex_ps_medicine_details b 
    //                 ON a.code_ex_ps_medicine_details = b.`code_ex_ps_medicine_details` 
    //                 LEFT JOIN kmu_ex_ps_medicine c 
    //                 ON b.`code_ex_ps_medicine` = c.`code_ex_ps_medicine` 
    //             WHERE a.`state` = 'Y' 
    //                 AND b.`state` = 'Y' 
    //                 AND c.`state` = 'Y' 
    //                 AND DATE(c.`created_at`) = CURRENT_DATE() 
    //                 AND c.code_ex_ps_medicine NOT IN 
    //                 (SELECT 
    //                 code_ex_ps_medicine 
    //                 FROM
    //                 kmu_ps_afct_medicine WHERE code_ex_ps_medicine IS NOT NULL) 
    //                 GROUP BY c.`code_ex_ps_medicine`)
    //             ) tab 
    //             WHERE CODE IS NOT NULL
    //             ".$where."
    //             ".$order."
    //             ".$limit."
    //         ")
    //     );
    //     $datastotal = DB::select( 
    //         DB::raw("
    //         SELECT 
    //             count(*) total
    //         FROM
    //             (
    //             (SELECT 
    //                 'YES' pasien_status,
    //                 MAX(nama_pasien) NAME,
    //                 MAX(c.code_afct_medicine) CODE,
    //                 MAX(c.is_paid) AS is_paid,
    //                 MAX(is_taken) is_taken,
    //                 MAX(a.created_at) created_at
    //             FROM
    //                 kmu_ps_afct_medicine c 
    //                 LEFT JOIN kmu_ps_afct_medicine_details b 
    //                 ON b.`code_afct_medicine` = c.`code_afct_medicine`
    //                 LEFT JOIN  kmu_ps_income_medicine a  
    //                 ON a.`code_afct_medicine_details` = b.`code_afct_medicine_details` 
    //                 LEFT JOIN kmu_ps_consult d 
    //                 ON c.`code_consult` = d.`code_consult` 
    //                 LEFT JOIN kmu_ps_queue_docter e 
    //                 ON d.`code_queue_docter` = e.`code_queue_docter` 
    //                 LEFT JOIN kmu_ps_visus f 
    //                 ON e.`code_visus` = f.`code_visus` 
    //                 LEFT JOIN kmu_ps_queue_visus_normal g 
    //                 ON g.`code_queue_visus_normal` = f.`code_queue_visus_normal` 
    //                 LEFT JOIN kmu_ps_booking h 
    //                 ON g.`code_booking` = h.`code_booking` 
    //                 LEFT JOIN kmu_us_patient i 
    //                 ON h.`code_patient` = i.`code_patient` 
    //             WHERE 
    //             d.is_done = 'Y' 
    //             AND b.`state` = 'Y' 
    //                 AND c.`state` = 'Y' 
    //                 AND d.`state` = 'Y' 
    //                 AND e.`state` = 'Y' 
    //                 AND f.`state` = 'Y' 
    //                 AND g.`state` = 'Y' 
    //                 AND h.`state` = 'Y' 
    //                 AND h.`booking_tanggal` = CURRENT_DATE() 
    //             GROUP BY h.`code_booking`) 
    //             UNION
    //             (SELECT 
    //                 'NO' pasien_status,
    //                 MAX(customer_name) NAME,
    //                 MAX(c.code_ex_ps_medicine) CODE,
    //                 MAX(c.is_paid) AS is_paid,
    //                 MAX(is_taken) is_taken,
    //                 MAX(a.created_at) created_at
    //             FROM
    //                 kmu_ex_ps_income_medicine a 
    //                 LEFT JOIN kmu_ex_ps_medicine_details b 
    //                 ON a.code_ex_ps_medicine_details = b.`code_ex_ps_medicine_details` 
    //                 LEFT JOIN kmu_ex_ps_medicine c 
    //                 ON b.`code_ex_ps_medicine` = c.`code_ex_ps_medicine` 
    //             WHERE a.`state` = 'Y' 
    //                 AND b.`state` = 'Y' 
    //                 AND c.`state` = 'Y' 
    //                 AND DATE(c.`created_at`) = CURRENT_DATE() 
    //                 AND c.code_ex_ps_medicine NOT IN 
    //                 (SELECT 
    //                 code_ex_ps_medicine 
    //                 FROM
    //                 kmu_ps_afct_medicine  WHERE code_ex_ps_medicine IS NOT NULL) 
    //                 GROUP BY c.`code_ex_ps_medicine`)
    //             ) tab 
    //             WHERE CODE IS NOT NULL
    //             ".$where."
    //             ".$order."
    //         ")
    //     );
    //     $x = 0;
    //     $rows   = array();
        
    //     foreach($datas as $key => $data){
    //         $stateAssign = ($data->price == 0)? "edit" : "check";
    //         $statePaid = ($data->is_paid == 'Y')? "attach_money" : "money_off";
    //         $statePaidBtn = ($data->is_paid == 'Y')? "success" : "danger";
            
    //         $stateTaken = ($data->is_taken == 'Y')? "check" : "close";
    //         $stateTakenBtn = ($data->is_taken == 'Y')? "success" : "danger";

            
    //         $rows[$x][0] = $data->code_consult;
    //         $rows[$x][1] = $data->pasien_status;

    //         $rows[$x][2] = $data->NAME;
    //         $rows[$x][3] = '<span  style="text-align:center" class="entry-cashier" data-toggle="tooltip" data-placement="top" title="Assign Obat Pasien '.$data->NAME.'"> <span data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" waves-effect untouch-column entry-cashier" >
    //         <i class="material-icons" style="font-size:15px;color:blue !important">'.$stateAssign.'</i>&nbsp;<u style="color:blue">'.$data->CODE.'</u>
    //     </span>
    //     </span>';
    //         $rows[$x][4] = $data->created_at? date('d M Y', strtotime($data->created_at)) : '';
    //         $rows[$x][5] = $data->created_at? date('h:i A', strtotime($data->created_at)) : '';
    //         $rows[$x][6] = '
    //             <button type="button" class="btn btn-'.$statePaidBtn.' btn-circle waves-effect waves-circle waves-float" style="width:30px;height:30px;">
    //                 <i class="material-icons" style="left:-6px;top:-3px" >'.$statePaid.'</i>
    //             </button>';
    //         $rows[$x][7] = 
    //             '<button type="button" class="btn btn-taken btn-'.$stateTakenBtn.' btn-circle waves-effect waves-circle waves-float" style="width:30px;height:30px;">
    //                 <i class="material-icons" style="left:-6px;top:-3px" >'.$stateTaken.'</i>
    //             </button>';
    //         $x++;
    //     }

    //     $result['aaData'] = $rows;
    //     $result['iTotalRecords'] = $datastotal[0]->total;
    //     $result['iTotalDisplayRecords'] = $datastotal[0]->total;
    //     return $result;
    // }

    
    public function getCashierTrx($params){

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
            $column = 'tanggal, jam';
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

        // $order = " ORDER BY ".$column." ".$params['order'][0]['dir'];
        $order = " ORDER BY tanggal DESC";


        if($params['length'] != -1){
            $limit .= " LIMIT ". $params['start'] .", ".$params['length'];
        }

        $datas = DB::select( 
            DB::raw("
               SELECT 
                    * 
                    FROM
                    (
                        (SELECT 
                        'PASIEN' tipe,
                        l.`nama_pasien` nama,
                        a.`code_booking` kode,
                        a.`booking_tanggal` tanggal,
                        SUBSTR(b.created_at, 12, 10) jam ,
                        e.code_consult kode_obat ,
                        k.code_afct_medicine kode_obat2,
                        a.is_finished done 
                        FROM
                        kmu_ps_booking a 
                        LEFT JOIN kmu_ps_queue_visus_normal b 
                            ON a.`code_booking` = b.`code_booking` 
                            AND b.state = 'Y' 
                        LEFT JOIN kmu_ps_visus c 
                            ON b.`code_queue_visus_normal` = c.`code_queue_visus_normal` 
                            AND c.state = 'Y' 
                        LEFT JOIN kmu_ps_queue_docter d 
                            ON c.`code_visus` = d.`code_visus` 
                            AND d.state = 'Y' 
                        LEFT JOIN kmu_ps_consult e 
                            ON d.`code_queue_docter` = e.`code_queue_docter` 
                            AND e.state = 'Y' 
                        LEFT JOIN kmu_ps_queue_visus_glasses f 
                            ON a.`code_booking` = f.`code_booking` 
                            AND f.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_glasses g 
                            ON f.`code_queue_visus_glasses` = g.`code_queue_visus_glasses` 
                            AND g.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_operation_agreement h 
                            ON e.`code_consult` = h.`code_consult` 
                            AND h.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_reqlab i 
                            ON h.`code_operation_agreement` = i.`code_consult` 
                            AND i.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_operation j 
                            ON j.`code_operation_agreement` = h.`code_operation_agreement` 
                            AND j.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_medicine k 
                            ON k.`code_consult` = e.`code_consult` 
                            AND k.state = 'Y' 
                        LEFT JOIN kmu_us_patient l 
                            ON l.code_patient = a.`code_patient` 
                        WHERE a.state = 'Y') 
                        UNION
                        (SELECT 
                            'UMUM-OBAT' tipe,
                            customer_name nama,
                            code_ex_ps_medicine kode,
                            SUBSTR(created_at, 0, 10) tanggal,
                            SUBSTR(created_at, 12, 10) jam,
                             code_ex_ps_medicine kode_obat,
                             code_ex_ps_medicine kode_obat2,
                             is_done is_done
                        FROM
                            kmu_ex_ps_medicine)
        ".$where."
                    ) total_trx 
        ".$order."
        ".$limit.";
            
            ")
        );


        // AND booking_tanggal = CURRENT_DATE)
        // WHERE DATE(created_at) = CURRENT_DATE)

        $datastotal = DB::select( 
            DB::raw("
               SELECT 
                    count(*) total 
                    FROM
                    (
                        (SELECT 
                            'PASIEN-UMUM' tipe,
                            l.`nama_pasien` nama,
                            a.`code_booking` kode,
                            a.`booking_tanggal` tanggal,
                            SUBSTR(b.created_at, 12, 10) jam 
                        FROM
                            kmu_ps_booking a 
                        LEFT JOIN kmu_ps_queue_visus_normal b 
                            ON a.`code_booking` = b.`code_booking` 
                            AND b.state = 'Y' 
                        LEFT JOIN kmu_ps_visus c 
                            ON b.`code_queue_visus_normal` = c.`code_queue_visus_normal` 
                            AND c.state = 'Y' 
                        LEFT JOIN kmu_ps_queue_docter d 
                            ON c.`code_visus` = d.`code_visus` 
                            AND d.state = 'Y' 
                        LEFT JOIN kmu_ps_consult e 
                            ON d.`code_queue_docter` = e.`code_queue_docter` 
                            AND e.state = 'Y' 
                        LEFT JOIN kmu_ps_queue_visus_glasses f 
                            ON a.`code_booking` = f.`code_booking` 
                            AND f.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_glasses g 
                            ON f.`code_queue_visus_glasses` = g.`code_queue_visus_glasses` 
                            AND g.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_operation_agreement h 
                            ON e.`code_consult` = h.`code_consult` 
                            AND h.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_reqlab i 
                            ON h.`code_operation_agreement` = i.`code_consult` 
                            AND i.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_operation j 
                            ON j.`code_operation_agreement` = h.`code_operation_agreement` 
                            AND j.state = 'Y' 
                        LEFT JOIN kmu_ps_afct_medicine k 
                            ON k.`code_consult` = e.`code_consult` 
                            AND k.state = 'Y' 
                        LEFT JOIN kmu_us_patient l 
                            ON l.code_patient = a.`code_patient` 
                        WHERE a.state = 'Y') 
                        UNION
                        (SELECT 
                            'UMUM-OBAT' tipe,
                            customer_name nama,
                            code_ex_ps_medicine kode,
                            SUBSTR(created_at, 0, 10) tanggal,
                            SUBSTR(created_at, 12, 10) jam 
                        FROM
                            kmu_ex_ps_medicine)
        ".$where."
                    ) total_trx 
        ".$limit.";
            
            ")
        );

        // $datastotal = $datastotal[0]->total;

        $rows   = array();
        $x      = 0;

       foreach($datas as $key => $data){
            $stateAssign = "edit";
            
            $stateTaken = ($data->done == 'Y')? "check" : "close";
            $stateTakenBtn = ($data->done == 'Y')? "success" : "danger";

            
            $rows[$x][0] = $data->kode;
            $rows[$x][1] = $data->tipe;

            $rows[$x][2] = $data->nama;
            $rows[$x][3] = ($data->kode_obat AND $data->kode_obat2)? '
            <span  style="text-align:center" class="entry-cashier" data-toggle="tooltip" data-placement="top" title="Data Obat Pasien '.$data->nama.'"> 
                <span data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" waves-effect untouch-column entry-cashier">
                    <span style="font-size:15px;color:blue !important"><i>'.$data->kode_obat.'</i></span>
                    <u style="color:blue"><i>DATA OBAT</i><input type="hidden" value="'.$data->kode_obat.'" class="getcdmed" />
                    </u>
                </span>
            </span>' : 'Tidak ada pemberian obat';
            $rows[$x][4] = $data->tanggal;
            // $rows[$x][5] = $data->jam;
            // $rows[$x][5] = 
            //     '<button data-toggle="modal" data-target="#largeModal" type="button" class="btn btn-taken btn-'.$stateTakenBtn.' btn-circle waves-effect waves-circle waves-float" style="width:30px;height:30px;">
            //         <i class="material-icons" style="left:-6px;top:-3px" >'.$stateTaken.'</i>
            //     </button>';
            $rows[$x][5] = 
                '<button data-toggle="modal" data-target="#largeModal" type="button" class="btn btn-taken btn-primary btn-circle waves-effect waves-circle waves-float" style="width:30px;height:30px;" title="Invoice">
                    <i class="material-icons" style="left:-6px;top:-3px" >attach_money</i>
                </button>';
            $x++;
        }
                   
                            
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = 192;
        $result['iTotalDisplayRecords'] = 192;
        return $result;
    }


}


