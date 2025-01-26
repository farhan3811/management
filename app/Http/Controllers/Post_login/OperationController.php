<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Consult_Operation;
use App\Models\M_Income_Service;

use Illuminate\Support\Facades\Input;

class OperationController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $js[] = 'operation';
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
        return view('post-login-views.operation.operation_view', $data);
    }


    public function modal_entry($cd){
        
        if(substr($cd, 0, 3) == 'OAG'){

            $billed     = M_Income_Service::where("code_action", $cd)->where("state", "Y")->count();

            $result     = M_Consult_Operation::

            leftJoin('kmu_ps_afct_operation_agreement as a', 
                'kmu_ps_afct_operation.code_operation_agreement',         '=', 'a.code_operation_agreement')->

            leftJoin('kmu_ps_consult as b', 
                'a.code_consult',         '=', 'b.code_consult')->
                
            leftJoin('kmu_ps_queue_docter as c', 
                'b.code_queue_docter',                                  '=', 'c.code_queue_docter')->

            leftJoin('kmu_ps_visus as d', 
                'c.code_visus',                                         '=', 'd.code_visus')->

            leftJoin('kmu_ps_queue_visus_normal as e', 
                'd.code_queue_visus_normal',                            '=', 'e.code_queue_visus_normal')->

            leftJoin('kmu_ps_booking as f', 
                'e.code_booking',                                       '=', 'f.code_booking')->

            leftJoin('kmu_us_patient as g', 
            'f.code_patient',                                           '=', 'g.code_patient')->

            leftJoin('kmu_ms_operation_step as h', 
                'h.code_operation_step',                                '=', 'a.code_operation_step')
            

            ->where("kmu_ps_afct_operation.state", "Y")
            ->where("a.state", "Y")
            ->where("b.state", "Y")
            ->where("d.state", "Y")
            ->where("f.state", "Y")
            ->where("kmu_ps_afct_operation.code_operation_agreement", $cd);

            $result->select('kmu_ps_afct_operation.code_operation', 'g.nama_pasien', 'g.tanggal_lahir', 'g.jenis_kelamin', 'kmu_ps_afct_operation.*', 'h.name_operation_step', 'kmu_ps_afct_operation.created_at');

            // $disabled   = (isset($result->get()->first()->is_done))? ($result->get()->first()->is_done == 'Y')?  " disabled " : "" : "";
            $disabled = '';
            $data2      = 'Data Operasi';
            $data3      = 'save-operasi';

            $data = [
                'result' => $result,
                'cd_bkp' => $cd,
                'disabled' => $disabled,
                'billed' => $billed
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.operation.operation_modal_entry', $data) );


            return json_encode(array($data1, $data2, $data3));
        
        }
    }

    public function insert_operation()
    { 

        if(app('request')->exists('cd_agree')){

            $Operation                                = new M_Consult_Operation();
            $Operation->code_operation                = get_prefix('ps_afct_operation'); 
            $Operation->code_operation_agreement      = Input::get('cd_agree');
            $Operation->tanggal_operasi               = date('Y-m-d');
            $Operation->mulai_jam_operasi             = date('H:i:s');
            $Operation->created_by                    = auth()->user()->code_user;

            $tipe                                    = 'simpan';

            if($Operation->save()){

                $data1 = 1;
                $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                
            }else{

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

            }            
            return json_encode(array($data1, $data2));
        }

    }

    public function store_data()
    { 

        if(app('request')->exists('cd_op') AND app('request')->exists('diagnosa_pasca_bedah') AND app('request')->exists('berhenti_jam_operasi') AND app('request')->exists('jenis_operasi') AND app('request')->exists('nama_operator') AND app('request')->exists('kualifikasi_operator') AND app('request')->exists('asisten') AND app('request')->exists('scrub_nurse_I') AND app('request')->exists('scrub_nurse_II') AND app('request')->exists('circulated_nurse') AND app('request')->exists('jenis_anestesi') AND app('request')->exists('mulai_jam_anestesi') AND app('request')->exists('berhenti_jam_anestesi') AND app('request')->exists('bahan_anesteticum') AND app('request')->exists('nama_anestesist') AND app('request')->exists('kualifikasi_anestesist') AND app('request')->exists('golongan_operasi') AND app('request')->exists('macam_operasi') AND app('request')->exists('urgensi_operasi') AND app('request')->exists('catatan_operator') AND app('request')->exists('selesai') AND app('request')->exists('tagihan')){


                $Operation                                = M_Consult_Operation::where('code_operation', Input::get('cd_op'))->first();

                $Operation->diagnosa_pasca_bedah    = Input::get('diagnosa_pasca_bedah');
                $Operation->berhenti_jam_operasi    = Input::get('berhenti_jam_operasi');
                $Operation->jenis_operasi           = Input::get('jenis_operasi');
                $Operation->nama_operator           = Input::get('nama_operator');
                $Operation->kualifikasi_operator    = Input::get('kualifikasi_operator');
                $Operation->asisten                 = Input::get('asisten');
                $Operation->scrub_nurse_I           = Input::get('scrub_nurse_I');
                $Operation->scrub_nurse_II          = Input::get('scrub_nurse_II');
                $Operation->circulated_nurse        = Input::get('circulated_nurse');
                $Operation->jenis_anestesi          = Input::get('jenis_anestesi');
                $Operation->mulai_jam_anestesi      = Input::get('mulai_jam_anestesi');
                $Operation->berhenti_jam_anestesi   = Input::get('berhenti_jam_anestesi');
                $Operation->bahan_anesteticum       = Input::get('bahan_anesteticum');
                $Operation->nama_anestesist         = Input::get('nama_anestesist');
                $Operation->kualifikasi_anestesist  = Input::get('kualifikasi_anestesist');
                $Operation->golongan_operasi        = Input::get('golongan_operasi');
                $Operation->macam_operasi           = Input::get('macam_operasi');
                $Operation->urgensi_operasi         = Input::get('urgensi_operasi');
                $Operation->catatan_operator        = Input::get('catatan_operator');
                $Operation->updated_by              = date('Y-m-d H:i:s');
                $Operation->updated_by              = auth()->user()->code_user;
                $Operation->is_done                 = Input::get('selesai') == '0'? 'N' : 'Y';
                $Operation->is_billed               = Input::get('tagihan') == '0'? 'N' : 'Y';

                $tipe                                    = 'simpan';

                if($Operation->save()){

                        $data1 = 1;
                        $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                    
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
