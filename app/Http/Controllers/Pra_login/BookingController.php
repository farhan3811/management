<?php

namespace App\Http\Controllers\Pra_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use App\Models\M_Patient;
use App\Models\M_Dokter;
use App\Models\M_Dokter_Waktu;
use App\Models\M_Booking;
use App\Models\M_Code;
use App\Models\M_Queue_Visus;

class BookingController extends Controller
{
    //
    public function index()
    {
        if(!Input::get()){

            $poli = DB::table("kmu_ms_poliklinik")->where("state", "Y")->select("code_poliklinik","nama_poliklinik")->get();
            return view('pra-login.booking', compact('poli'));

        }else{
            
            $id_generate_pasien      = Input::get('id_generate_pasien');
            $id_bpjs  		         = Input::get('id_bpjs');

            if(isset($id_generate_pasien) and empty($id_bpjs)){

            //GET VALUE dari GET dan QUERY OBJECT PASIEN
            
                $pasien = M_Patient::where('id_rekam_medis', '=', $id_generate_pasien)->get()->first();
                $dokter = M_Dokter::where('code_docter', Input::get('pilih_dokter'))->get()->first();

                $waktu = M_Dokter_Waktu::where('code_us_docter_schedule_time', Input::get('pilih_waktu'))->get()->first();
                $poliklinikImage = asset('images/foto_poli/'.$dokter->toPoliklinik->gambar_poliklinik);
                $pasienexists = M_Patient::where('id_rekam_medis', $id_generate_pasien)->count();
                

                if($pasienexists==1){
                    $info = "Pasien ditemukan";
                    $tambah = true;
                    
                    // $bookingexist = DB::table('bookingklinik')->where('id_generate_pasien', $id_generate_pasien)->count();
                    
                    // if($bookingstatus == 1) {
                    //     $info = "Anda Sudah Booking Sebelumnya ditempat klinik, Silahkan Menunggu Antrian Panggilan..";
                    //     $tambah = false;

                    // } else if($pasienid == $bookingid) {
                    //     $info = "Anda Hanya Dapat Satu Kali Booking Dalam Satu Hari, Jika Terdapat Kesalahan Input Data Anda Segera Hubungi Bagian Layanan dan Tindakan KMU Klinik !";
                    //     $tambah = false;

                    // } else if($pasienid) {
                    //     $info = "Selamat akun anda tersedia, silahkan klik tombol booking !";
                    //     $tambah = true;
                    // }

                }else{
                    $info="PASIEN TIDAK DITEMUKAN ATAU NO REKAM MEDIS ANDA SALAH";
                    $tambah = false;
                }

                if($tambah) {
                    // $jadwalpraktik = modul_jadwalpraktikdokter::get();
                    // $tindakan = modul_tindakan::get();
                    // $getdatapoliklinik = modul_poliklinik::get();
                    $DateTime = new \DateTime();
                    $datetime = $DateTime::createFromFormat('Y-m-d', Input::get('tanggal_booking'));
                    return view('pra-login.booking-confirm')
                        ->with('datapasien', $pasien)
                        ->with('dokter', $dokter)
                        ->with('waktu', $waktu)
                        ->with('bookingdate', Input::get('tanggal_booking'))
                        ->with('codewaktu',  Input::get('pilih_waktu'))
                        ->with('hari', strtoupper($datetime->format('l')))
                        ->with('poliklinikImage', $poliklinikImage)
                        ->with('info', $info);
                } else {
                    $poli = DB::table("kmu_ms_poliklinik")->where("state", "Y")->select("code_poliklinik","nama_poliklinik")->get();
                    return view('pra-login.booking', compact('poli'))->with('info', $info);
                }
            }        
        }        
    }


    public function store_data()
    {
        if(Input::get('id_generate_pasien_selesai') AND Input::get('pilih_dokter_selesai') AND Input::get('pilih_tanggal_booking_selesai')){

            $prefix_booking     = M_Code::where('tabletype', 'ps_booking')
                                  ->select('prefix')
                                  ->get()
                                  ->first();

            $code_booking = $prefix_booking->prefix.'-'.strtoupper(uniqid());

            $code_pasien    = M_Patient::where('id_rekam_medis', Input::get('id_generate_pasien_selesai'))  
                              ->select('code_patient')
                              ->get()
                              ->first();

            $Booking                                = new M_Booking();
            $Booking->code_booking                  = $code_booking;
            $Booking->code_patient                  = $code_pasien->code_patient;
            $Booking->code_docter                   = Input::get('pilih_dokter_selesai');
            $Booking->code_us_docter_booking_time   = Input::get('code_waktu');
            $Booking->booking_tanggal   = Input::get('pilih_tanggal_booking_selesai');
            $Booking->booking_dari                  = 'ONSITE';
            $Booking->created_by                    = Input::get('id_generate_pasien_selesai');

            if($Booking->save()){

                $prefix_queue     = M_Code::where('tabletype', 'ps_queue_visus_normal')
                                    ->select('prefix')
                                    ->get()
                                    ->first();

                $code_queue = $prefix_queue->prefix.'-'.strtoupper(uniqid());

                $last_current_queue     = M_Queue_Visus::where('state', 'Y')
                                          ->whereRaw ('DATE(created_at) = CURRENT_DATE()')
                                          ->max('queue_no');
                                                
                if(empty($last_current_queue)){
                    $new_queue = 1;
                }else{
                    $new_queue = $last_current_queue + 1;
                }

                $QueueVisus                                = new M_Queue_Visus();
                $QueueVisus->code_queue_visus_normal       = $code_queue;
                $QueueVisus->code_booking                  = $code_booking;
                $QueueVisus->queue_no                      = $new_queue;
                $QueueVisus->created_by                    = auth()->user()->code_user;

                if($QueueVisus->save()){
                    $status = 'sukses';
                }else{
                    $status = 'gagal';
                }

            }else{
                $status = 'gagal';
            }

            return redirect('/');
        }else {
            die('Data salah!');
        }
    }
}
