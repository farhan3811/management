<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Master_Lab;
use App\Models\M_Master_Lab_Group;
use Illuminate\Support\Facades\Input;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function medical_reports(){

        $js[]         = 'reports_medical';
        $js[] = 'container-pasien';
        $css[] = 'table-queue';

        $data = [
            'js'         => $js,
            'css'         => $css
        ];
        return view('post-login-views.medical_report.medical_report_view', $data);
    }


    public function modal_entry($cd, $type){
        
        $disabled   =  "";

        if($cd != '0' and ($type == 'up' or $type == 'dt')){

            $result     = M_Master_Lab::leftJoin('kmu_ms_lab_group as b', 
                            'kmu_ms_lab.code_lab_group', '=', 'b.code_lab_group')
                          ->where("kmu_ms_lab.state", "Y")
                          ->where("code_lab", $cd)->get()->first();

            $data2      = 'Data Update Lab';

            if($type == 'dt'){
                $data2      = 'Data Detail lab';
                $disabled   =  " disabled ";
            }
            
        }else{
            $data2      = 'Data Entry lab';
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

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.laboratorium.laboratorium_modal_entry', $data) );
        
        
        $data3      = 'save-lab';

        return json_encode(array($data1, $data2, $data3));
        
    }


    public function autocomplete(){

        $term = Input::get('term');
        
        $results = array();
        
        $queries = M_Master_Lab_Group::where('group_lab', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->code_lab_group, 'value' => $query->group_lab ];
        }
        return \Response::json($results);
    }


    public function store_data(){ 

        if(app('request')->exists('group_lab_data') AND app('request')->exists('detail_lab_data') AND app('request')->exists('satuan_data') AND app('request')->exists('nilai_normal_data') AND app('request')->exists('cd') ){

            $gruplab = M_Master_Lab_Group::whereRaw('UPPER(group_lab) = \''.strtoupper(Input::get('group_lab_data')).'\'');

            if($gruplab->count()){
                $grupcode = $gruplab->first()->code_lab_group;
            }else{
                $grupcode = get_prefix('ms_lab_group');

                $LabGroup                                = new M_Master_Lab_Group();
                $LabGroup->code_lab_group                = $grupcode;
                $LabGroup->group_lab                     = Input::get('group_lab_data');
                $LabGroup->created_by                    = auth()->user()->code_user;

                $LabGroup->save();

            }

            if(!Input::get('cd')){
                //NEW DATA
                $code   = get_prefix('ms_lab'); 

                $Lab                                = new M_Master_Lab();
                $Lab->code_lab                      = $code;
                $Lab->code_lab_group                = $grupcode;
                $Lab->detail_lab                    = Input::get('detail_lab_data');
                $Lab->nilai_normal                  = Input::get('nilai_normal_data');
                $Lab->satuan                        = Input::get('satuan_data');
                $Lab->created_by                    = auth()->user()->code_user;

                $tipe                               = 'simpan';

            }else{
                //UPDATE DATA
                $exists    = M_Master_Lab::where('code_lab', Input::get('cd'))->count();
            
                $tipe                                 = 'rubah';

                if($exists){

                    $Lab                                = M_Master_Lab::where('code_lab', Input::get('cd'))->first();

                    $Lab->code_lab_group               = $grupcode;
                    $Lab->detail_lab                   = Input::get('detail_lab_data');
                    $Lab->nilai_normal                 = Input::get('nilai_normal_data');
                    $Lab->satuan                       = Input::get('satuan_data');
                    $Lab->updated_at                   = date('Y-m-d H:i:s');
                    $Lab->updated_by                   = auth()->user()->code_user;

                }else{

                    $data1 = 0;
                    $data2 = 'GAGAL! Data gagal di'.$tipe.'. Data Tidak ditemukan.';

                }

            }

            if($Lab->save()){

                $data1 = 1;
                $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                
            }else{

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

            }

        }elseif(app('request')->exists('cd_delete')){ 


            $Lab                  = M_Master_Lab::where('code_lab', Input::get('cd_delete'))->first();

            $Lab->deleted_at      = date('Y-m-d H:i:s');
            $Lab->deleted_by      = auth()->user()->code_user;
            $Lab->state           = 'N';

            $tipe                      = 'hapus';
            
            if($Lab->save()){

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
