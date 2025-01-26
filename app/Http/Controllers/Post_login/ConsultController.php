<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Booking;
use App\Models\M_Patient;
use App\Models\M_Dokter;
use App\Models\M_Consult;
use App\Models\M_Log_Login;
use App\Models\M_Queue_Docter;
// use App\Models\M_Dokter;
use App\Models\M_Master_Medicine;
use App\Models\M_Master_Medicine_Detail;
use App\Models\M_Master_Lab;
use App\Models\M_Consult_Medicine;
use App\Models\M_Income_Medicine;
use App\Models\M_Consult_Medicine_Details;
use App\Models\M_Consult_Reqlab;
use App\Models\M_Consult_Reqlab_Det;
use App\Models\M_Queue_Kacamata;
use App\Models\M_Queue_Consult;
use App\Models\M_Master_Operation_Type;
use App\Models\M_Consult_Operation_Agreement;
use App\Models\M_Income_Service;
use Illuminate\Support\Facades\Input;
use DB;

class ConsultController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($realtime = null){

        $js[] = 'consult';
        $js[] = 'container-pasien';
        $css[] = 'table-queue';

        $js_script[]  = 'vendors/jquery-ui/jquery-ui.min.js';
        $css_script[]  = 'vendors/jquery-ui/jquery-ui.min.css';
        $js_script[]  = 'vendors/jquery-signature/js/jquery.signature.min.js';
        $js_script[]  = 'adminbsb/plugins/jquery-steps/jquery.steps.js';
        $js_script[]  = 'adminbsb/js/pages/forms/form-wizard.js';
        $css_script[] = 'vendors/jquery-signature/css/jquery.signature.css';

        $js_script[]  = 'adminbsb/plugins/momentjs/moment.js';
        $js_script[]  = 'adminbsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js';
        $js_script[]  = 'adminbsb/js/pages/forms/basic-form-elements.js';
        $js_script[]  = 'responsivevoice/responsivevoice.js';
        $data = [
            'js' => $js,
            'css' => $css,
            'css_script' => $css_script,
            'js_script'  => $js_script,
            'realtime' => $realtime
        ];

        return view('post-login-views.consult.consult_view', $data);
    }


    public function modal_entry($cd_bkp){

        if(substr($cd_bkp, 0, 3) == 'QDR'){

            $billed     = M_Income_Service::where("code_action", $cd_bkp)->where("state", "Y")->count();
            $result     = M_Consult::where("state", "Y")
                          ->where("code_queue_docter", $cd_bkp)->get()->first();
            
            // $disabled   = (isset($result->is_done))? ($result->is_done == 'Y')?  " disabled " : "" : "";
            $disabled = '';
            $data2      = 'Lembar Kerja Konsultasi Dokter';
            $data3      = 'save-consult';

            $med            = array();
            $allmed         = array();
            $allmedcount    = array();
            
            $lab            = array();
            $allLab         = array();
            $allLabcount    = array();

            $operation_type = array();
            $selected_operation_type = array();
            $agree          = array();
            $dokter         = array();
            
            $today_summary = M_Booking::

            leftJoin('kmu_ps_queue_visus_normal as b', 
                'kmu_ps_booking.code_booking',                  '=', 'b.code_booking')->
            leftJoin('kmu_ps_visus as c', 
                'b.code_queue_visus_normal',                    '=', 'c.code_queue_visus_normal')->
            leftJoin('kmu_ps_queue_docter as d', 
                'd.code_visus',                                 '=', 'c.code_visus')->
            leftJoin('kmu_ps_consult as e', 
                'd.code_queue_docter',                          '=', 'e.code_queue_docter')->
            where('kmu_ps_booking.booking_tanggal', date('Y-m-d'))->
            where('e.is_done', 'Y')->
            select( DB::raw('SUM( if( is_glasses = \'Y\', 1, 0 )) AS glasses'), 
                    DB::raw('SUM( if( is_medicine = \'Y\', 1, 0 )) AS medicine'), 
                    DB::raw('SUM( if( is_refer = \'Y\', 1, 0 )) AS upload'), 
                    DB::raw('SUM( if( is_operation = \'Y\', 1, 0 )) AS operation'))->first();


            
            $allday_summary = M_Booking::

            leftJoin('kmu_ps_queue_visus_normal as b', 
                'kmu_ps_booking.code_booking',                  '=', 'b.code_booking')->
            leftJoin('kmu_ps_visus as c', 
                'b.code_queue_visus_normal',                    '=', 'c.code_queue_visus_normal')->
            leftJoin('kmu_ps_queue_docter as d', 
                'd.code_visus',                                 '=', 'c.code_visus')->
            leftJoin('kmu_ps_consult as e', 
                'd.code_queue_docter',                          '=', 'e.code_queue_docter')->
            where('e.is_done', 'Y')->
            select( DB::raw('SUM( if( is_glasses = \'Y\', 1, 0 )) AS glasses'), 
                    DB::raw('SUM( if( is_medicine = \'Y\', 1, 0 )) AS medicine'), 
                    DB::raw('SUM( if( is_refer = \'Y\', 1, 0 )) AS upload'), 
                    DB::raw('SUM( if( is_operation = \'Y\', 1, 0 )) AS operation'))->first();

            if(isset($result)){
                if($result->is_medicine == 'Y'){

                    $medobj   = M_Consult_Medicine_Details::
                
                    leftJoin('kmu_ps_afct_medicine as b', function($join)
                    {
                        $join->on('kmu_ps_afct_medicine_details.code_afct_medicine', '=', 'b.code_afct_medicine');
                        $join->where('b.state', '=', 'Y');
                    })->
        
                    where("b.id", M_Consult_Medicine::where('code_consult', $result->code_consult)->where('state', 'Y')->max('id'))->get();

                    foreach($medobj as $row){
                        
                        $med['code'][] = $row->code_medicine;
                        $med['jumlah'][] = $row->jumlah;

                    }

                    DB::statement(DB::raw('set @rownum=0'));

                    $allmed  = M_Master_Medicine::

                        leftJoin('kmu_ms_dt_medicine as a', function($join)
                                    {
                                        $join->on('kmu_ms_medicine.code_medicine', '=', 'a.code_medicine');
                                        $join->where('a.state', '=', 'Y');
                                    }
                                )->
                            
                        leftJoin('kmu_ms_medicine_stock as b', 
                            'kmu_ms_medicine.code_medicine',                        '=', 'b.code_medicine')->
                            
                        leftJoin('kmu_ms_medicine_unit as c', 
                            'kmu_ms_medicine.code_medicine_unit',                        '=', 'c.code_medicine_unit');

                    $allmed->where('kmu_ms_medicine.state',                          '=', 'Y');
                    
                    $allmed->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), DB::raw('max(kmu_ms_medicine.id) AS id'), 
                        DB::raw('(IFNULL((SELECT code_detail_medicine FROM kmu_ms_dt_medicine WHERE state = \'Y\' AND code_medicine = kmu_ms_medicine.`code_medicine`), 0)) AS code_detail_medicine'), 
                        'kmu_ms_medicine.code_medicine', 
                        DB::raw('max(nama_obat) AS nama_obat'), DB::raw('max(satuan) AS satuan'), 
                        DB::raw('sum(stock) AS stock'));

                    $allmed->groupBy('kmu_ms_medicine.code_medicine');

                    $allmed->orderBy(DB::raw('max(nama_obat)'), 'ASC');

                    $allmedcount = $allmed->get()->count();
                    $allmed = $allmed->get();
                        
                }

                if($result->is_operation == 'Y'){

                    $agree = M_Consult_Operation_Agreement::where('id', DB::raw("(select max(id) from kmu_ps_afct_operation_agreement where state = 'Y' and code_consult = '".$result->code_consult."')"))->get()->first();

                    if($agree){

                        $selected_operation_type = M_Master_Operation_Type::where('state', 'Y')->where('code_operation_step', $agree->code_operation_step)->first();

                        $operation_type = M_Master_Operation_Type::where('state', 'Y')->get();
                        $dokter = M_Dokter::where('state', 'Y')->get();
                        

                        $labobj   = M_Consult_Reqlab::leftJoin('kmu_ps_afct_reqlab_details as b', function($join)
                        {
                            $join->on('kmu_ps_afct_reqlab.code_reqlab',    '=', 'b.code_reqlab');
                            $join->on('b.state','=',DB::raw("'Y'"));
                        })
                            ->where("code_consult", $result->code_consult)->where("kmu_ps_afct_reqlab.state", "Y")->get();

                        foreach($labobj as $row){
                            $lab['code'][] = $row->code_lab;
                            $k = 0;
                            if($k == 0){
                                $lab['ket'] = $row->keterangan;
                                $k++;
                            }
                        }

                        DB::statement(DB::raw('set @rownum=0'));

                        $allLab  = M_Master_Lab::where('state', '=', 'Y');
                        
                        $allLab->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'code_lab', 'detail_lab');

                        $allLab->orderBy('detail_lab', 'ASC');

                        $allLabcount = $allLab->get()->count();
                        $allLab = $allLab->get();
                        
                    }else{
                        die('not setup yet by developers');
                    }
                        
                }
            }else{
                $result = new ConsultController;

                $result->is_medicine = 'N';

                $direct_glasses     = M_Queue_Consult::where("state", "Y")->where("code_queue_docter", $cd_bkp)->get()->first()->toVisus()->first()->is_glasses_direct_from_visus;
                

                $result->is_glasses = $direct_glasses;
                $result->is_glasses_direct = $direct_glasses;
                $result->is_refer = 'N';
                $result->is_operation = 'N';
                $result->desc = '';
                $result->is_billed = 'N';
                $result->is_done = 'N';
            }

            $data = [
                'result' => $result,
                'cd_bkp' => $cd_bkp,
                'disabled' => $disabled,
                'med' => $med,
                'allmed' => $allmed,
                'allmedcount' => $allmedcount,
                'lab' => $lab,
                'allLab' => $allLab,
                'allLabcount' => $allLabcount,
                'operation_type' => $operation_type,
                'selected_operation_type' => $selected_operation_type,
                'dokter' => $dokter,
                'agree' => $agree,
                'billed' => $billed,
                'today_summary' => $today_summary,
                'allday_summary' => $allday_summary,
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.consult.consult_modal_entry', $data) );

            return json_encode(array($data1, $data2, $data3));
        }
    }

    public function entry_medicine(){
        
        DB::statement(DB::raw('set @rownum=0'));
        $datas  = M_Master_Medicine::
                
            leftJoin('kmu_ms_medicine_stock as b', 
                'kmu_ms_medicine.code_medicine',                        '=', 'b.code_medicine')->
                
            leftJoin('kmu_ms_medicine_unit as c', 
                'kmu_ms_medicine.code_medicine_unit',                        '=', 'c.code_medicine_unit');

        $datas->where('kmu_ms_medicine.state',                          '=', 'Y');
        
        $datas->select(
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
            DB::raw('max(kmu_ms_medicine.id) AS id'),
            DB::raw('(IFNULL((SELECT code_detail_medicine FROM kmu_ms_dt_medicine WHERE state = \'Y\' AND code_medicine = kmu_ms_medicine.`code_medicine`), 0)) AS code_detail_medicine'), 
            'kmu_ms_medicine.code_medicine', 
            DB::raw('max(nama_obat) AS nama_obat'), 
            DB::raw('max(satuan) AS satuan'), 
            DB::raw('sum(stock) AS stock')
        );

        $datas->groupBy('kmu_ms_medicine.code_medicine');

        $datas->orderBy(DB::raw('MAX(nama_obat)'), 'ASC');



        $data = [
                'allmedcount' => $datas->get()->count(),
                'allmed' => $datas->get(),
                'disabled' => "",
            ];
        //-------------------------------

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.consult.consult_entry_medicine', $data) );

        return json_encode(array($data1));
        
    }

    public function entry_operation(){

        DB::statement(DB::raw('set @rownum=0'));
        $datas  = M_Master_Lab::
                
            leftJoin('kmu_ms_lab_group as a', 
                'kmu_ms_lab.code_lab_group',                        '=', 'a.code_lab_group');

        $datas->where('kmu_ms_lab.state',                          '=', 'Y');
        
        $datas->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'kmu_ms_lab.id', 'kmu_ms_lab.code_lab', 'group_lab', 'kmu_ms_lab.created_at', 'detail_lab', 'nilai_normal', 'group_lab', 'satuan');

        $datas->groupBy('kmu_ms_lab.id');

        $datas->orderBy('group_lab', 'ASC');
        $datas->orderBy('detail_lab', 'ASC');

        $dokter = M_Dokter::where('state', 'Y')->get();
        $operation_type = M_Master_Operation_Type::where('state', 'Y')->get();

        $data = [
                'allLabcount' => $datas->get()->count(),
                'allLab' => $datas->get(),
                'dokter' => $dokter,
                'operation_type' => $operation_type,
                'disabled' => "",
            ];
        //-------------------------------

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.consult.consult_entry_operation', $data) );

        return json_encode(array($data1));
        
    }


    public function store_data()
    { 

        if(app('request')->exists('kacamata') AND app('request')->exists('obat') AND app('request')->exists('rujukan') AND app('request')->exists('operasi') AND app('request')->exists('tagihan') AND app('request')->exists('selesai') AND app('request')->exists('cd_bkd') != ""){

            $getConsult                     = M_Consult::where('code_queue_docter', Input::get('cd_bkd'));
            $data1                          = 1;
            $exists                         = $getConsult->count();

            if(!$exists){
                $Consult                    = new M_Consult();
                $code                       = get_prefix('ps_consult'); 
                $Consult->code_consult      = $code;
                $Consult->created_by            = auth()->user()->code_user;
            }else{
                $Consult                    = $getConsult->first();
                $code                       = $Consult->code_consult;
                $Consult->updated_by        = auth()->user()->code_user;
                $Consult->updated_at        = date('Y-m-d h:i:s');
            }
            
            $Consult->code_queue_docter     = Input::get('cd_bkd');
            $Consult->on_behalf_of          = auth()->user()->code_user;
            $Consult->is_glasses            = Input::get('kacamata') == '0'? 'N' : 'Y';
            $Consult->is_medicine           = Input::get('obat')    == '0'? 'N' : 'Y';
            $Consult->is_refer              = Input::get('rujukan') == '0'? 'N' : 'Y';
            $Consult->is_operation          = Input::get('operasi') == '0'? 'N' : 'Y';
            // $Consult->is_billed             = Input::get('tagihan') == '0'? 'N' : 'Y';
            $Consult->is_done               = Input::get('selesai') == '0'? 'N' : 'Y';
            $Consult->desc                  = Input::get('keterangan');

            if($Consult->save()){

                $getBooking         = M_Queue_Consult::where('code_queue_docter', Input::get('cd_bkd'))->first()
                                        ->toVisus->toQueueVisusNormal->code_booking;

                if($exists){

                    $unactiveMedicine             = M_Consult_Medicine_Details::leftJoin('kmu_ps_afct_medicine as b', 
                    'kmu_ps_afct_medicine_details.code_afct_medicine',                        '=', 'b.code_afct_medicine')->where('b.code_consult', $code)->where('kmu_ps_afct_medicine_details.state', 'Y');

                    if($unactiveMedicine->count()){
                        $unactiveMedicine->update([
                                                    'kmu_ps_afct_medicine_details.updated_at' => date('Y-m-d H:i:s'),
                                                    'kmu_ps_afct_medicine_details.updated_by' => auth()->user()->code_user,
                                                    'kmu_ps_afct_medicine_details.state' => 'N',
                                                ]);
                    }

                    if(Input::get('operasi') == 0){
                        $unactiveReqlab               = M_Consult_Reqlab::where('code_consult', $code)->where('state', 'Y');
                        if($unactiveReqlab->count()){
                            $unactiveReqlab->update([
                                                        'deleted_at' => date('Y-m-d H:i:s'),
                                                        'deleted_by' => auth()->user()->code_user,
                                                        'state' => 'N',
                                                    ]);
                        }
                    }
                }

                //START OF SAVING MEDICINE
                if(Input::get('obat') == 1){
        
                    foreach(Input::get('med') as $i => $dat){
                        eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
                    }

                    foreach(Input::get('tot') as $i => $dat){
                        eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
                    }

                    $get_medicine_id            = M_Consult_Medicine::where('code_consult', $code)->where('state', 'Y')->max('id');

                    if($get_medicine_id != ''){
                        $code_afct_medicine           = M_Consult_Medicine::where('id', $get_medicine_id)->first()->code_afct_medicine;
                    }else{

                        $code_afct_medicine                          = get_prefix('ps_afct_medicine'); 

                        $Consult_Medicine                            = new M_Consult_Medicine();
                        $Consult_Medicine->code_afct_medicine        = $code_afct_medicine;
                        $Consult_Medicine->code_consult              = $code;
                        $Consult_Medicine->created_by                = auth()->user()->code_user;
                        $Consult_Medicine->save();

                    }

                    if(isset($med)){
                        if(count($med) > 0){
                            $x = 0;
                            foreach($med as $key => $row){
                                foreach($row as $key2 => $row2){

                                    $code_medicine_details[$x]                           = get_prefix('ps_afct_medicine_details'); 

                                    if(isset($tot[$key])){
                                        if($tot[$key] != 0 and $tot[$key] != ''){

                                            $Consult_Medicine                             = new M_Consult_Medicine_Details();
                                            $Consult_Medicine->code_afct_medicine_details = $code_medicine_details[$x];
                                            $Consult_Medicine->code_afct_medicine         = $code_afct_medicine;
                                            $Consult_Medicine->code_medicine              = $key;
                                            $Consult_Medicine->code_detail_medicine       = $key2;
                                            $Consult_Medicine->jumlah                     = $tot[$key];
                                            $Consult_Medicine->created_by                 = auth()->user()->code_user;

                                            if($Consult_Medicine->save()){

                                                $code_income_medicine                           = get_prefix('ps_income_medicine'); 

                                                $harga_jual           = M_Master_Medicine_Detail::where('code_detail_medicine', $key2)->first()->harga_jual;

                                                $Income_Medicine                              = new M_Income_Medicine();
                                                $Income_Medicine->code_ps_income_medicine     = $code_income_medicine;
                                                $Income_Medicine->code_afct_medicine_details  = $code_medicine_details[$x];
                                                $Income_Medicine->total                      = $tot[$key];
                                                $Income_Medicine->price                      = $tot[$key] * $harga_jual;
                                                $Income_Medicine->created_by                 = auth()->user()->code_user;
                                                
                                                $Income_Medicine->save();
                                            }else{

                                                $data1 = 0;
                                                $data2 = 'Gagal! Data berhasil masuk namun ada kesalahan';
                                                break;

                                            }

                                        }else{

                                            $data1 = 0;
                                            $data2 = 'Gagal! Obat yang anda masukan belum diisi jumlahnya.';
                                            break;
                                        }
                                    }else{

                                        $data1 = 0;
                                        $data2 = 'Gagal! Terdapat obat yang tidak ditemukan totalnya.';
                                        break;
                                    }
                                    $x++;
                                }
                            }

                            if($data1 == 0){
                                foreach($code_medicine_details as $failedrow){
                                    $unactiveMedicineDetails             = M_Consult_Medicine_Details::where('code_afct_medicine_details', $failedrow)->where('state', 'Y');
                                    $unactiveMedicineDetails->update([
                                                    'updated_at' => date('Y-m-d H:i:s'),
                                                    'updated_by' => auth()->user()->code_user,
                                                    'state' => 'N',
                                                ]);
                                }
                            }

                            //THIS IS LINE OF SUCCESS ABOUT SAVING THE MEDICINE

                        }else{

                            $data1 = 0;
                            $data2 = 'Gagal! Data obat tidak diisi.';

                        }
                    }else{

                        $data1 = 0;
                        $data2 = 'Gagal! Data obat tidak ditemukan/kosong.';

                    }

                }else{
                    $unactiveMedicine = M_Consult_Medicine::where('code_consult', $code)->where('state', 'Y');
                    $unactiveMedicine->update([
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->code_user,
                        'state' => 'N',
                    ]);
                }

                //START OF SAVING GLASSES
                if(Input::get('kacamata') == 1){

                    $checkGlasses       = M_Queue_Kacamata::where('code_booking', $getBooking);

                    if(!$checkGlasses->count()){
                        $code_glasses                       = get_prefix('ps_queue_visus_glasses'); 

                        $get_last_queue                     = M_Queue_Kacamata::with(array('toBooking' => function($q) {
                                                                 $q->where('booking_tanggal', date('Y-m-d'));
                                                                }))->where('state', 'Y')->orderBy('queue_no', 'desc')->first();

                                                                if(isset($get_last_queue->queue_no)){
                                                                    $get_last_queue = $get_last_queue->queue_no;
                                                                }else{
                                                                    $get_last_queue = 1;
                                                                }
                        $Consult_Glasses                            = new M_Queue_Kacamata;
                        $Consult_Glasses->code_queue_visus_glasses  = $code_glasses;
                        $Consult_Glasses->code_booking              = $getBooking;
                        $Consult_Glasses->queue_no                  = $get_last_queue + 1;
                        $Consult_Glasses->created_by                = auth()->user()->code_user;
                        $Consult_Glasses->save();
                        
                    }else{

                        if(M_Queue_Kacamata::where('code_booking', $getBooking)->where('state', 'N')->count()){

                            $getQueueKacamata                     = M_Queue_Kacamata::with(array('toBooking' => function($q) {
                                                                        $q->where('booking_tanggal', date('Y-m-d'));
                                                                    }))->where('code_booking', $getBooking)->first();

                            $getQueueKacamata->state  = 'Y';
                            $getQueueKacamata->save();

                        }
                    }

                }else{
                    $getGlasses = M_Queue_Kacamata::where('code_booking', $getBooking)->where('state', 'Y');
                    $getGlasses_count = $getGlasses->count();
                     if( $getGlasses_count){
                        if($getGlasses->where('is_called', 'Y')->count() > 0){

                            $data1 = 0;
                            $data2 = 'Gagal! Data kacamata gagal disimpan, pasien sudah dipanggil untuk periksa mata di visus';

                        }else{
                            
                            $getQueueKacamata                     = M_Queue_Kacamata::with(array('toBooking' => function($q) {
                                                                        $q->where('booking_tanggal', date('Y-m-d'));
                                                                    }))->where('code_booking', $getBooking)->first();

                            $getQueueKacamata->state  = 'N';
                            $getQueueKacamata->save();

                        }
                     }
                }



                if($data1 != 0){
                    $data2 = 'SUKSES! Data Konsultasi Pasien berhasil disimpan. silahkan cek kembali data tersebut pada table.';
                }

            }else{

                $data1 = 0;
                $data2 = 'Gagal! Data tidak berhasil disimpan. Silahkan cek kembali inputan anda';

            }

        }else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan refresh/cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }

    public function store_operasi()
    { 

        if(
            app('request')->exists('jenis_operasi') AND 
            app('request')->exists('agreement_check') AND 
            app('request')->exists('docter_code_of_operation') AND 
            app('request')->exists('informers') AND 
            app('request')->exists('recipient_of_information') AND 
            app('request')->exists('docter_signature_JSON') AND 
            app('request')->exists('docter_signature_JSON') AND 
            app('request')->exists('docter_signature_JSON') AND 
            app('request')->exists('docter_signature_JSON') AND 
            app('request')->exists('ket_lab') AND 
            app('request')->exists('cd_bkd') != ""){

            $getConsult                     = M_Consult::where('code_queue_docter', Input::get('cd_bkd'));
            $data1                          = 1;
            $exists                         = $getConsult->count();

            if(!$exists){
                $Consult                    = new M_Consult();
                $code                       = get_prefix('ps_consult'); 
                $Consult->code_consult      = $code;
                $Consult->created_by        = auth()->user()->code_user;
            }else{
                $Consult                    = $getConsult->first();
                $code                       = $Consult->code_consult;
                $Consult->updated_by        = auth()->user()->code_user;
                $Consult->updated_at        = date('Y-m-d h:i:s');
            }
            
            $Consult->code_queue_docter     = Input::get('cd_bkd');
            $Consult->on_behalf_of          = auth()->user()->code_user;
            $Consult->is_operation          = 'Y' ;

            if($Consult->save()){

                $getBooking         = M_Queue_Consult::where('code_queue_docter', Input::get('cd_bkd'))->first()->toVisus->toQueueVisusNormal->code_booking;

                 
                if($exists){

                    $unactiveAgreement            = M_Consult_Operation_Agreement::where('code_consult', $code)->where('state', 'Y');
                    if($unactiveAgreement->count()){
                        $unactiveAgreement->update([
                                                    'deleted_at' => date('Y-m-d H:i:s'),
                                                    'deleted_by' => auth()->user()->code_user,
                                                    'state' => 'N',
                                                ]);
                    }

                    $unactiveReqlab               = M_Consult_Reqlab::where('code_consult', $code)->where('state', 'Y');
                    if($unactiveReqlab->count()){
                        $unactiveReqlab->update([
                                                    'deleted_at' => date('Y-m-d H:i:s'),
                                                    'deleted_by' => auth()->user()->code_user,
                                                    'state' => 'N',
                                                ]);
                    }
                }

                //START OF SAVING LAB
                if(Input::get('agreement_check') == 1){
        

                    $Agreement                            = new M_Consult_Operation_Agreement();
                    $Agreement->code_operation_agreement  = get_prefix('ps_afct_operation_agreement'); 
                    $Agreement->code_consult              = $code;
                    $Agreement->code_operation_step       = Input::get('jenis_operasi');
                    $Agreement->isAgree                   = Input::get('agreement_check');
                    $Agreement->docter_code_of_operation  = Input::get('docter_code_of_operation');
                    $Agreement->informers                 = Input::get('informers');
                    $Agreement->recipient_of_information  = Input::get('recipient_of_information');
                    $Agreement->docter_signature_JSON     = Input::get('docter_signature_JSON');
                    $Agreement->docter_signature_JPEG     = Input::get('docter_signature_JPEG');
                    $Agreement->patient_signature_JSON    = Input::get('patient_signature_JSON');
                    $Agreement->patient_signature_JPEG    = Input::get('patient_signature_JPEG');
                    $Agreement->is_done                   = 'Y';
                    $Agreement->created_by                = auth()->user()->code_user;

                    if($Agreement->save()){
                        
                        $checkOperation       = M_Consult_Reqlab::where('code_consult', $code)->where('state', 'Y')->get();

                        foreach(Input::get('lab') as $i => $dat){
                            eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
                        }

                        $code_lab                                  = get_prefix('ps_afct_reqlab'); 

                        if(isset($lab)){
                            if(count($lab) > 0){
                                $x = 0;

                                if(!$checkOperation->count()){

                                    $Consult_Reqlab                            = new M_Consult_Reqlab();
                                    $Consult_Reqlab->code_reqlab               = $code_lab;
                                    $Consult_Reqlab->code_consult              = $code;
                                    $Consult_Reqlab->keterangan                = Input::get('ket_lab');
                                    $Consult_Reqlab->created_by                = auth()->user()->code_user;
                                    $Consult_Reqlab->save();

                                    foreach($lab as $key => $row){

                                        $code_lab_detail[$x]                           = get_prefix('ps_afct_reqlab_detail'); 

                                        $Consult_Reqlab_Det                            = new M_Consult_Reqlab_Det();
                                        $Consult_Reqlab_Det->code_reqlab_detail        = $code_lab_detail[$x];
                                        $Consult_Reqlab_Det->code_reqlab               = $code_lab;
                                        $Consult_Reqlab_Det->code_lab                  = $key;
                                        $Consult_Reqlab_Det->created_by                = auth()->user()->code_user;
                                        $Consult_Reqlab_Det->save();

                                        $x++;
                                    }

                                }else{
                                    
                                    $checkOperationStarted = M_Consult_Reqlab_Det::with(array('toReqLab' => function($q) 
                                                                use($code) {
                                                                    $q->where('code_consult', $code);
                                                                }))->whereNotNull('value')->get();

                                    if($checkOperationStarted->count() == 0){
                                            
                                        $checkOperation = $checkOperation->first();
                                        $codeReqLabOld = $checkOperation->code_reqlab ;

                                        if($checkOperation->state == 'Y'){

                                            $checkOperation->keterangan                = Input::get('ket_lab');
                                            $checkOperation->updated_at                = date('Y-m-d');
                                            $checkOperation->updated_by                = auth()->user()->code_user;
                                            $checkOperation->save();
                                            
                                        }else{

                                            $checkOperation->keterangan                = Input::get('ket_lab');
                                            $checkOperation->updated_at                = date('Y-m-d');
                                            $checkOperation->updated_by                = auth()->user()->code_user;$checkOperation->state                     = 'Y';
                                            $checkOperation->save();

                                        }

                                        // M_Consult_Reqlab_Det::whereRaw("code_reqlab in (SELECT code_reqlab FROM kmu_ps_afct_reqlab WHERE state = 'Y'")->delete();

                                        M_Consult_Reqlab_Det::where('state', 'Y')->whereRaw("code_reqlab in (SELECT code_reqlab FROM kmu_ps_afct_reqlab WHERE `code_consult` = '".$code."')")->update([
                                                        'updated_at' => date('Y-m-d H:i:s'),
                                                        'updated_by' => auth()->user()->code_user,
                                                        'state' => 'N',
                                                    ]);

                                        foreach($lab as $key => $row){

                                            $code_lab_detail[$x]                           = get_prefix('ps_afct_reqlab_detail'); 

                                            $Consult_Reqlab_Det                            = new M_Consult_Reqlab_Det();
                                            $Consult_Reqlab_Det->code_reqlab_detail        = $code_lab_detail[$x];
                                            $Consult_Reqlab_Det->code_reqlab               = $codeReqLabOld;
                                            $Consult_Reqlab_Det->code_lab                  = $key;
                                            $Consult_Reqlab_Det->created_by                = auth()->user()->code_user;
                                            $Consult_Reqlab_Det->updated_at                = date('Y-m-d');
                                            $Consult_Reqlab_Det->updated_by                = auth()->user()->code_user;
                                            $Consult_Reqlab_Det->save();

                                            $x++;
                                        }
                                    }else{

                                        $data1 = 0;
                                        $data2 = 'Gagal! Data operasi tidak dapat dirubah, pasien sudah diperiksa di lab.';
                                        
                                    }
                                }

                                //THIS IS LINE OF SUCCESS ABOUT SAVING THE MEDICINE

                            }else{

                                $data1 = 0;
                                $data2 = 'Gagal! Data Permintaan Lab tidak diisi.';

                            }
                        }else{

                            $data1 = 0;
                            $data2 = 'Gagal! Data Permintaan Lab tidak ditemukan/kosong.';

                        }
                    }else{


                        $data1 = 0;
                        $data2 = 'Gagal! Data persetujuan operasi gagal disimpan.';


                    }

                }else{

                    if($checkOperation->count()){
                        $checkOperation->deleted_at                = date('Y-m-d');
                        $checkOperation->deleted_by                = auth()->user()->code_user;
                        $checkOperation->state                     = 'N';
                        $checkOperation->save();                      
                    }

                }

                



                if($data1 != 0){
                    $data2 = 'SUKSES! Data konsultasi khusus pada bagian operasi berhasil disimpan. silahkan cek kembali data tersebut pada table.';
                }

            }else{

                $data1 = 0;
                $data2 = 'Gagal! Data tidak berhasil disimpan. Silahkan cek kembali inputan anda';

            }

        }else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan refresh/cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }


    public function operation_step($cd_step){
        
        $operation_type = M_Master_Operation_Type::where('state', 'Y')->where('code_operation_step', $cd_step)->first();

        $data = [
                'operation_type' => $operation_type,
            ];

        return json_encode(array($data));
        
    }

}
