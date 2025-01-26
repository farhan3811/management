<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Income_Service;
use App\Models\M_Service;
use Illuminate\Support\Facades\Input;

class ServicePriceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($realtime = null){

        $js[] = 'service_price';

        $data = [
            'js' => $js
        ];

        return view('post-login-views.service_price.service_price_view', $data);
    }


    public function modal_entry($cd, $type){

        $disabled   =  "";

        if($cd != '0' and ($type == 'up' or $type == 'dt')){

            $result     = M_Service::where("state", "Y")
                          ->where("code_service", $cd)->get()->first();

            $data2      = 'Entry Data Harga Pelayanan';

            if($type == 'dt'){
                $data2      = 'Data Data Harga Pelayanan';
                $disabled   =  " disabled ";
            }
            
        }else{
            $data2      = 'Data Harga Pelayanan';
            $result     = array();
        }

        // $unit           = M_Master_Medicine_Unit::where("state", "Y")->get();


        $data = [
            'result' => $result,
            'cd' => $cd,
            'type' => $type,
            'disabled' => $disabled,
            // 'unit' => $unit
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.service_price.service_price_modal_entry', $data) );
        
        
        $data3      = 'save-service-price';

        return json_encode(array($data1, $data2, $data3));
        
    }


    public function store_data()
    { 

        if(app('request')->exists('cd') AND app('request')->exists('service_name_data')  AND app('request')->exists('service_category_data') AND app('request')->exists('service_subcategory_data') AND app('request')->exists('price_data') AND app('request')->exists('is_multiple_data') ){

            if(!Input::get('up')){

                //UPDATE DATA
                $exists    = M_Service::where('code_service', Input::get('cd'))->count();
            
                $tipe                                 = 'rubah';

                if($exists){

                    $ServPrice = M_Service::where('code_service', Input::get('cd'))->first();

                    $ServPrice->deleted_at      = date('Y-m-d H:i:s');
                    $ServPrice->deleted_by      = auth()->user()->code_user;
                    $ServPrice->state           = 'N';
                    
                    $ServPrice->save();


                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Service Tidak ditemukan.';

                }
            }else{

                $tipe                                 = 'simpan';

            }

            //NEW DATA
            $code   = get_prefix('ms_service_price'); 

            $ServPrice                                = new M_Service();
            $ServPrice->code_service            = $code;
            $ServPrice->service_name                  = Input::get('service_name_data');
            $ServPrice->service_category              = Input::get('service_category_data');
            $ServPrice->service_subcategory           = Input::get('service_subcategory_data');
            $ServPrice->price                         = Input::get('price_data');
            $ServPrice->is_multiple                   = Input::get('is_multiple_data');
            $ServPrice->created_by                    = auth()->user()->code_user;

            $tipe                                    = 'simpan';

            if($ServPrice->save()){

                $data1 = 1;
                $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                
            }else{

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

            }

        }elseif(app('request')->exists('cd_delete')){ 


            $ServPrice                  = M_Service::where('code_service', Input::get('cd_delete'))->first();

            $ServPrice->deleted_at      = date('Y-m-d H:i:s');
            $ServPrice->deleted_by      = auth()->user()->code_user;
            $ServPrice->state           = 'N';

            $tipe                      = 'hapus';
            
            if($ServPrice->save()){

                $data1 = 1;
                $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                
            }else{

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

            }
        } else {

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
                    $Glasses->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
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
                    $Glasses->is_billed                     = Input::get('tagihan') == '0'? 'N' : 'Y';
                    $Glasses->updated_at                    = date('Y-m-d H:i:s');
                    $Glasses->updated_by                    = auth()->user()->code_user;

                    foreach($KACAMATA as $key1 => $data1){
                        foreach($data1 as $key2 => $data2){

                            $Receipt                        =   M_Visus_Kacamata_Receipt::
                                                                where('code_afct_glasses', $Glasses->code_afct_glasses)->
                                                                where('glasses_header_code', $key2)->
                                                                where('glasses_sider_code', $key1)->
                                                                first();

                            $Receipt->value                 = $data2;
                            $Receipt->updated_at            = date('Y-m-d H:i:s');
                            $Receipt->updated_by            = auth()->user()->code_user;

                            $Receipt->save();
                        }
                    }

                    $tipe                                   = 'rubah';

                }

                $done                                 = $Glasses->is_done;
                $billed                               = $Glasses->is_billed;

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
                        if($billed){

                        }else{

                        }
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
