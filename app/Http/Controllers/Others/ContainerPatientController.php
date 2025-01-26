<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Input;
use DB;
use PDF;
use Illuminate\Routing\Route;
use App\Models\M_Booking;
use App\Models\M_Patient;
use App\Models\M_Log_Login;
use App\Models\M_Visus;
use App\Models\M_Glasses_Header;
use App\Models\M_Glasses_Sider;
use App\Models\M_Visus_Kacamata;
use App\Models\M_Consult;
use App\Models\M_Consult_Medicine;

class ContainerPatientController extends Controller
{
   public function export_pdf($medical_record)
   {
        $patient = M_Patient::where('id_rekam_medis', $medical_record)->first();

        $bookings = M_Booking::with('toQueueVisus.toVisus.toQueueDokter.toConsult.user.docter',
                    'toQueueVisus.toVisus.toQueueDokter.toConsult.toAfctMedicine.toAfctMedicineDetail.toDetailMedicine.toMedicine.toMedicineUnit',
                    'toQueueVisus.toVisus.toQueueDokter.toConsult.toRequestLab.toReqLabDetail.toLab',
                    'toQueueVisus.toVisus.toQueueDokter.toConsult.toOperationAgreement.toOperation',
                    'toQueueGlasses.toVisusGlasses.toVisusGlassesReceipt.toGlassesHeader', 
                    'toQueueGlasses.toVisusGlasses.toVisusGlassesReceipt.toGlassesSider')
                    ->where("state", "Y")
                    ->where("code_patient", $patient->code_patient)
                    ->orderBy("booking_tanggal", "ASC")
                    ->get();

        // return [is_null($bookings[0]['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab'])];
        // return $bookings[0]['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab'];

        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
        ->setPaper('a4', 'landscape')
        ->loadView('pdf.medical-record', compact('patient', 'bookings'));
        
        return $pdf->stream();
   }

   public function container_pasien($cd_bkp){

        $patient = M_Booking::where("state", "Y");

        if(substr($cd_bkp, 0, 3) == 'QVN'){

            $patient->whereHas('toQueueVisus', 
                function ($q) use($cd_bkp) {
                    $q->where('code_queue_visus_normal', $cd_bkp);
                });

        }elseif(substr($cd_bkp, 0, 3) == 'QVG'){

            $patient->whereHas('toQueueGlasses', 
                function ($q) use($cd_bkp) {
                    $q->where('code_queue_visus_glasses', $cd_bkp);
                });
        }elseif(substr($cd_bkp, 0, 3) == 'QDR'){

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

        $booking  = M_Booking::where("state", "Y")
                    ->where("code_patient", $patient->get()->first()->code_patient)
                    ->orderBy("booking_tanggal", "DESC")
                    ->get();

        $data = [
            'booking' => $booking,
        ];

        return view('post-login-views.patient-history.container', $data);
    }




    public function container_pasien_identity($cd_bkp){

        $patient = M_Booking::where("state", "Y");

        if(substr($cd_bkp, 0, 3) == 'QVN'){

            $patient->whereHas('toQueueVisus', 
                function ($q) use($cd_bkp) {
                    $q->where('code_queue_visus_normal', $cd_bkp);
                }
            );

        }elseif(substr($cd_bkp, 0, 3) == 'QVG'){

            $patient->whereHas('toQueueGlasses', 
                function ($q) use($cd_bkp) {
                    $q->where('code_queue_visus_glasses', $cd_bkp);
                }
            );

        }elseif(substr($cd_bkp, 0, 3) == 'QDR'){

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
        }elseif(substr($cd_bkp, 0, 3) == 'PAM'){

            $patient->whereHas('toQueueVisus', 
                    function ($q) use($cd_bkp) {
                        $q->whereHas('toVisus', 
                            function ($r) use($cd_bkp) {
                                $r->whereHas('toQueueDokter', 
                                    function ($s) use($cd_bkp) {
                                        $s->whereHas('toConsult', 
                                            function ($t) use($cd_bkp) {
                                                $t->whereHas('toAfctMedicine', 
                                                    function ($u) use($cd_bkp) {
                                                        $u->where('code_afct_medicine', $cd_bkp);
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

        $patient    = M_Patient::with('toCountries')
                      ->with('toProvinces')
                      ->where("code_patient", $patient->get()->first()->code_patient)
                      ->get();

        $patientlog = M_Log_Login::where("code_user", $patient->first()->code_user)
                      ->max('created_at');


        $data = [
            'patientlog' => $patientlog,
            'patient' => $patient,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_identity', $data) );
        $data2 = $patient[0]->nama_pasien.' - '.$patient[0]->id_rekam_medis;

        return json_encode(array($data1, $data2));
    }



    public function container_detail($cd_bok){
        
        return view('post-login-views.patient-history.container_detail');

    }

    public function container_pasien_booking($cd_bok){

        $booking  = M_Booking::where("code_booking", $cd_bok)
                    ->get();
        $data = [
            'booking' => $booking,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_booking', $data) );

        return json_encode(array($data1));
    }


    public function container_pasien_consult($cd_bok){

        $results  = M_Consult::leftJoin('kmu_ps_queue_docter as n', 
                'kmu_ps_consult.code_queue_docter',       '=', 'n.code_queue_docter')
            ->leftJoin('kmu_ps_visus as o', 
                'o.code_visus',       '=', 'n.code_visus')
            ->leftJoin('kmu_ps_queue_visus_normal as p', 
                'o.code_queue_visus_normal',       '=', 'p.code_queue_visus_normal')
            ->leftJoin('kmu_ps_booking as q', 
                'p.code_booking',       '=', 'q.code_booking')
            ->leftJoin('kmu_us_docter as r', 
                'r.code_docter',       '=', 'kmu_ps_consult.on_behalf_of')
            ->where("q.code_booking", $cd_bok)
            ->select(
                'nama_dokter', 
                'is_glasses', 
                'is_medicine', 
                'is_refer', 
                'is_operation', 
                'desc',
                'kmu_ps_consult.created_at',
                'kmu_ps_consult.updated_at',
                'n.queue_no',
                'n.is_called',
                'n.is_skipped',
                'n.is_canceled',
                'n.created_at as mulai_antri'
            )
            ->get();
        $data = [
            'results' => $results,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_consult', $data) );

        return json_encode(array($data1));
    }


    public function container_pasien_visus($cd_bok){

        $results  = M_Visus::leftJoin('kmu_ps_queue_visus_normal as p', 
        'kmu_ps_visus.code_queue_visus_normal',       '=', 'p.code_queue_visus_normal')->leftJoin('kmu_ps_booking as q', 
        'p.code_booking',       '=', 'q.code_booking')
        ->where("q.code_booking", $cd_bok)
                    ->get();
        $data = [
            'results' => $results,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_visus', $data) );

        return json_encode(array($data1));
    }



    public function container_pasien_glasses($cd_bok){

        $result['glasses']  = M_Visus_Kacamata::leftJoin('kmu_ps_queue_visus_glasses as p', 
        'kmu_ps_afct_glasses.code_queue_visus_glasses',       '=', 'p.code_queue_visus_glasses')->
        leftJoin('kmu_ps_booking as q', 
        'p.code_booking',       '=', 'q.code_booking')
        ->where("q.code_booking", $cd_bok)->where("kmu_ps_afct_glasses.state", "Y");

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

        $data = [
            'result' => $result,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_glasses', $data) );

        return json_encode(array($data1));
    }

    public function container_pasien_medicine($cd_bok){

        $results  = M_Consult_Medicine::leftJoin('kmu_ps_afct_medicine_details as k', function($join)
            {
                $join->on('k.code_afct_medicine', '=', 'kmu_ps_afct_medicine.code_afct_medicine');
                $join->where('k.state', '=', 'Y');
            })
            ->leftJoin('kmu_ps_income_medicine as l', function($join)
            {
                $join->on('l.code_afct_medicine_details', '=', 'k.code_afct_medicine_details');
                $join->where('l.state', '=', 'Y');
            })
            ->leftJoin('kmu_ms_dt_medicine as a', function($join)
            {
                $join->on('k.code_detail_medicine', '=', 'a.code_detail_medicine');
                $join->where('a.state', '=', 'Y');
            })
            ->leftJoin('kmu_ms_medicine as b', function($join)
            {
                $join->on('a.code_medicine', '=', 'b.code_medicine');
                $join->where('b.state', '=', 'Y');
            })
            ->leftJoin('kmu_ms_medicine_unit as c', 
                'c.code_medicine_unit',       '=', 'b.code_medicine_unit')
            ->leftJoin('kmu_ps_consult as m', 
                'kmu_ps_afct_medicine.code_consult',       '=', 'm.code_consult')
            ->leftJoin('kmu_ps_queue_docter as n', 
                'm.code_queue_docter',       '=', 'n.code_queue_docter')
            ->leftJoin('kmu_ps_visus as o', 
                'o.code_visus',       '=', 'n.code_visus')
            ->leftJoin('kmu_ps_queue_visus_normal as p', 
                'o.code_queue_visus_normal',       '=', 'p.code_queue_visus_normal')
            ->leftJoin('kmu_ps_booking as q', 
                'p.code_booking',       '=', 'q.code_booking')
            ->where("q.code_booking", $cd_bok)
            ->select(
                'nama_obat', 
                'satuan', 
                'jumlah as jumlah_dokter', 
                'total as jumlah_pasien', 
                'price as harga_obat_dibayar',
                'l.created_at',
                'l.updated_at',
                'harga_jual',
                'kmu_ps_afct_medicine.is_billed',
                'kmu_ps_afct_medicine.is_paid',
                'kmu_ps_afct_medicine.is_taken'
            )
            ->get();
        $data = [
            'results' => $results,
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.patient-history.container_medicine', $data) );

        return json_encode(array($data1));
    }
    
}
