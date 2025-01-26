<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Consult_Reqlab;
use App\Models\M_Consult_Reqlab_Det;
use App\Models\M_Income_Service;
use Illuminate\Support\Facades\Input;

class ReqLaboratoriumController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $js[] = 'reqlab';
        $js[] = 'container-pasien';
        $css[] = 'table-queue';
        $css_script[]  = '';

        $js_script[]  = 'adminbsb/plugins/momentjs/moment.js';
        $js_script[]  = 'adminbsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js';
        $js_script[]  = 'adminbsb/js/pages/forms/basic-form-elements.js';

        $data = [
            'js' => $js,
            'css' => $css,
            'css_script' => $css_script,
            'js_script'  => $js_script,
        ];
        return view('post-login-views.reqlab.reqlab_view', $data);
    }


    public function modal_entry($cd){
        
        if(substr($cd, 0, 3) == 'CON'){

            $billed     = M_Income_Service::where("code_action", $cd)->where("state", "Y")->count();
            $result     = M_Consult_Reqlab::where("state", "Y")
                          ->where("code_consult", $cd)->get();
            // $disabled   = (isset($result->first()->is_done))? ($result->first()->is_done == 'Y')?  " disabled " : "" : "";
            $disabled = '';
            $data2      = 'Data Request Laboratorium';
            $data3      = 'save-lab';

            $data = [
                'result' => $result,
                'cd_bkp' => $cd,
                'disabled' => $disabled,
                'billed' => $billed
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.reqlab.reqlab_modal_entry', $data) );


            return json_encode(array($data1, $data2, $data3));
        
        }
    }

    public function store_data()
    { 

        if(app('request')->exists('val') AND app('request')->exists('stat') AND app('request')->exists('selesai') AND app('request')->exists('tagihan')){

            foreach(Input::get('val') as $i => $dat){
                eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
            }

            foreach(Input::get('stat') as $i => $dat){
                eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
            }

            foreach($cd_val as $key => $val ){


                $ReqlabDet                                = M_Consult_Reqlab_Det::where('id', $key)->first();

                $codereqlab                               = $ReqlabDet->code_reqlab;
                $ReqlabDet->value                         = $val;
                $ReqlabDet->positif_or_negatif            = $cd_state[$key];
                $ReqlabDet->entered_at                    = date('Y-m-d H:i:s');
                $ReqlabDet->entered_by                    = auth()->user()->code_user;
                $ReqlabDet->updated_by                    = date('Y-m-d H:i:s');
                $ReqlabDet->updated_by                    = auth()->user()->code_user;
                $tipe                                    = 'simpan';

                if($ReqlabDet->save()){

                    $Reqlab                                = M_Consult_Reqlab::where('code_reqlab', $codereqlab)->first();

                    $Reqlab->is_done                           = Input::get('selesai') == '0'? 'N' : 'Y';
                    $Reqlab->is_billed                         = Input::get('tagihan') == '0'? 'N' : 'Y';
                    $Reqlab->updated_by                    = date('Y-m-d H:i:s');
                    $Reqlab->updated_by                    = auth()->user()->code_user;
                    $tipe                                    = 'simpan';                  
                    if($Reqlab->save()){

                        $data1 = 1;
                        $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                    
                    }else{

                        $data1 = 0;
                        $data2 = 'GAaGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';
                        
                    }
                    
                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

                }

            }

        } else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }

    public function modal_stock($cd){

        if($cd){

            $result     = M_Master_Medicine_Stock::where("state", "Y")
                          ->where("code_medicine", $cd)->get();

            $disabled   =  "";

            $data = [
                'result' => $result,
                'cd' => $cd,
                'disabled' => $disabled
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.medicine.medicine_modal_stock', $data) );
            
            $data2      = 'Data Stock Obat';
            $data3      = 'save';

            $data4     = M_Master_Medicine::where("state", "Y")
                          ->where("code_medicine", $cd)->get()->first()->nama_obat;

            return json_encode(array($data1, $data2, $data3, $data4));

        }else{
            $result     = array();
        }
        
    }

    public function modal_price($cd){

        if($cd){

            $data = [
                'result' => array(),
                'cd' => $cd,
                'disabled' => ""
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.medicine.medicine_modal_price', $data) );
            
            $data2      = 'Data Harga Obat';
            $data3      = 'save';

            $data4     = M_Master_Medicine::where("state", "Y")
                          ->where("code_medicine", $cd)->get()->first();
            
            $data4 = isset($data4)? $data4->nama_obat : '-';
            return json_encode(array($data1, $data2, $data3, $data4));

        }else{
            $result     = array();
        }
        
    }


    public function store_price()
    { 

        if(app('request')->exists('cd') AND app('request')->exists('harga_jual') AND app('request')->exists('id') ){

            if(Input::get('cd')){

                if(Input::get('id') == 'tambah-price'){
                    //NEW DATA
                    $code   = get_prefix('ms_dt_medicine'); 

                    $Medicine                                = M_Master_Medicine_Detail::where('code_medicine', Input::get('cd'));

                    $Medicine->update([
                        'state' => 'N', 
                        'updated_at' => date('Y-m-d H:i:s'), 
                        'updated_by' => auth()->user()->code_user
                    ]);

                    $Medicine                                = new M_Master_Medicine_Detail();
                    $Medicine->code_detail_medicine          = $code;
                    $Medicine->code_medicine                 = Input::get('cd');
                    $Medicine->harga_jual                    = Input::get('harga_jual');
                    $Medicine->created_by                    = auth()->user()->code_user;

                    $tipe                                    = 'simpan';

                }elseif(Input::get('id') == 'ubah-price'){
                    //UPDATE DATA
                    $exists    = M_Master_Medicine_Detail::where('code_medicine', Input::get('cd'))->count();
                
                    $tipe                                 = 'rubah';

                    if($exists){

                        $Medicine                                = M_Master_Medicine::where('code_detail_medicine', Input::get('cd_dt'))->first();

                        $Medicine->harga_jual                    = Input::get('harga_jual');
                        $Medicine->updated_at                    = date('Y-m-d H:i:s');
                        $Medicine->updated_by                    = auth()->user()->code_user;


                    }else{

                        $data1 = 0;
                        $data2 = 'GAGAL! Data gagal di'.$tipe.'. Obat Tidak ditemukan.';

                    }

                }

            
                if($Medicine->save()){

                    $data1 = 1;
                    $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                    
                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

                }
                
            }else{

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di simpan. Silahkan periksa kembali inputan anda.';

            }

        }elseif(app('request')->exists('cd_delete')){ 


            $Medicine                  = M_Master_Medicine::where('code_medicine', Input::get('cd_delete'))->first();

            $Medicine->deleted_at      = date('Y-m-d H:i:s');
            $Medicine->deleted_by      = auth()->user()->code_user;
            $Medicine->state           = 'N';

            $tipe                      = 'hapus';
            
            if($Medicine->save()){

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
}
