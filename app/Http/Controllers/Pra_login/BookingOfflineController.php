<?php

namespace App\Http\Controllers\Pra_login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Snowfire\Beautymail\Beautymail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Models\M_Patient;
use App\Models\M_Queue_Visus;
use App\Models\M_Booking;
use App\Models\M_Code;
use App\Models\M_Kelurahan;
use App\Models\M_Dokter;
use Session;
use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class BookingOfflineController extends Controller
{

    public function index()
    {
        $js[]         = 'booking-offline';
        $data = ['js' => $js];

        return view('pra-login-views.booking-offline', $data);
    }

    public function booking($type_identity, $value, $form=null)
    {
        if($type_identity != '' AND $value != ''){

            $booking = M_Booking::with('toPatient', 'toQueueVisus')->where('booking_tanggal', date('Y-m-d'))->where('state', 'Y')
                ->whereHas('toPatient', 
                    function($query) use($type_identity, $value) {
                        $query->where($type_identity, '=', $value);
                    })
            ->get();

            if($booking->count()){
                //Ada booking

                if($booking->count() == 1){
                    //antrian hanya 1
                    if(!$booking->first()->toQueueVisus){
                        //belum masuk daftar antrian
                        $last_current_queue     = M_Queue_Visus::whereHas('toBooking', 
                                                    function($query){
                                                        $query->whereRaw('DATE(booking_tanggal) = CURRENT_DATE()');
                                                    })->where('state', 'Y')
                                                ->max('queue_no');
                        if(empty($last_current_queue)){
                            $new_queue = 1;
                        }else{
                            $new_queue = $last_current_queue + 1;
                        }

                        $Queue                              = new M_Queue_Visus();
                        $Queue->code_queue_visus_normal     = get_prefix('ps_queue_visus_normal'); 
                        $Queue->code_booking                = $booking->first()->code_booking;
                        $Queue->queue_no                    = $new_queue;
                        $Queue->created_by                  = $_SERVER['REMOTE_ADDR'];

                        if($Queue->save()){
                            $data1 = 2;
                            $data2 = 'Berhasil! Anda masuk ke dalam antrian dengan nomor urut antrian : '.$new_queue;
                        }else{
                            $data1 = 0;
                            $data2 = 'Gagal! Gagal mendaftar antrian.';
                        }


                    }else{
                        //sudah terdaftar antrian
                        if($booking->first()->toQueueVisus->is_called == 'N'){

                                $data1 = 2;
                                $data2 = 'Anda sudah terdaftar dalam antrian dengan nomor urut antrian : ' . $booking->first()->toQueueVisus->queue_no;

                        }else{

                                $data1 = 2;
                                $data2 = 'Anda sudah masuk ke dalam ruangan pemeriksaan dengan nomor urut antrian : ' . $booking->first()->toQueueVisus->queue_no;

                        }
                    }

                }else{
                    //melakukan daftar 2 kali dalam sehari

                    $booking2 = M_Booking::with('toPatient', 'toQueueVisus')->where('booking_tanggal', date('Y-m-d'))->where('state', 'Y') 
                        ->whereHas('toPatient', 
                            function($query) use($type_identity, $value) {
                                $query->where($type_identity, '=', $value);
                            })
                        ->whereHas('toQueueVisus', 
                            function($query) {
                                $query->where('is_called', '=', 'N');
                            })
                    ->order_by('id', 'desc')
                    ->get();

                    if($booking2->count()){
                        //belum masuk daftar antrian

                        $last_current_queue     = M_Queue_Visus::whereHas('toBooking', 
                                                    function($query){
                                                        $query->whereRaw('DATE(booking_tanggal) = CURRENT_DATE()');
                                                    })->where('state', 'Y')
                                                ->max('queue_no');
                        if(empty($last_current_queue)){
                            $new_queue = 1;
                        }else{
                            $new_queue = $last_current_queue + 1;
                        }

                        $Queue                              = new M_Queue_Visus();
                        $Queue->code_queue_visus_normal     = get_prefix('ps_queue_visus_normal'); 
                        $Queue->code_booking                = $booking2->first()->code_booking;
                        $Queue->queue_no                    = $new_queue;
                        $Queue->created_by                  = $_SERVER['REMOTE_ADDR'];

                        if($Queue->save()){
                            $data1 = 2;
                            $data2 = 'Berhasil! Anda masuk ke dalam antrian dengan nomor urut antrian : '.$new_queue;
                        }else{
                            $data1 = 0;
                            $data2 = 'Gagal! Gagal mendaftar antrian.';
                        }
                    }else{
                        
                        //sudah terdaftar antrian
                        if($booking2->first()->toQueueVisus->is_called == 'N'){

                                $data1 = 2;
                                $data2 = 'Anda sudah terdaftar dalam antrian dengan nomor urut antrian : ' . $booking2->first()->toQueueVisus->queue_no;

                        }else{

                                $data1 = 2;
                                $data2 = 'Anda sudah masuk ke dalam ruangan pemeriksaan dengan nomor urut antrian : ' . $booking2->first()->toQueueVisus->queue_no;

                        }

                    }
                }
            }else{
                //Tidak ada booking
                
                $patient = M_Patient::where('state', 'Y')->where($type_identity, '=', $value)->get();

                if($patient->count()){
                    //Tidak ada booking namun terdaftar
                    
                    if($form == 'form'){

                        $provinsi = DB::table("kmu_ms_rg_provinces")->pluck("name","id");
                        $negara = DB::table("kmu_ms_rg_countries")->pluck("name","id");
                        
                        $old = session()->getOldInput();

                        $kabupaten = '';
                        $kecamatan = '';
                        $kelurahan = '';
                        $disabled = ' disabled ';

                        $patient = $patient->first();
                        $alamat = M_Kelurahan::with('toKecamatan')->where('id', $patient->kelurahan_pasien)->get();
                        // $getDokter = M_Dokter::with('toScheduleDay')->whereHas('toScheduleDay', 
                        //     function($query)  {
                        //         $query->where('day', '=', strtoupper(date('D')));
                        //     })
                        // ->get();
                        $getDokter = M_Dokter::with('toScheduleDay')->get();

                        session(['_old_input.booking' => true]);
                        session(['_old_input.nama_pasien' => $patient->nama_pasien]);
                        session(['_old_input.id_rekam_medis' => $patient->id_rekam_medis]);
                        session(['_old_input.jenis_kelamin' => $patient->jenis_kelamin]);
                        session(['_old_input.gol_darah' => $patient->gol_darah]);
                        session(['_old_input.provinsi_pasien' => $patient->provinsi_pasien]);
                        session(['_old_input.provinsi_pasien_name' => $alamat->first()->toKecamatan->toKota->toprovinsi->name]);
                        session(['_old_input.kota_pasien' => $patient->kota_pasien]);
                        session(['_old_input.kota_pasien_name' => $alamat->first()->toKecamatan->toKota->name]);
                        session(['_old_input.alamat' => $patient->alamat]);
                        session(['_old_input.keluhan' => $patient->keluhan]);
                        session(['_old_input.nik' => $patient->nik]);
                        session(['_old_input.tanggal_lahir' => $patient->tanggal_lahir]);
                        session(['_old_input.telepon' => $patient->telepon]);
                        session(['_old_input.kecamatan_pasien' => $patient->kecamatan_pasien]);
                        session(['_old_input.kecamatan_pasien_name' => $alamat->first()->toKecamatan->name]);
                        session(['_old_input.kelurahan_pasien' => $patient->kelurahan_pasien]);
                        session(['_old_input.kelurahan_pasien_name' => $alamat->first()->name]);
                        session(['_old_input.email' => $patient->email]);
                        session(['_old_input.riwayat_penyakit' => $patient->riwayat_penyakit]);
                        session(['_old_input.no_asuransi' => $patient->no_asuransi]);
                        session(['_old_input.nama_wali' => $patient->nama_wali]);
                        session(['_old_input.nomor_telepon_wali' => $patient->nomor_telepon_wali]);
                        session(['_old_input.nama_ibu' => $patient->nama_ibu]);
                        session(['_old_input.email_wali' => $patient->email_wali]);
                        session(['_old_input.hubungan_wali' => $patient->hubungan_wali]);
                        session(['_old_input.no_asuransi' => $patient->no_asuransi]);
                        session(['_old_input.nama_ibu' => $patient->nama_ibu]);

                        $booking_data = M_Booking::with('toPatient')
                                    ->whereHas('toPatient', 
                                        function($query) use($type_identity, $value) {
                                            $query->where($type_identity, '=', $value);
                                        })
                                    ->get();

                        return view('pra-login-views.form-patient', compact('negara', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'disabled', 'booking_data', 'patient', 'getDokter'));

                    }else{

                        $data1 = 9;
                        $data2 = 'Data pasien ditemukan namun belum terdaftar dalam daftar booking. Silahkan melakukan pengisian form booking agar dapat masuk ke dalam antrian pemeriksaan. Form akan muncul dalam beberapa detik';

                    }

                }else{
                    //Tidak ada booking dan tidak terdaftar

                    $data1 = 0;
                    $data2 = 'Data pasien tidak ditemukan! silahkan cek kembali inputan data identitas anda.';

                }
            }

        }else{
            //Tidak ada booking dan tidak terdaftar dan data tidak diinput

            $data1 = 0;
            $data2 = 'Data pasien tidak ditemukan! silahkan cek kembali data identitas anda';
            
        }

        return json_encode(array($data1, $data2));
    }

    public function registration()
    {
        if(session()->get('_old_input.booking')){
            session()->forget('_old_input');
        }

        $provinsi = DB::table("kmu_ms_rg_provinces")->pluck("name","id");
        $negara = DB::table("kmu_ms_rg_countries")->pluck("name","id");
        
        $old = session()->getOldInput();

        $kabupaten = '';
        $kecamatan = '';
        $kelurahan = '';
        $disabled = false;
        
        if(isset($old['provinsi_pasien'])){
            $kabupaten = DB::table("kmu_ms_rg_regencies")->where("province_id", $old['provinsi_pasien'])->pluck("name","id");
        }
        
        if(isset($old['kota_pasien'])){
            $kecamatan = DB::table("kmu_ms_rg_districts")->where("regency_id", $old['kota_pasien'])->pluck("name","id");
        }
        
        if(isset($old['kecamatan_pasien'])){
            $kelurahan = DB::table("kmu_ms_rg_villages")->where("district_id", $old['kecamatan_pasien'])->pluck("name","id");
        }

        return view('pra-login-views.form-patient', compact('negara', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'disabled'));
    }

    public function store(Request $request)
    {

        if($request->type == 'registration'){
            $ident = true;

            $this->validate($request, [
                'nik' => 'nullable|string|unique:kmu_us_patient|max:16',
                'nama_pasien' => 'required|string',
                'gelar' => 'required',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'jenis_kelamin' => 'required|string',
                'gol_darah' => 'nullable|string',
                'alamat' => 'required|string',
                'email' => 'nullable|email|unique:kmu_us_patient',
                'telepon' => 'nullable|string',
                'provinsi_pasien' => 'required|string',
                'kota_pasien' => 'required|string',
                'kecamatan_pasien' => 'required|string',
                'kelurahan_pasien' => 'required|string',
                'riwayat_penyakit' => 'nullable|string',
                'nama_wali' => 'required|string',
                'nomor_telepon_wali' => 'required|string',
                'email_wali' => 'nullable|email|unique:kmu_us_patient',
                'hubungan_wali' => 'required|string',
                'no_asuransi' => 'nullable|string|unique:kmu_us_patient',
                'nama_ibu' => 'required|string',
            ],
                [
                'nik.max' => 'Nomor Identitas Maksimal 16 Digit',
                'nik.unique' => 'Nomor Identitas Sudah Terdaftar',
                'nama_pasien.required' => 'Nama Lengkap Harus Diisi',
                'gelar.required' => 'Gelar Harus Diisi',
                'tanggal_lahir.required' => 'Tanggal Lahir Harus Diisi',
                'jenis_kelamin.required' => 'Jenis Kelamin Harus Diisi',
                'gol_darah.required' => 'Gol Darah Harus Diisi',
                'alamat.required' => 'Alamat Harus Diisi',
                'telepon.required' => 'Telepon Harus Diisi',
                'provinsi_pasien.required' => 'Provinsi Harus Diisi',
                'kota_pasien.required' => 'Kota Harus Diisi',
                'kecamatan_pasien.required' => 'Kecamatan Harus Diisi',
                'kelurahan_pasien.required' => 'Kelurahan Harus Diisi',
                'kodepos.required' => 'Kodepos Harus Diisi',
                'riwayat_penyakit.required' => 'Riwayat Penyakit Harus Diisi',
                'nama_wali.required' => 'Nama Wali Harus Diisi',
                'nomor_telepon_wali.required' => 'Nomor Telepon Wali Harus Diisi',
                'hubungan_wali.required' => 'Hubungan Wali Harus Diisi',
                'nama_ibu.required' => 'Nama Ibu Harus Diisi',
                'no_asuransi.unique' => 'Nomor Asuransi Sudah Terdaftar'
                ]
            );

            if($request->jenis_kelamin == 'L'){
                $id_rekam_medis = DB::select( DB::raw("SELECT MAX(id_rekam_medis) last_id_rekam_medis FROM kmu_us_patient WHERE id_rekam_medis IS NOT NULL AND jenis_kelamin = 'L'"));

                if(empty($id_rekam_medis[0]->last_id_rekam_medis)){
                    $id_rekam_medis = '100001';
                }else{
                        $id_rekam_medis = $id_rekam_medis[0]->last_id_rekam_medis + 1;
                }
            }elseif($request->jenis_kelamin == 'P'){
                $id_rekam_medis = DB::select( DB::raw("SELECT MAX(id_rekam_medis) last_id_rekam_medis FROM kmu_us_patient WHERE id_rekam_medis IS NOT NULL AND jenis_kelamin = 'P'"));

                if(empty($id_rekam_medis[0]->last_id_rekam_medis)){
                    $id_rekam_medis = '500001';
                }else{
                        $id_rekam_medis = $id_rekam_medis[0]->last_id_rekam_medis + 1;
                }
            }

            $prefix_user = M_Code::where('tabletype', 'users')->select('prefix')->get()->first();
            $code_user = $prefix_user->prefix.'-'.strtoupper(uniqid());

            $prefix_patient = M_Code::where('tabletype', 'us_patient')->select('prefix')->get()->first();
            $code_patient = $prefix_patient->prefix.'-'.strtoupper(uniqid());

            //YOU SHOULD FIX THIS CODE LATER
            // if(Input::get('nik') or Input::get('email') or Input::get('no_asuransi')){ 

            //     $check_nik = DB::table('kmu_us_patient')->where('nik', Input::get('nik'))->orWhere('no_asuransi', Input::get('no_asuransi'))->select('nik', 'id_rekam_medis')->get();

            //     if($check_nik->count() == 0){
            //         $info = "Berhasil! Data siap disimpan.";
            //         $ident = true;

            //     }elseif($check_nik->count() >= 1){
            //         $info = "Gagal mendaftar! NIK/email/no asuransi telah terdaftar sebelumnya silahkan lakukan booking tanpa harus mendaftar ulang.";
            //         $ident = false;
            //     }
            // }
        

            if($ident){

                $Patient = $this->passing_to_model($id_rekam_medis, $request, $code_user, $code_patient);

                if($Patient->save()){

                    if(isset($request->email)) {
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.daftarpasienbaru', [
                            'id_rekam_medis'=> $id_rekam_medis, 
                            'nama'=> $request->nama_pasien, 
                            'nik'=> $request->nik, 
                            'email'=>$request->email, 
                            ],   
                            function($message) {
                                $email = Input::get('email');
                                $message
                                ->from('customers@klinikmatautamatangsel.com')
                                ->to($email, 'Admin Klinik Mata Utama!')
                                ->subject('[Pendaftaran Klinik Mata Utama] - ANDA BERHASIL MENDAFTAR');
                            });
                        Session::flash("message","Email Berhasil Dikirim");
                    }

                    // $user = User::create([
                    //     'code_user' => $code_user,
                    //     'email' => $request->email,
                    //     'password' => bcrypt($request->nik)
                    // ]);            

                    // $user->attachRole('8');
                    
                    $info = "Berhasil, anda telah terdaftar.";

                    Session::flash('message', $info);
            
                    return redirect('/booking/id_rekam_medis/'.$id_rekam_medis.'/form');

                }else{

                    $info = "Gagal menyimpan silahkan cek kembali inputan anda. (1)";

                    Session::flash('message', $info);
            
                    return redirect('/registration');
                }           
            }else{
                if(!isset($info)){

                    $info = "Gagal menyimpan silahkan cek kembali inputan anda. (2)";

                }
                Session::flash('message', $info);

                return redirect('/registration');
            }


            return redirect()->action(
                'Pra_login\BookingOfflineController@booking', ['id_rekam_medis', $id_rekam_medis]
            );

        }elseif($request->type == 'booking'){

            $this->validate($request, [
                'booking_dokter' => 'required|string',
                'booking_jam' => 'required|string',
                'code_patient_val' => 'required|string',
                'keluhan' => 'nullable|string',
            ],
                [
                'booking_dokter.required' => 'Dokter harus dipilih',
                'booking_jam.required' => 'Jam dokter harus dipilih',
                'code_patient_val.required' => 'kode pasien tidak boleh kosong',
                ]
            );


            $cd_book = get_prefix('ps_booking');

            $Booking                                = new M_Booking();
            $Booking->code_booking                  = $cd_book;
            $Booking->code_patient                  = $request->code_patient_val;
            $Booking->code_docter                   = $request->booking_dokter;
            $Booking->code_us_docter_booking_time   = $request->booking_jam;
            $Booking->keluhan                       = $request->keluhan;
            $Booking->booking_tanggal               = $request->booking_tanggal;
            $Booking->booking_dari                  = 'ONSITE';
            $Booking->created_by                    = $_SERVER['REMOTE_ADDR'];

            if($Booking->save()){
                
                $last_current_queue     = M_Queue_Visus::whereHas('toBooking', 
                    function($query){
                        $query->whereRaw('DATE(booking_tanggal) = CURRENT_DATE()');
                    })->where('state', 'Y')
                    ->max('queue_no');
                
                    if(empty($last_current_queue)){
                        $new_queue = 1;
                    }else{
                        $new_queue = $last_current_queue + 1;
                    }

                $queue_visus                            = new M_Queue_Visus();
                $queue_visus->code_queue_visus_normal   = get_prefix('ps_queue_visus_normal');
                $queue_visus->code_booking              = $cd_book;
                $queue_visus->queue_no                  = $new_queue;
                $queue_visus->created_by                = $_SERVER['REMOTE_ADDR'];

                if($queue_visus->save()){
                    
                    $info = "Berhasil, anda telah terdaftar dan sudah masuk ke dalam antrian dengan nomor urut: ". $new_queue;

                    Session::flash('message', $info);

                    // PRINT QUEUE
                    //$connector = new FilePrintConnector("/dev/usb/lp1");
                    // $connector = new WindowsPrintConnector("smb://192.168.1.8/tmu220");
                    // $printer = new Printer($connector);
                    // $printer->initialize();

                    // $printer->setJustification(Printer::JUSTIFY_CENTER);
                    // $printer->text("KLINIK MATA UTAMA TANGSEL\n");
                    // $printer->feed(2);
                    // $printer->text($new_queue."\n");
                    // $printer->feed(2);
                    // $printer->text("SIMPAN NOMOR ANTRIAN ANDA\n");
                    // $printer->cut();
                    // $printer->close();

                    return redirect('/');

                }else{

                    $info = "Gagal menyimpan silahkan cek kembali inputan anda.";

                    Session::flash('message', $info);
            
                    return redirect('/booking/id_rekam_medis/'.$id_rekam_medis.'/form');

                }
            }else{

                $info = "Gagal menyimpan silahkan cek kembali inputan anda.";

                Session::flash('message', $info);
        
                return redirect('/booking/id_rekam_medis/'.$id_rekam_medis.'/form');

            }
        }else{
            die('data tidak terdaftar pada sistem.');
        }
    }

    public function passing_to_model($id_rekam_medis, $request, $code_user, $code_patient){

        $Patient = new M_Patient();
        $Patient->id_rekam_medis = $id_rekam_medis;
        if($request->gelar == 'An' and $request->nik == ''){
            $Patient->nik = "CHILD-".strtoupper(uniqid());
        }elseif($request->nik == ''){
            $Patient->nik = "UNDEFINED-".strtoupper(uniqid());
        }else{
            $Patient->nik = $request->nik;
        }
        $Patient->code_patient = $code_patient;
        $Patient->code_user = $code_user;

        $Patient->nama_pasien = $request->nama_pasien;
        $Patient->gelar = $request->gelar;
        $Patient->tanggal_lahir = $request->tanggal_lahir;
        $Patient->jenis_kelamin = $request->jenis_kelamin;
        $Patient->gol_darah = $request->gol_darah;
        $Patient->alamat = $request->alamat;
        $Patient->email = $request->email;
        $Patient->telepon = $request->telepon;

        $Patient->provinsi_pasien = $request->provinsi_pasien;
        $Patient->kota_pasien = $request->kota_pasien;
        $Patient->kecamatan_pasien = $request->kecamatan_pasien;
        $Patient->kelurahan_pasien = $request->kelurahan_pasien;
        $Patient->keluhan = $request->keluhan;
        $Patient->riwayat_penyakit = $request->riwayat_penyakit;

        $Patient->no_asuransi = $request->no_asuransi;
        $Patient->nama_ibu = $request->nama_ibu;
        $Patient->nama_wali = $request->nama_wali;
        $Patient->nomor_telepon_wali = $request->nomor_telepon_wali;
        $Patient->email_wali = $request->email_wali;
        $Patient->hubungan_wali = $request->hubungan_wali;
        

        if ($request->hasFile('gambar_profilpasien')) { // pakai ini jika tidak ingin upload fotonya atau diisi NULL saja field fotonya (syarat field gambar_profilpasien harus null) ini juga digunakan jika pada input filter required dihilangkan
            $extension = $request->file('gambar_profilpasien')->getClientOriginalExtension();
            $namafile = 'foto_profil-'.$Patient->nama_pasien.'.'.$extension;
            $Patient->gambar_profilpasien = $namafile;
            $Patient->update();
            $request->file('gambar_profilpasien')->move('images/profilpasien/', $namafile);
        }

        return $Patient;
    }
}