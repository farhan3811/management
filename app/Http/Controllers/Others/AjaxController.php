<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\M_Service;
use App\Models\M_Income_Service;
use App\Models\M_Consult;
use App\Models\M_Booking;
use App\Models\M_Visus;
use App\Models\M_Visus_Kacamata;
use App\Models\M_Consult_Reqlab;
use App\Models\M_Consult_Operation;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public function wilayahprovinsi(){
        $propinsi = DB::table("provinces")->pluck("name","id");
        return view('tampilan.wilayah',['propinsi'=>$propinsi]);
    }

    public function kabupaten($id){
        $cities = DB::table("kmu_ms_rg_regencies")->where("province_id",$id)->pluck("name","id");
        return json_encode($cities);
    }
    public function Kecamatan($id){
        $cities = DB::table("kmu_ms_rg_districts")->where("regency_id",$id)->pluck("name","id");
        return json_encode($cities);
    }
    public function kelurahan($id){
        $cities = DB::table("kmu_ms_rg_villages")->where("district_id",$id)->pluck("name","id");
        return json_encode($cities);
    }
    public function getdokterbyid($code_poli){
        $dokter = DB::table("kmu_us_docter")->where("code_poliklinik", $code_poli)->where("state","Y")->pluck("code_docter","nama_dokter");
        return json_encode($dokter);
    }
    public function getwaktubyid($id, $tgl){
        $DateTime = new \DateTime();
        $datetime = $DateTime::createFromFormat('Y-m-d', $tgl);

        $dokter  =  DB::table("kmu_us_docter_schedule_time")->
                    leftJoin('kmu_us_docter_schedule_day','kmu_us_docter_schedule_time.code_us_docter_schedule_day', '=', 'kmu_us_docter_schedule_day.code_us_docter_schedule_day')
                    ->where("code_docter",$id)
                    //->where("day", strtoupper($datetime->format('D')))
                    ->where("kmu_us_docter_schedule_time.state","Y")
                    //->whereRaw("CURRENT_TIME <= time_end")
                    ->pluck("code_us_docter_schedule_time", DB::raw("CONCAT(time_start, ' - ', time_end) AS waktu"));
        return json_encode($dokter);
    }

    public function servicePrice($module, $code, $disabled = false){

        $service = M_Service::where("kmu_ms_service.state", "Y")->where("service_category", $module)->orderBy("service_subcategory", "ASC")->orderBy("service_name", "ASC");

        $service = $service->
        
        leftJoin('kmu_ps_income_service as a', function($join)use($code)
        {
            $join->on('kmu_ms_service.code_service', '=', 'a.code_service');
            $join->where('a.state', '=', 'Y');
            $join->where('a.code_action', '=', $code);
        });
        
        if(substr($code, 0, 3) == 'QVN'){
            $service->
            leftJoin('kmu_ps_visus as b', function($join)
            {
                $join->on('b.code_queue_visus_normal', '=', 'a.code_action');
                $join->where('b.state', '=', 'Y');
            });
        }elseif(substr($code, 0, 3) == 'QVG'){
            $service->
            leftJoin('kmu_ps_afct_glasses as b', function($join)
            {
                $join->on('b.code_queue_visus_glasses', '=', 'a.code_action');
                $join->where('b.state', '=', 'Y');
            });
        }elseif(substr($code, 0, 3) == 'QDR'){
            $service->
            leftJoin('kmu_ps_consult as b', function($join)
            {
                $join->on('b.code_queue_docter', '=', 'a.code_action');
                $join->where('b.state', '=', 'Y');
            });
        }elseif(substr($code, 0, 3) == 'CON'){
            $service->
            leftJoin('kmu_ps_afct_reqlab as b', function($join)
            {
                $join->on('b.code_consult', '=', 'a.code_action');
                $join->where('b.state', '=', 'Y');
            });
        }elseif(substr($code, 0, 3) == 'OAG'){
            $service->
            leftJoin('kmu_ps_afct_operation as b', function($join)
            {
                $join->on('b.code_operation_agreement', '=', 'a.code_action');
                $join->where('b.state', '=', 'Y');
            });
        }

        $service = $service->select('service_subcategory', 'code_ps_income_service', 'kmu_ms_service.code_service', 'service_name', 'price', 'is_multiple', 'quantity', 'is_billed');
        $option = "";

        $option .= '<div  style="height:100%;overflow:auto;">
        <table class="table table-condensed">
        <tbody>';

        $category = "";
        foreach($service->get() as $data){
 
            if($category != $data->service_subcategory){
                $option .= '
                <tr style="background-color:#9bef9b">
                    <th colspan = 4 >'.$data->service_subcategory.'</th>
                </tr>';
            }
            $code_ps_income_service = $data->code_ps_income_service? ' checked ' : '';

            $free = $data->is_billed == 'N'? ' checked ' : '';
            
            $option .= '
            <tr>
                <td>
                    <input '.$disabled.' type="checkbox" '.$code_ps_income_service.' id="checkprice-'.$data->code_service.'" name="checkprice['.$data->code_service.']" value="'.$data->code_service.'" class="filled-in getcheckedserv"  />
                    <label  for="checkprice-'.$data->code_service.'"></label>
                </td>
                <td style="max-width:100%;width:290px"><label  for="check-'.$data->code_service.'" style="cursor:pointer">'.$data->service_name.'</label></td>
                <td style="width:100px">Rp. '.number_format($data->price,0,',','.').',-</td>
                <td>';
                
            if($data->is_multiple == 'Y'){
                $option .= '<input '.$disabled.' value="'.$data->quantity.'" type="number" class="qtyprice" style="width:60px" id="qtyprice-'.$data->code_service.'" name="qtyprice['.$data->code_service.']" />';
            }
            
            $option .= '</td>
            </tr>';
            $category = $data->service_subcategory;
        }
        $option .= "
                </tbody>
            </table>
            </div>";

            if($disabled == false){
                $option .= "
                <div style='padding:7px' class='col-sm-12'>
                    <div class='col-sm-4' style='margin-top:10px'>
                        <input ".$disabled." type='checkbox' ".$free." id='free-service' name='free-service' value='Y' class='filled-in' />
                        <label for='free-service'>Free Service</label>
                    </div>
                    <div class='col-sm-6'>
                        <button class='pull-right btn btn-sm btn-success col-sm-12 waves-effect' id='save-price' style='margin-top:5px;margin-bottom:8px'>Simpan</button>
                    </div>
                    <div class='col-sm-2' data-toggle='tooltip' class='form-entry-med-tot' data-placement='top' title='Hapus Jasa & Pembayaran'>
                        <button class='pull-right btn btn-sm btn-danger col-sm-8 waves-effect' id='delete-price' style='margin-top:5px;margin-bottom:8px'>X</button>
                    </div>
                </div>";
            }else{
                $option .= "
                <div style='padding:7px' class='col-sm-12'>
                    <div class='col-sm-4' style='margin-top:10px'>
                        <input ".$disabled." type='checkbox' ".$free." id='free-service' name='free-service' value='Y' class='filled-in' />
                        <label for='free-service'>Free Service</label>
                    </div>";
            }

        return $option;
    }



    public function delete_service_price(){
        if(app('request')->exists('cd')){
            
            $cd = Input::get('cd');
            M_Income_Service::where('code_action', $cd)->where('state', 'Y')->update(['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => auth()->user()->code_user, 'state' => 'N' ]);

            $data1 = 1;
            $data2 = 'Berhasil! Pembayaran telah berhasil dihapus.';

            return json_encode(array($data1, $data2, 0));

        }else{

            $data1 = 0;
            $data2 = 'Gagal! Data gagal dihapus.';

            return json_encode(array($data1, $data2, 0));
        }
    }

    public function store_service_price(){

        if(app('request')->exists('cd') AND app('request')->exists('values') AND app('request')->exists('type')){
            $cd = Input::get('cd');
            $values = Input::get('values');
            $type = Input::get('type');
            $free = Input::get('free')? 'N' : 'Y';

            $patient = M_Booking::where("state", "Y");

            $cd_bkp = $cd;

            if(substr($cd_bkp, 0, 3) == 'QVN'){
    
                $getRes = M_Visus::where("state", "Y")->where("code_queue_visus_normal", $cd_bkp);

                if($getRes->count()){
                    M_Visus::where('code_queue_visus_normal', $cd_bkp)->where('state', 'Y')->update(['is_billed' => $free]);
                }else{

                    $code   = get_prefix('ps_visus'); 

                    $CNew                                = new M_Visus();
                    $CNew->code_visus                    = $code;
                    $CNew->code_queue_visus_normal       = $cd_bkp;
                    $CNew->is_billed                     = $free;
                    $CNew->created_by                    = auth()->user()->code_user;
    
                    $CNew->save();

                }

                $patient->whereHas('toQueueVisus', 
                    function ($q) use($cd_bkp) {
                        $q->where('code_queue_visus_normal', $cd_bkp);
                    });
    
            }elseif(substr($cd_bkp, 0, 3) == 'QVG'){
    
    
                $getRes = M_Visus_Kacamata::where("state", "Y")->where("code_queue_visus_glasses", $cd_bkp);

                if($getRes->count()){
                    M_Visus_Kacamata::where('code_queue_visus_glasses', $cd_bkp)->where('state', 'Y')->update(['is_billed' => $free]);
                }else{

                    $code   = get_prefix('ps_afct_glasses'); 

                    $CNew                                = new M_Visus_Kacamata();
                    $CNew->code_afct_glasses             = $code;
                    $CNew->code_queue_visus_glasses      = $cd_bkp;
                    $CNew->is_billed                     = $free;
                    $CNew->created_by                    = auth()->user()->code_user;
    
                    $CNew->save();

                }

                $patient->whereHas('toQueueGlasses', 
                    function ($q) use($cd_bkp) {
                        $q->where('code_queue_visus_glasses', $cd_bkp);
                    });
                    
            }elseif(substr($cd_bkp, 0, 3) == 'QDR'){
    
                $getRes = M_Consult::where("state", "Y")->where("code_queue_docter", $cd_bkp);

                if($getRes->count()){

                    M_Consult::where('code_queue_docter', $cd_bkp)->where('state', 'Y')->update(['is_billed' => $free]);

                }else{

                    $code   = get_prefix('ps_consult'); 

                    $CNew                                = new M_Consult();
                    $CNew->code_consult                  = $code;
                    $CNew->code_queue_docter             = $cd_bkp;
                    $CNew->is_billed                     = $free;
                    $CNew->created_by                    = auth()->user()->code_user;
    
                    $CNew->save();

                }

                $patient->whereHas('toQueueVisus', 
                        function ($q) use($cd_bkp) {
                            $q->whereHas('toVisus', 
                                function ($r) use($cd_bkp) {
                                    $r->whereHas('toQueueDokter', 
                                        function ($s) use($cd_bkp) {
                                            $s->where('code_queue_docter', $cd_bkp);
                                        }     
                                    );
                                }     
                            );
                        }
                    );
            }elseif(substr($cd_bkp, 0, 3) == 'CON'){
    
                $getRes = M_Consult_Reqlab::where("state", "Y")->where("code_consult", $cd_bkp);

                if($getRes->count()){

                    M_Consult_Reqlab::where('code_consult', $cd_bkp)->where('state', 'Y')->update(['is_billed' => $free]);

                }else{

                    $code   = get_prefix('ps_afct_reqlab'); 
                    
                    $CNew                                = new M_Consult_Reqlab();
                    $CNew->code_reqlab                   = $code;
                    $CNew->code_consult                  = $cd_bkp;
                    $CNew->is_billed                     = $free;
                    $CNew->created_by                    = auth()->user()->code_user;
    
                    $CNew->save();

                }
                
                $patient->whereHas('toQueueVisus', 
                        function ($q) use($cd_bkp) {
                            $q->whereHas('toVisus', 
                                function ($r) use($cd_bkp) {
                                    $r->whereHas('toQueueDokter', 
                                        function ($s) use($cd_bkp) {
                                            $s->whereHas('toConsult', 
                                                function ($t) use($cd_bkp) {
                                                    $t->where('code_consult', $cd_bkp);
                                                }     
                                            );
                                        }     
                                    );
                                }     
                            );
                        }
                    );
            }elseif(substr($cd_bkp, 0, 3) == 'OAG'){
    
    
                $getRes = M_Consult_Operation::where("state", "Y")->where("code_operation_agreement", $cd_bkp);

                if($getRes->count()){

                    M_Consult_Operation::where('code_operation_agreement', $cd_bkp)->where('state', 'Y')->update(['is_billed' => $free]);

                }else{

                    $code   = get_prefix('ps_afct_reqlab'); 
                    
                    $CNew                                = new M_Consult_Operation();
                    $CNew->code_operation                = $code;
                    $CNew->code_operation_agreement      = $cd_bkp;
                    $CNew->is_billed                     = $free;
                    $CNew->created_by                    = auth()->user()->code_user;
    
                    $CNew->save();

                }
                
                $patient->whereHas('toQueueVisus', 
                        function ($q) use($cd_bkp) {
                            $q->whereHas('toVisus', 
                                function ($r) use($cd_bkp) {
                                    $r->whereHas('toQueueDokter', 
                                        function ($s) use($cd_bkp) {
                                            $s->whereHas('toConsult', 
                                                function ($t) use($cd_bkp) {
                                                    $t->whereHas('toOperationAgreement', 
                                                        function ($u) use($cd_bkp) {
                                                            $u->where('code_operation_agreement', $cd_bkp);
                                                        }     
                                                    );
                                                }     
                                            );
                                        }     
                                    );
                                }     
                            );
                        }
                    );
            }else{
    
                $patient->whereHas('toPatient', 
                    function ($q) use($cd_bkp) {
                        $q->where('id_rekam_medis', $cd_bkp);
                    }
                );
            }
            
            M_Income_Service::where('code_action', $cd)->where('state', 'Y')->update(['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => auth()->user()->code_user, 'state' => 'N' ]);

            $count = 0;
            foreach($values as $val){


                $code   = get_prefix('ps_service_payment'); 

                $Service_Payment                                = new M_Income_Service();
                $Service_Payment->code_ps_income_service          = $code;
                $Service_Payment->code_service            = $val['cd'];
                $Service_Payment->code_booking                  = $patient->get()->first()->code_booking;
                $Service_Payment->code_action                   = $cd;
                $Service_Payment->quantity                      = isset($val['tot'])? $val['tot'] : 0;
                $Service_Payment->created_by                    = auth()->user()->code_user;

                $Service_Payment->save();
                $count++;
            }

            $data1 = 1;
            $data2 = 'Berhasil! Pembayaran telah berhasil diinput.';
            $data3 = $count;

            return json_encode(array($data1, $data2, $data3));
        }else{

            $data1 = 0;
            $data2 = 'Gagal! Silahkan check minimal 1 harga. Lewati biaya tagihan ini apabila biaya tidak dibebankan kepada pasien.';

            return json_encode(array($data1, $data2, 0));
        }
    }
}
