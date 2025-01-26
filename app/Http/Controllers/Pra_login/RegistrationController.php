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
use App\Models\M_Code;
use Session;

class RegistrationController extends Controller
{
    public function registration()
    {
        $provinsi = DB::table("kmu_ms_rg_provinces")->pluck("name","id");
        $negara = DB::table("kmu_ms_rg_countries")->pluck("name","id");

        return view('pra-login-views.registration', compact('negara', 'provinsi'));
    }

    public function store(Request $request)
    {
        //KONDISI UNTUK PENDAFTARAN PASIEN BARU
        $check_nik = DB::table('kmu_us_patient')->where('nik', Input::get('nik'))->select('nik', 'id_rekam_medis')->get();

        $tambah = false;
        $skip   = false;

        //* CEK NIK DATABASE *//
        if(Input::get('nik')){

            if($check_nik->count() == 0){
                $info = "Berhasil! Data siap disimpan.";
                $tambah = true;

            }elseif($check_nik->count() == 1){
                $info = "Berhasil! Anda telah terdaftar sebelumnya, untuk selanjutnya anda bisa memasukkan id rekam medis anda pada halaman booking. Untuk melihat id rekam medis anda silahkan lihat kartu pasien anda atau hubungi bagian layanan Klinik Mata Utama Tangerang Selatan";
                $tambah = true;
                $skip   = true;

            }else{
                $info = "NIK telah terdaftar sebelumnya dan terdapat lebih dari 1. Silahkan hubungi bagian layanan dari Klinik Mata Utama Tangerang Selatan.";
            }
        }else{
            $info = "NIK salah atau tidak dikenali. Silahkan masukan NIK dengan benar.";
        }
        //* !CEK NIK DATABASE! *//
print_r($info);die;
        //* KONDISI PASIEN BARU *//
        if($tambah AND !$skip) {

            //* VALIDASI DATA *//
            $this->validate($request, [
                'nik' => 'required|string|max:16',
                'nama_pasien' => 'required|string',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'jenis_kelamin' => 'required|string',
                'gol_darah' => 'required|string',
                'alamat' => 'required|string',
                'email' => 'required|string',
                'telepon' => 'required|string',
                'provinsi_pasien' => 'required|string',
                'kota_pasien' => 'required|string',
                'kecamatan_pasien' => 'required|string',
                'kelurahan_pasien' => 'required|string',
                'keluhan' => 'required|string',
                'riwayat_penyakit' => 'required|string',
                'nama_wali' => 'required|string',
                'nomor_telepon_wali' => 'required|string',
                'email_wali' => 'required|string',
                'hubungan_wali' => 'required|string',
            ],
                [
                'nik.required' => 'Nik Harus 16 Digit',
                'nama_pasien.required' => 'Nama Pasien Harus Diisi',
                'tanggal_lahir.required' => 'Tanggal Lahir Harus Diisi',
                'jenis_kelamin.required' => 'Jenis Kelamin Harus Diisi',
                'gol_darah.required' => 'Gol Darah Harus Diisi',
                'alamat.required' => 'Alamat Harus Diisi',
                'email.required' => 'Email Harus Diisi',
                'telepon.required' => 'Telepon Harus Diisi',
                'provinsi_pasien.required' => 'Provinsi Harus Diisi',
                'kota_pasien.required' => 'Provinsi Harus Diisi',
                'kecamatan_pasien.required' => 'Kecamatan Harus Diisi',
                'kelurahan_pasien.required' => 'Kelurahan Harus Diisi',
                'kodepos.required' => 'Kodepos Harus Diisi',
                'keluhan.required' => 'Provinsi Harus Diisi',
                'riwayat_penyakit.required' => 'Riwayat Penyakit Harus Diisi',
                'nama_wali.required' => 'Nama Wali Harus Diisi',
                'nomor_telepon_wali.required' => 'Nomor Telepon Wali Harus Diisi',
                'email_wali.required' => 'Email Wali Harus Diisi',
                'hubungan_wali.required' => 'Hubungan Wali Harus Diisi',
                ]
            );
            //* !VALIDASI DATA! *//

            //* GENERATE ID REKAM MEDIS *//
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
            //* !GENERATE ID REKAM MEDIS! *//
            $prefix_user = M_Code::where('tabletype', 'users')->select('prefix')->get()->first();
            $code_user = $prefix_user->prefix.'-'.strtoupper(uniqid());

            //* PASSING TO MODEL *//
            $prefix_patient = M_Code::where('tabletype', 'us_patient')->select('prefix')->get()->first();
            $code_patient = $prefix_patient->prefix.'-'.strtoupper(uniqid());
            $Patient = $this->passing_to_model($id_rekam_medis, $request, $code_user, $code_patient);
            //* !PASSING TO MODEL! *//

            //* PASSING TO EMAIL *//
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
            //* !PASSING TO EMAIL! *//

            Session::flash("message","Email Berhasil Dikirim");

            $user = User::create([
                'code_user' => $code_user,
                'email' => $request->email,
                'password' => bcrypt($request->nik)
            ]);            

            $user->attachRole('8');

            $Patient->save();           

            //* !KONDISI PASIEN SUDAH ADA! *//
        } elseif($tambah AND $skip) {
            Session::flash('Gagal Mendaftar!', $info);
        } else {
            Session::flash('Gagal Mendaftar!', $info);
        }
        
        return redirect('/');
    }

    public function passing_to_model($id_rekam_medis, $request, $code_user, $code_patient){

        $Patient = new M_Patient();
        $Patient->id_rekam_medis = $id_rekam_medis;
        $Patient->nik = $request->nik;
        $Patient->code_patient = $code_patient;
        $Patient->code_user = $code_user;

        $Patient->nama_pasien = $request->nama_pasien;
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
        $Patient->kodepos = $request->alamat;
        $Patient->keluhan = $request->keluhan;
        $Patient->riwayat_penyakit = $request->riwayat_penyakit;

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
