<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Booking;
use App\Models\M_Patient;
use App\Models\M_Dokter;
use App\Models\M_Log_Login;
use App\Models\M_Queue_Visus;
use App\Models\M_Queue_Kacamata;
use App\Models\M_Visus;
use App\Models\M_Visus_Kacamata;
use App\Models\M_Visus_Kacamata_Receipt;
use App\Models\M_Glasses_Header;
use App\Models\M_Glasses_Sider;
use App\Models\M_Queue_Consult;
use App\Models\M_Income_Service;
use Illuminate\Support\Facades\Input;
use DB;

class VisusController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($realtime = null){

        $js[] = 'visus';
        $js[] = 'container-pasien';
        $css[] = 'table-queue';

        $js_script[]  = 'adminbsb/plugins/momentjs/moment.js';
        $js_script[]  = 'adminbsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js';
        $js_script[]  = 'adminbsb/js/pages/forms/basic-form-elements.js';
        $js_script[]  = 'responsivevoice/responsivevoice.js';

        $data = [
            'js' => $js,
            'css' => $css,
            'js_script'  => $js_script,
            'realtime' => $realtime
        ];

        return view('post-login-views.visus.visus_view', $data);
    }


    public function modal_entry($cd_bkp, $bypass = null){


        $billed = M_Income_Service::where("code_action", $cd_bkp)->where("state", "Y")->count();

        if(substr($cd_bkp, 0, 3) == 'QVN'){

            $result     = M_Visus::where("state", "Y")
                          ->where("code_queue_visus_normal", $cd_bkp)->get()->first();
            if($bypass == 'bypass'){
                $check_consult = M_Visus::
        
                leftJoin('kmu_ps_queue_docter as a', 
                    'kmu_ps_visus.code_visus',              '=', 'a.code_visus')->
                leftJoin('kmu_ps_consult as b', 
                    'a.code_queue_docter',              '=', 'b.code_queue_docter')->

                where('a.state', 'Y')->
                where('b.state', 'Y')->
                where('kmu_ps_visus.state', 'Y')->
                where('kmu_ps_visus.code_queue_visus_normal', $cd_bkp)->
                select('b.is_done');
                if(!$check_consult->count()){
                    $disabled = " ";
                }else{

                    if($check_consult->get()->first()->is_done == 'Y'){
                        $disabled   =  " disabled ";
                    }else{
                        $disabled = " ";
                    }
                }
            }else{
                // $disabled   = (isset($result->is_done))? ($result->is_done == 'Y')?  " disabled " : "" : "";
                $disabled = '';
            }
            $data2      = 'Data Pemeriksaan Visus';
            $data3      = 'save-visus';

        }elseif(substr($cd_bkp, 0, 3) == 'QVG'){
            $result['glasses']  = M_Visus_Kacamata::where("state", "Y")
                         ->where("code_queue_visus_glasses", $cd_bkp);
            
            if($result['glasses']->count()){
                foreach($result['glasses']->first()->toVisusGlassesReceipt as $data){
                    $result['glasses_receipt'][$data->glasses_sider_code][$data->glasses_header_code] = $data->value;
                }
            }else{
                $result['glasses_receipt'] = array();
            }

            $result['header'] = M_Glasses_Header::where("state", "Y")->get();
            $result['sider'] = M_Glasses_Sider::where("state", "Y")->get();

            $result['glasses'] = $result['glasses']->get()->first();

            
            if($bypass == 'bypass'){
                $check_consult = M_Queue_Kacamata::
        
                leftJoin('kmu_ps_queue_visus_normal as x', 
                    'x.code_booking',                           '=', 'kmu_ps_queue_visus_glasses.code_booking')->
                leftJoin('kmu_ps_visus as y', 
                    'x.code_queue_visus_normal',                '=', 'y.code_queue_visus_normal')->
                leftJoin('kmu_ps_queue_docter as a', 
                    'y.code_visus',                             '=', 'a.code_visus')->
                leftJoin('kmu_ps_consult as b', 
                    'a.code_queue_docter',                      '=', 'b.code_queue_docter')->

                where('a.state', 'Y')->
                where('b.state', 'Y')->
                where('x.state', 'Y')->
                where('y.state', 'Y')->
                where('kmu_ps_queue_visus_glasses.state', 'Y')->
                where('kmu_ps_queue_visus_glasses.code_queue_visus_glasses', $cd_bkp)->
                select('b.is_done');

                if(!$check_consult->count()){
                    $disabled = " ";
                }else{

                    if($check_consult->get()->first()->is_done == 'Y'){
                        $disabled   =  " disabled ";
                    }else{
                        $disabled = " ";
                    }
                }
            }else{
                $disabled   = (isset($result->is_done))? ($result->is_done == 'Y')?  " disabled " : "" : "";
            }

            $data2      = 'Data Kacamata Pasien';
            $data3      = 'save-kacamata';

        }

        $data = [
            'result' => $result,
            'cd_bkp' => $cd_bkp,
            'disabled' => $disabled,
            'bypass' => $bypass,
            'billed' => $billed,
        ];

        if(substr($cd_bkp, 0, 3) == 'QVN'){

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.visus.visus_modal_entry', $data) );

        }elseif(substr($cd_bkp, 0, 3) == 'QVG'){

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.visus.visus_kacamata_modal_entry', $data) );

        }

        return json_encode(array($data1, $data2, $data3));
    }


    public function store_data()
    { 

        if(app('request')->exists('visus_mata_kanan') AND app('request')->exists('visus_mata_kiri') AND app('request')->exists('segment_anterior') AND app('request')->exists('segment_posterior') AND app('request')->exists('penglihatan_warna') AND app('request')->exists('keterangan') AND app('request')->exists('saran') AND app('request')->exists('tagihan') AND app('request')->exists('selesai') AND app('request')->exists('queue') != ""){

            $tipe = null;
            $prev_done = 'N';
            $exists    = M_Visus::where('code_queue_visus_normal', Input::get('queue'))->count();

            if(!$exists){
                $prev_done = 'Y';
                $code   = get_prefix('ps_visus'); 

                $Visus                                = new M_Visus();
                $Visus->code_visus                    = $code;
                $Visus->code_queue_visus_normal       = Input::get('queue');
                $Visus->visus_mata_kanan              = Input::get('visus_mata_kanan');
                $Visus->visus_mata_kiri               = Input::get('visus_mata_kiri');
                $Visus->segment_anterior              = Input::get('segment_anterior');
                $Visus->segment_posterior             = Input::get('segment_posterior');
                $Visus->penglihatan_warna             = Input::get('penglihatan_warna');
                $Visus->keterangan                    = Input::get('keterangan');
                $Visus->saran                         = Input::get('saran');
                $Visus->is_glasses_direct_from_visus  = Input::get('kacamata') == '0'? 'N' : 'Y';
                $Visus->is_done                       = Input::get('selesai') == '0'? 'N' : 'Y';
                // $Visus->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
                $Visus->created_by                    = auth()->user()->code_user;

                $tipe                                 = 'simpan';

            }else{
                Input::get('selesai') == '0'?: $prev_done = 'Y';

                $Visus                                 = M_Visus::where('code_queue_visus_normal', Input::get('queue'))->first();
                $Visus->visus_mata_kanan              = Input::get('visus_mata_kanan');
                $Visus->visus_mata_kiri               = Input::get('visus_mata_kiri');
                $Visus->segment_anterior              = Input::get('segment_anterior');
                $Visus->segment_posterior              = Input::get('segment_posterior');
                $Visus->penglihatan_warna             = Input::get('penglihatan_warna');
                $Visus->keterangan                    = Input::get('keterangan');
                $Visus->saran                         = Input::get('saran');
                $Visus->is_glasses_direct_from_visus  = Input::get('kacamata') == '0'? 'N' : 'Y';
                $Visus->is_done                       = Input::get('selesai') == '0'? 'N' : 'Y';
                // $Visus->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
                $Visus->updated_at                    = date('Y-m-d H:i:s');
                $Visus->updated_by                    = auth()->user()->code_user;

                $tipe                                 = 'rubah';

            }

            $done                                 = $Visus->is_done;
            // $billed                               = $Visus->is_billed;

            if($Visus->save()){
                $direct_glasses_exists = M_Queue_Kacamata::
        
                leftJoin('kmu_ps_queue_visus_normal as a', 
                    'kmu_ps_queue_visus_glasses.code_booking',              '=', 'a.code_booking')->
                leftJoin('kmu_ps_visus as b', 
                    'a.code_queue_visus_normal',              '=', 'b.code_queue_visus_normal')->

                where('a.code_queue_visus_normal', Input::get('queue'))->
                where('kmu_ps_queue_visus_glasses.state', 'Y')->
                where('b.is_glasses_direct_from_visus', 'Y');

                if(Input::get('kacamata') != '0'){
                    
                    if(!$direct_glasses_exists->count()){
                        $code_glasses                       = get_prefix('ps_queue_visus_glasses'); 

                        $get_last_queue                     = M_Queue_Kacamata::with(array('toBooking' => function($q) {
                            $q->where('booking_tanggal', date('Y-m-d'));
                         }))->where('state', 'Y')->orderBy('queue_no', 'desc')->first()->queue_no;

                        $Consult_Glasses                            = new M_Queue_Kacamata;
                        $Consult_Glasses->code_queue_visus_glasses  = $code_glasses;
                        $Consult_Glasses->code_booking              =  M_Queue_Visus::where('code_queue_visus_normal', Input::get('queue'))->where('state', 'Y')->first()->code_booking;
                        $Consult_Glasses->queue_no                  = $get_last_queue + 1;
                        $Consult_Glasses->created_by                = auth()->user()->code_user;
                        $Consult_Glasses->save();
                    }
                }else{

                    if($direct_glasses_exists->count()){
                        $getQueueKacamata                     = $direct_glasses_exists->first();

                        $getQueueKacamata->state  = 'N';
                        $getQueueKacamata->save();

                    }
                }
               
                $data1 = 1;
                $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                
                if($done == 'Y' and Input::get('kacamata') == '0' and Input::get('bypass') != 'bypass'){
                    if($tipe == 'simpan' || ($tipe == 'rubah' && $prev_done == 'N')) {
                        $code   = get_prefix('ps_queue_docter'); 
                        $last_current_queue     = M_Queue_Consult::where('state', 'Y')
                                                ->whereRaw ('DATE(created_at) = CURRENT_DATE()')
                                                ->max('queue_no');
                                                        
                        if(empty($last_current_queue)){
                            $new_queue = 1;
                        }else{
                            $new_queue = $last_current_queue + 1;
                        }

                        $M_Queue_Consult                                = new M_Queue_Consult();
                        $M_Queue_Consult->code_queue_docter             = $code;
                        $M_Queue_Consult->code_visus                    = $Visus->code_visus;
                        $M_Queue_Consult->queue_no                      = $new_queue;
                        $M_Queue_Consult->created_by                    = auth()->user()->code_user;
                        $M_Queue_Consult->save();
                    }
                }

            }else{
                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';
            }

        }else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }


    public function store_kacamata_data()
    { 
        
        foreach(Input::get('receipt') as $i => $dat){

            eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');

        }

        if(app('request')->exists('receipt') AND app('request')->exists('pro_data') AND app('request')->exists('tahun_data') AND app('request')->exists('tipe1') AND app('request')->exists('tipe2') AND app('request')->exists('queue') AND app('request')->exists('selesai') AND app('request')->exists('tagihan')){

            if(strlen(Input::get('tahun_data')) > 4){

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal disimpan. Tahun maximal 4 angka. Tidak bisa lebih.';

            }else{

                $exists    = M_Visus_Kacamata::where('code_queue_visus_glasses', Input::get('queue'))->count();

                if(!$exists){

                    $code   = get_prefix('ps_afct_glasses'); 

                    $Glasses                                = new M_Visus_Kacamata();
                    $Glasses->code_afct_glasses             = $code;
                    $Glasses->code_queue_visus_glasses      = Input::get('queue');
                    $Glasses->tipe                          = Input::get('tipe1') == 1? 'BIFOKUS' : Input::get('tipe2') == 1? 'NORMAL' : '';
                    $Glasses->pro                           = Input::get('pro_data');
                    $Glasses->tahun                         = Input::get('tahun_data');
                    $Glasses->is_done                       = Input::get('selesai') == '0'? 'N' : 'Y';
                    // $Glasses->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
                    $Glasses->created_by                    = auth()->user()->code_user;
                    

                    foreach($KACAMATA as $key1 => $data1){
                        foreach($data1 as $key2 => $data2){

                            $code                                   = get_prefix('ps_afct_glasses_receipt'); 

                            $Receipt                                = new M_Visus_Kacamata_Receipt();
                            $Receipt->code_afct_glasses_receipt     = $code;
                            $Receipt->code_afct_glasses             = $Glasses->code_afct_glasses;
                            $Receipt->glasses_header_code           = $key2;
                            $Receipt->glasses_sider_code            = $key1;
                            $Receipt->value                         = $data2;
                            $Receipt->created_by                    = auth()->user()->code_user;

                            $Receipt->save();
                        }
                    }

                    $tipe                                           = 'simpan';

                }else{

                    $Glasses                                  = M_Visus_Kacamata::where('code_queue_visus_glasses', Input::get('queue'))->first();

                    if(Input::get('tipe1')){
                        $Glasses->tipe = 'BIFOKUS';
                    }elseif(Input::get('tipe2')){
                        $Glasses->tipe = 'NORMAL';
                    }

                    $Glasses->pro                           = Input::get('pro_data');
                    $Glasses->tahun                         = Input::get('tahun_data');
                    $Glasses->is_done                       = Input::get('selesai') == '0'? 'N' : 'Y';
                    // $Glasses->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
                    $Glasses->updated_at                    = date('Y-m-d H:i:s');
                    $Glasses->updated_by                    = auth()->user()->code_user;

                    foreach($KACAMATA as $key1 => $data1){

                        foreach($data1 as $key2 => $data2){

                            $Receipt                        =   M_Visus_Kacamata_Receipt::
                                                                where('code_afct_glasses', $Glasses->code_afct_glasses)->
                                                                where('glasses_header_code', $key2)->
                                                                where('glasses_sider_code', $key1)->
                                                                first();
                            if($Receipt){

                                $Receipt->value                 = $data2;
                                $Receipt->updated_at            = date('Y-m-d H:i:s');
                                $Receipt->updated_by            = auth()->user()->code_user;
                                
                            }else{
                                
                                $code                                   = get_prefix('ps_afct_glasses_receipt'); 

                                $Receipt                                = new M_Visus_Kacamata_Receipt();
                                $Receipt->code_afct_glasses_receipt     = $code;
                                $Receipt->code_afct_glasses             = $Glasses->code_afct_glasses;
                                $Receipt->glasses_header_code           = $key2;
                                $Receipt->glasses_sider_code            = $key1;
                                $Receipt->value                         = $data2;
                                $Receipt->created_by                    = auth()->user()->code_user;

                                $Receipt->save();
                            }
                            $Receipt->save();
                        }
                    }

                    $tipe                                   = 'rubah';

                }

                $done                                 = $Glasses->is_done;
                // $billed                               = $Glasses->is_billed;

                if($Glasses->save()){
                    if($Glasses->is_done == 'Y'){

                        $direct_glasses_exists = M_Visus::
                
                        leftJoin('kmu_ps_queue_visus_normal as a', 
                            'kmu_ps_visus.code_queue_visus_normal',              '=', 'a.code_queue_visus_normal')->
                        leftJoin('kmu_ps_queue_visus_glasses as b', 
                            'a.code_booking',              '=', 'b.code_booking')->

                        where('b.code_queue_visus_glasses', Input::get('queue'))->
                        where('b.state', 'Y')->
                        where('kmu_ps_visus.is_glasses_direct_from_visus', 'Y');

                        if($direct_glasses_exists->count() and Input::get('bypass') != 'bypass'){
                            $code   = get_prefix('ps_queue_docter'); 

                            $last_current_queue     = M_Queue_Consult::where('state', 'Y')
                                                    ->whereRaw ('DATE(created_at) = CURRENT_DATE()')
                                                    ->max('queue_no');
                                                            
                            if(empty($last_current_queue)){
                                $new_queue = 1;
                            }else{
                                $new_queue = $last_current_queue + 1;
                            }

                            $M_Queue_Consult                                = new M_Queue_Consult();
                            $M_Queue_Consult->code_queue_docter             = $code;
                            $M_Queue_Consult->code_visus                    = $direct_glasses_exists->first()->code_visus;
                            $M_Queue_Consult->queue_no                      = $new_queue;
                            $M_Queue_Consult->created_by                    = auth()->user()->code_user;
                            
                            $M_Queue_Consult->save();
                            //Masuk ke biling tagihan
                        }
                    }
                    $data1 = 1;
                    $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                    
                    if($done == 'Y'){
                        //Masuk ke biling tagihan
                        // if($billed){

                        // }else{

                        // }
                    }

                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

                }
            }

        }else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }
}
