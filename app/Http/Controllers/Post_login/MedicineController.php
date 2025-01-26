<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Master_Medicine;
use App\Models\M_Master_Medicine_Detail;
use App\Models\M_Master_Medicine_Stock;
use App\Models\M_Master_Medicine_Unit;
use Illuminate\Support\Facades\Input;

class MedicineController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $js[] = 'users';

        $data = [
            'js' => $js,
        ];
        return view('post-login-views.medicine.medicine_view', $data);
    }


    public function modal_entry($cd, $type){
        
        $disabled   =  "";

        if($cd != '0' and ($type == 'up' or $type == 'dt')){

            $result     = M_Master_Medicine::where("state", "Y")
                          ->where("code_medicine", $cd)->get()->first();
            $data2      = 'Data Update Obat';

            if($type == 'dt'){
                $data2      = 'Data Detail Obat';
                $disabled   =  " disabled ";
            }
            
        }else{
            $data2      = 'Data Entry Obat';
            $result     = array();
        }

        $unit           = M_Master_Medicine_Unit::where("state", "Y")->get();


        $data = [
            'result' => $result,
            'cd' => $cd,
            'type' => $type,
            'disabled' => $disabled,
            'unit' => $unit
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.medicine.medicine_modal_entry', $data) );
        
        
        $data3      = 'save-medicine';

        return json_encode(array($data1, $data2, $data3));
        
    }

    public function store_data()
    { 

        if(app('request')->exists('nama_obat_data') AND app('request')->exists('satuan_jenis_data')  AND app('request')->exists('cd') ){

            if(!Input::get('cd')){
                //NEW DATA
                $code   = get_prefix('ms_medicine'); 

                $Medicine                                = new M_Master_Medicine();
                $Medicine->code_medicine                 = $code;
                $Medicine->nama_obat                     = Input::get('nama_obat_data');
                $Medicine->code_medicine_unit            = Input::get('satuan_jenis_data');
                $Medicine->created_by                    = auth()->user()->code_user;

                $tipe                                    = 'simpan';

            }else{
                //UPDATE DATA
                $exists    = M_Master_Medicine::where('code_medicine', Input::get('cd'))->count();
            
                $tipe                                 = 'rubah';

                if($exists){

                    $Medicine                                = M_Master_Medicine::where('code_medicine', Input::get('cd'))->first();

                    $Medicine->nama_obat                     = Input::get('nama_obat_data');
                    $Medicine->code_medicine_unit            = Input::get('satuan_jenis_data');
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

// die(Input::get('cd_delete'));
            $Medicine                  = M_Master_Medicine_Detail::where('code_detail_medicine', Input::get('cd_delete'))->first();

            $Medicine->deleted_at      = date('Y-m-d H:i:s');
            $Medicine->deleted_by      = auth()->user()->code_user;
            $Medicine->state           = 'N';
            $Medicine->isShow           = 'N';

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

    public function store_stock()
    { 

        if(app('request')->exists('cd') AND app('request')->exists('stock_terbaru')  AND app('request')->exists('harga_beli_unit')  AND app('request')->exists('harga_beli_total') AND app('request')->exists('id') ){

            if(Input::get('cd')){

                if(Input::get('id') == 'tambah-stock'){
                    //NEW DATA

                    $Medicine                                = new M_Master_Medicine_Stock();
                    $Medicine->code_medicine                 = Input::get('cd');
                    $Medicine->harga_beli_satuan             = Input::get('harga_beli_unit');
                    $Medicine->harga_beli_total              = Input::get('harga_beli_total');
                    $Medicine->stock                         = Input::get('stock_terbaru');
                    $Medicine->created_by                    = auth()->user()->code_user;

                    $tipe                                    = 'simpan';

                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

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


            $Medicine                  = M_Master_Medicine_Stock::where('id', Input::get('cd_delete'))->first();

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
