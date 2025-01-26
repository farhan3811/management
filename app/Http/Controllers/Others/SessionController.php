<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Models\M_Patient;
use App\Models\M_Dokter;
use App\Models\M_Admin;
use App\Models\M_Code;
use App\Models\M_Log_Login;


class SessionController extends Controller
{
    public function index(Request $request){

        if(Session::all()){

            $prefix_booking     = M_Code::where('tabletype', 'ms_log_login')
                                  ->select('prefix')
                                  ->get()
                                  ->first();
  
            $code_booking = $prefix_booking->prefix.'-'.strtoupper(uniqid());

            $Log_Login                                = new M_Log_Login();
            $Log_Login->code_ms_log_login             = $code_booking;
            $Log_Login->code_user                     = auth()->user()->code_user;
            $Log_Login->user_agent                    = $request->server('HTTP_USER_AGENT');
            $Log_Login->ip                            = $request->ip();
            $Log_Login->client_ip                     = $request->getClientIp();
            $Log_Login->created_by                    = auth()->user()->code_user;

            $Log_Login->save();

            $auth = \Auth::user()->roles()->get(array('name'))->first()->name;
            
            if($auth == 'docter' or $auth == 'main_docter'){
                $Docter =  M_Dokter::where(
                                'code_user', '=', auth()->user()->code_user
                            )->get()->first();

                session([
                    'nama' => $Docter->nama_dokter,
                ]);
            }else{
                
                $Detail =  M_Admin::where(
                                'code_user', '=', auth()->user()->code_user
                            )->get()->first();
                if(!$Detail){
                    auth()->logout();
                    return redirect('/login');
                }
                session([
                    'nama' => $Detail->nama_admin,
                ]);
            }


            return redirect('/home');
            // print_r(\Auth::user()->roles()->get(array('name'))->first()->name);
        }else{
            return redirect('/');
        }
    }
}
