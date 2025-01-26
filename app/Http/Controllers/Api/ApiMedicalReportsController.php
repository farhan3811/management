<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Patient;
use DB;

class ApiMedicalReportsController extends Controller{

    public function getMedicalReports($params){

        // MAIN QUERY
        $datas = M_Patient::
            leftJoin('kmu_ms_rg_regencies as a', 
                'kmu_us_patient.kota_pasien',  '=', 'a.id')->where('kmu_us_patient.state', '=', 'Y');

        // FILTER WHERE
        if($params['search']['value'] != ''){
            $datas->where(function($q) use($datas, $params){
                $q->orWhere('id_rekam_medis',                     'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('nama_pasien',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('tanggal_lahir',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('a.name',                        'LIKE', '%'.$params['search']['value'].'%');
                $q->orWhere('kmu_us_patient.created_at',       'LIKE', '%'.$params['search']['value'].'%');
            });
        }

        //ORDER BY substr($data->created_at, 11, 8)
        if($params['order'][0]['column'] == 0){
            $column = 'kmu_us_patient.id';
        }elseif($params['order'][0]['column'] == 1){
            $column = 'id_rekam_medis';
        }elseif($params['order'][0]['column'] == 2){
            $column = 'nama_pasien';
        }elseif($params['order'][0]['column'] == 3){
            $column = 'tanggal_lahir';
        }elseif($params['order'][0]['column'] == 4){
            $column = 'a.name';
        }elseif($params['order'][0]['column'] == 5){
            $column = 'substr(kmu_us_patient.created_at, 0, 10)';
        }else{
            $column = 'kmu_us_patient.id';
        }
        $datas->select('id_rekam_medis', 'nama_pasien', 'tanggal_lahir', 'a.name', 'kmu_us_patient.created_at');

        // $datas->select('a.code_consult', DB::raw('max(kmu_ps_afct_reqlab.created_at) AS created_at'), DB::raw('max(id_rekam_medis) AS id_rekam_medis'), DB::raw('max(nama_pasien) AS nama_pasien'), DB::raw('max(nama_dokter) AS nama_dokter'), DB::raw('max(kmu_ps_afct_reqlab.is_done) AS is_done'));

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

            $rows[$x][0] = $data->id_rekam_medis;
            $rows[$x][1] = $data->id_rekam_medis;
            $rows[$x][2] = $data->nama_pasien;
            $rows[$x][3] = $data->tanggal_lahir;
            $rows[$x][4] = $data->name;
            $rows[$x][5] = substr($data->created_at, 0, 10);
            $x++;
        }
                                
        $result['aaData'] = $rows;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = $total;
        return $result;
    }

    
}


