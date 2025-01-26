<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Income_Medicine;
use App\Models\M_Income_Service;
use App\Models\M_Booking;
use App\Models\M_Consult_Medicine;
use App\Models\M_Master_Medicine;
use App\Models\M_Consult_Medicine_Details;
use App\Models\M_Exclude_Medicine;
use App\Models\M_Exclude_Medicine_Details;
use App\Models\M_Income_Medicine_Exclude;
use App\Models\M_Payment;
use App\Models\M_Payment_Details;
use App\Models\M_Patient;
use Illuminate\Support\Facades\Input;
use DB;
use PDF; 
use Datetime;

class CashierController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        
        $js[] = 'container-pasien';
        $js[] = 'cashier';
        $css[] = 'table-queue';

        $data = [
            'js' => $js,
            'css' => $css,
        ];
        return view('post-login-views.cashier.cashier_view', $data);
    }

    public function index2(){
        return redirect('kasir');
    }

    public function modal_entry($cd){

        if (substr($cd, 0, 3) == 'CON' or $cd == 'new' or substr($cd, 0, 3) == 'XPM'){
            
            $result     = M_Consult_Medicine_Details::leftJoin('kmu_ps_afct_medicine as q', 
                            'kmu_ps_afct_medicine_details.code_afct_medicine',       '=', 'q.code_afct_medicine')  
                            
                            ->leftJoin('kmu_ps_consult as a', 
                            'q.code_consult',       '=', 'a.code_consult')  
                            
                            ->leftJoin('kmu_ps_income_medicine as b', function($join)
                                {
                                    $join->on('kmu_ps_afct_medicine_details.code_afct_medicine_details', '=', 'b.code_afct_medicine_details');
                                    $join->where('b.state', '=', 'Y');
                                }
                            )
                            ->leftJoin('kmu_ms_medicine as c', 
                                'c.code_medicine',        '=', 'kmu_ps_afct_medicine_details.code_medicine')
                            ->leftJoin('kmu_ms_medicine_unit as d', 
                                'd.code_medicine_unit',        '=', 'c.code_medicine_unit')
                            ->leftJoin('kmu_ms_dt_medicine as e', 
                                'e.code_detail_medicine',        '=', 'kmu_ps_afct_medicine_details.code_detail_medicine')
                            ->where("kmu_ps_afct_medicine_details.state", "Y")
                            ->where("a.is_done", "Y")
                            ->where("a.is_medicine", "Y")
                            ->where("q.state", "Y")
                            ->where("q.code_consult", $cd)
                            ->select(
                                'kmu_ps_afct_medicine_details.code_afct_medicine_details',
                                'q.code_afct_medicine',
                                'q.is_paid',
                                'is_taken',
                                'nama_obat',
                                'jumlah',
                                'price',
                                'harga_jual',
                                'satuan',
                                'total',
                                'q.is_billed',
                                'a.is_done',
                                DB::raw('(
                                            (SELECT 
                                                COALESCE(SUM(z.stock), 0) 
                                            FROM 
                                                kmu_ms_medicine_stock z
                                            WHERE 
                                                z.state = \'Y\'
                                            AND
                                                z.code_medicine = kmu_ps_afct_medicine_details.code_medicine)
                                            - 
                                            (SELECT 
                                                COALESCE(SUM(y.total), 0) 
                                            FROM 
                                                kmu_ps_income_medicine y
                                            LEFT JOIN 
                                                kmu_ps_afct_medicine_details q
                                            ON
                                                y.code_afct_medicine_details = q.code_afct_medicine_details
                                            LEFT JOIN
                                                kmu_ps_afct_medicine w
                                            ON
                                                w.code_afct_medicine = q.code_afct_medicine
                                            WHERE 
                                                y.state = \'Y\' 
                                                AND (
                                                        (
                                                                w.is_paid = \'Y\' 
                                                            AND 
                                                                y.created_at < CURRENT_DATE()
                                                        )
                                            OR (
                                                y.created_at = CURRENT_DATE()
                                                )
                                            )
                                            AND  q.code_medicine = kmu_ps_afct_medicine_details.code_medicine)
                                    ) AS stock_sisa'
                                ))->get();
                 
            if( substr($cd, 0, 3) != 'XPM'){
                $result_ex  = M_Consult_Medicine::leftJoin('kmu_ex_ps_medicine as q', 
                                'kmu_ps_afct_medicine.code_ex_ps_medicine',       '=', 'q.code_ex_ps_medicine')  
                            ->leftJoin('kmu_ex_ps_medicine_details as p', 
                                'p.code_ex_ps_medicine',       '=', 'q.code_ex_ps_medicine')
                            ->leftJoin('kmu_ex_ps_income_medicine as r',
                                'r.code_ex_ps_medicine_details', '=', 'p.code_ex_ps_medicine_details')
                            ->leftJoin('kmu_ms_dt_medicine as s',
                                'p.code_detail_medicine', '=', 's.code_detail_medicine')
                            ->leftJoin('kmu_ms_medicine as t',
                                't.code_medicine', '=', 's.code_medicine')
                            ->where('kmu_ps_afct_medicine.state', 'Y')
                            ->where("kmu_ps_afct_medicine.code_consult", $cd)
                            ->where('q.state','Y')         
                            ->where('p.state','Y')         
                            ->where('r.state','Y')
                            ->select(
                                's.code_medicine',
                                'r.total',
                                's.harga_jual',
                                't.nama_obat',
                                'kmu_ps_afct_medicine.is_billed',
                                'kmu_ps_afct_medicine.is_paid',
                                'kmu_ps_afct_medicine.is_taken',
                                DB::raw('(
                                    (SELECT 
                                        COALESCE(SUM(z.stock), 0) 
                                    FROM 
                                        kmu_ms_medicine_stock z
                                    WHERE 
                                        z.state = \'Y\'
                                    AND
                                        z.code_medicine = s.code_medicine)
                                    - 
                                    (SELECT 
                                        COALESCE(SUM(y.total), 0) 
                                    FROM 
                                        kmu_ps_income_medicine y
                                    LEFT JOIN
                                        kmu_ps_afct_medicine_details q
                                    ON
                                        y.code_afct_medicine_details = q.code_afct_medicine_details
                                        
                                    LEFT JOIN
                                        kmu_ps_afct_medicine w
                                    ON
                                        w.code_afct_medicine = q.code_afct_medicine
                                    WHERE 
                                        y.state = \'Y\' 
                                    AND
                                        (
                                            (
                                                w.is_paid = \'Y\' 
                                            AND
                                                y.created_at < CURRENT_DATE()
                                            )    
                                        )
                                        OR
                                        (
                                            (
                                                y.created_at = CURRENT_DATE()
                                            )
                                        )
                                    AND
                                        q.code_medicine = s.code_medicine)
                                ) AS stock_sisa'),
                                'r.price');

                }else{

                    $result_ex  = M_Exclude_Medicine::leftJoin('kmu_ex_ps_medicine_details as p', 
                        'p.code_ex_ps_medicine',       '=', 'kmu_ex_ps_medicine.code_ex_ps_medicine')
                    ->leftJoin('kmu_ex_ps_income_medicine as r',
                        'r.code_ex_ps_medicine_details', '=', 'p.code_ex_ps_medicine_details')
                    ->leftJoin('kmu_ms_dt_medicine as s',
                        'p.code_detail_medicine', '=', 's.code_detail_medicine')
                    ->leftJoin('kmu_ms_medicine as t',
                        't.code_medicine', '=', 's.code_medicine')
                    ->where('kmu_ex_ps_medicine.state', 'Y')
                    ->where("kmu_ex_ps_medicine.code_ex_ps_medicine", $cd)
                    ->where('kmu_ex_ps_medicine.state','Y')         
                    ->where('p.state','Y')         
                    ->where('r.state','Y')
                    ->select(
                        'customer_name',
                        's.code_medicine',
                        'r.total',
                        's.harga_jual',
                        't.nama_obat',
                        'kmu_ex_ps_medicine.is_billed',
                        'kmu_ex_ps_medicine.is_paid',
                        'kmu_ex_ps_medicine.is_taken',
                        DB::raw('(
                            (SELECT 
                                COALESCE(SUM(z.stock), 0) 
                            FROM 
                                kmu_ms_medicine_stock z
                            WHERE 
                                z.state = \'Y\'
                            AND
                                z.code_medicine = s.code_medicine)
                            - 
                            (SELECT 
                                COALESCE(SUM(y.total), 0) 
                            FROM 
                                kmu_ps_income_medicine y
                            LEFT JOIN
                                kmu_ps_afct_medicine_details q
                            ON
                                y.code_afct_medicine_details = q.code_afct_medicine_details
                            LEFT JOIN
                                kmu_ps_afct_medicine w
                            ON
                                w.code_afct_medicine = q.code_afct_medicine
                            WHERE 
                            y.state = \'Y\' 
                        AND (
                                (
                                        w.is_paid = \'Y\' 
                                    AND 
                                        y.created_at < CURRENT_DATE()
                                )
                    OR (
                        y.created_at = CURRENT_DATE()
                        )
                    )
                    AND q.code_medicine = kmu_ms_medicine.code_medicine)
                        ) AS stock_sisa'),
                        'r.price');      
                }   

                $check_income  = M_Consult_Medicine::leftJoin('kmu_ps_afct_medicine_details as q', 
                    'kmu_ps_afct_medicine.code_afct_medicine',       '=', 'q.code_afct_medicine')  
                ->leftJoin('kmu_ps_income_medicine as p', 
                        'p.code_afct_medicine_details',       '=', 'q.code_afct_medicine_details')
                ->where('q.state', 'Y')
                ->where('kmu_ps_afct_medicine.state', 'Y')
                ->where('kmu_ps_afct_medicine.code_consult', $cd)->count();

            $disabled   = (isset($result->first()->is_paid))? ($result->first()->is_paid == 'Y')?  " disabled " : "" : "";
            $taken   = (isset($result->first()->is_taken))? ($result->first()->is_taken == 'Y')?  " disabled " : "" : "";
            $data2      = 'Data Apotek';
            $data3      = 'save-phar';

            $data = [
                'result' => $result,
                'check_income' => $check_income,
                'result_ex' => $result_ex,
                'cd_bkp' => $cd,
                'disabled' => $disabled,
                'taken' => $taken,
            ];

            $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.cashier.cashier_modal_entry', $data) );

            return json_encode(array($data1, $data2, $data3));
        
        }
    }

    public function checkedval($cd, $val){

        if(substr($cd,0,3) == 'DET'){

            $getStock = M_Consult_Medicine_Details::

                        leftJoin('kmu_ms_dt_medicine as a', 
                        'kmu_ps_afct_medicine_details.code_detail_medicine', '=', 'a.code_detail_medicine')->
                        
                        where('code_afct_medicine_details', 'PMD-'.substr($cd,4))->select(
                        
                        'harga_jual',
                        DB::raw('(
                            (SELECT 
                                COALESCE(SUM(z.stock), 0) 
                            FROM 
                                kmu_ms_medicine_stock z
                            WHERE 
                                z.state = \'Y\'
                            AND
                                z.code_medicine = kmu_ps_afct_medicine_details.code_medicine)
                            - 
                            (SELECT 
                                COALESCE(SUM(y.total), 0) 
                            FROM 
                                kmu_ps_income_medicine y
                            LEFT JOIN 
                                kmu_ps_afct_medicine_details q
                            ON
                                y.code_afct_medicine_details = q.code_afct_medicine_details
                            LEFT JOIN
                                kmu_ps_afct_medicine w
                            ON
                                w.code_afct_medicine = q.code_afct_medicine
                            WHERE 
                            y.state = \'Y\' 
                            AND (
                                    (
                                            w.is_paid = \'Y\' 
                                        AND 
                                            y.created_at < CURRENT_DATE()
                                    )
                        OR (
                            y.created_at = CURRENT_DATE()
                            )
                        )
                        AND  y.code_afct_medicine_details = kmu_ps_afct_medicine_details.code_afct_medicine_details)
                        ) AS stock_sisa'
                    ))->first();
                        


        }else{

            $getStock = M_Master_Medicine::

                            leftJoin('kmu_ms_medicine_unit as c', 
                            'kmu_ms_medicine.code_medicine_unit', '=', 'c.code_medicine_unit')->
                            
                            where('kmu_ms_medicine.state', 'Y')->
                            where('c.state', 'Y')->
                            where('kmu_ms_medicine.code_medicine', 'MED-'.substr($cd,4))->

                            select(

                            DB::raw('
                                (SELECT 
                                    COALESCE(p.harga_jual, 0) 
                                FROM 
                                    kmu_ms_dt_medicine p
                                WHERE 
                                    p.id = (SELECT 
                                                MAX(g.id)
                                            FROM 
                                                kmu_ms_dt_medicine g
                                            WHERE 
                                                g.state = \'Y\'
                                            AND
                                                g.code_medicine = kmu_ms_medicine.code_medicine)
                            ) AS harga_jual'),

                            DB::raw('(
                                (SELECT 
                                    COALESCE(SUM(z.stock), 0) 
                                FROM 
                                    kmu_ms_medicine_stock z
                                WHERE 
                                    z.state = \'Y\'
                                AND
                                    z.code_medicine = kmu_ms_medicine.code_medicine)
                                - 
                                (SELECT 
                                    COALESCE(SUM(y.total), 0) 
                                FROM 
                                    kmu_ps_income_medicine y
                                LEFT JOIN
                                    kmu_ps_afct_medicine_details q
                                ON
                                    y.code_afct_medicine_details = q.code_afct_medicine_details
                                LEFT JOIN
                                    kmu_ps_afct_medicine w
                                ON
                                    w.code_afct_medicine = q.code_afct_medicine
                                WHERE 
                                y.state = \'Y\' 
                            AND (
                                    (
                                            w.is_paid = \'Y\' 
                                        AND 
                                            y.created_at < CURRENT_DATE()
                                    )
                        OR (
                            y.created_at = CURRENT_DATE()
                            )
                        )
                        AND q.code_medicine = kmu_ms_medicine.code_medicine)
                        ) AS stock_sisa'
                    ))->first();

        }
            

            $resval = $getStock->stock_sisa >= $val? $val: $getStock->stock_sisa ;

            return json_encode(array($getStock->stock_sisa, number_format($getStock->harga_jual * $resval,0,',','.')));
            
    }


    public function get_table_medicine(){

        $idArray = json_decode(Input::get('except'));
        $idArray = str_replace('button_', 'PMD-', $idArray);

        $row['med']     = M_Master_Medicine::

                        leftJoin('kmu_ms_medicine_unit as c', 
                        'kmu_ms_medicine.code_medicine_unit', '=', 'c.code_medicine_unit')->

                        leftJoin('kmu_ps_afct_medicine_details as d', function($join) use ($idArray)
                        {
                            $join->on('d.code_medicine', '=', 'kmu_ms_medicine.code_medicine');
                            $join->whereIn('d.code_afct_medicine_details', $idArray);
                        })->
                        
                        where('kmu_ms_medicine.state', 'Y')->
                        where('c.state', 'Y')->

                        select(
                        'kmu_ms_medicine.code_medicine',
                        'code_afct_medicine_details',
                        'nama_obat',
                        'satuan',
                        DB::raw('
                            (SELECT 
                                COALESCE(p.harga_jual, 0) 
                            FROM 
                                kmu_ms_dt_medicine p
                            WHERE 
                                p.id = (SELECT 
                                            MAX(g.id)
                                        FROM 
                                            kmu_ms_dt_medicine g
                                        WHERE 
                                            g.state = \'Y\'
                                        AND
                                            g.code_medicine = kmu_ms_medicine.code_medicine)
                           ) AS harga_jual'),

                        DB::raw('(
                            (SELECT 
                                COALESCE(SUM(z.stock), 0) 
                            FROM 
                                kmu_ms_medicine_stock z
                            WHERE 
                                z.state = \'Y\'
                            AND
                                z.code_medicine = kmu_ms_medicine.code_medicine)
                            - 
                            (SELECT 
                                COALESCE(SUM(y.total), 0) 
                            FROM 
                                kmu_ps_income_medicine y
                            LEFT JOIN
                                kmu_ps_afct_medicine_details q
                            ON
                                y.code_afct_medicine_details = q.code_afct_medicine_details
                            LEFT JOIN
                                kmu_ps_afct_medicine w
                            ON
                                w.code_afct_medicine = q.code_afct_medicine
                            WHERE 
                            y.state = \'Y\' 
                        AND (
                                (
                                        w.is_paid = \'Y\' 
                                    AND 
                                        y.created_at < CURRENT_DATE()
                                )
                    OR (
                        y.created_at = CURRENT_DATE()
                        )
                    )
                    AND q.code_medicine = kmu_ms_medicine.code_medicine)
                    ) AS stock_sisa'
                ))->get();

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.cashier.cashier_table_medicine', $row ));
        
        $data2      = 'Data Harga Obat';
        $data3      = 'save';

        return json_encode(array($data1, $data2, $data3));

    }


    public function get_new_med($cd){

        $cd = str_replace("_","-", $cd);

        $data['data'] =       M_Master_Medicine::

                        leftJoin('kmu_ms_medicine_unit as c', 
                        'kmu_ms_medicine.code_medicine_unit', '=', 'c.code_medicine_unit')->
                        
                        where('kmu_ms_medicine.state', 'Y')->
                        where('c.state', 'Y')->
                        where('kmu_ms_medicine.code_medicine', $cd)->

                        select(
                        'code_medicine',
                        'nama_obat',
                        'satuan',
                        DB::raw('
                            (SELECT 
                                COALESCE(p.harga_jual, 0) 
                            FROM 
                                kmu_ms_dt_medicine p
                            WHERE 
                                p.id = (SELECT 
                                            MAX(g.id)
                                        FROM 
                                            kmu_ms_dt_medicine g
                                        WHERE 
                                            g.state = \'Y\'
                                        AND
                                            g.code_medicine = kmu_ms_medicine.code_medicine)
                           ) AS harga_jual'),

                        DB::raw('(
                            (SELECT 
                                COALESCE(SUM(z.stock), 0) 
                            FROM 
                                kmu_ms_medicine_stock z
                            WHERE 
                                z.state = \'Y\'
                            AND
                                z.code_medicine = kmu_ms_medicine.code_medicine)
                            - 
                            (SELECT 
                                COALESCE(SUM(y.total), 0) 
                            FROM 
                                kmu_ps_income_medicine y
                            LEFT JOIN
                                kmu_ps_afct_medicine_details q
                            ON
                                y.code_afct_medicine_details = q.code_afct_medicine_details
                            LEFT JOIN
                                kmu_ps_afct_medicine w
                            ON
                                w.code_afct_medicine = q.code_afct_medicine
                            WHERE 
                                    y.state = \'Y\' 
                                AND (
                                        (
                                                w.is_paid = \'Y\' 
                                            AND 
                                                y.created_at < CURRENT_DATE()
                                        )
                            OR (
                                y.created_at = CURRENT_DATE()
                                )
                            )
                            AND q.code_medicine = kmu_ms_medicine.code_medicine)
                    ) AS stock_sisa'
                ))->first();

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.cashier.cashier_new_medicine', $data ));

        return json_encode(array($data1));


    }

    public function paid_check($cd){

        if(substr($cd, 0, 3) == 'CON'){
            $get = M_Consult_Medicine::
                        where('state', 'Y')->
                        where('code_consult', $cd)->
                    get();
        }elseif(substr($cd, 0, 3) == 'XPM'){
            $get = M_Consult_Medicine::
                    where('state', 'Y')->
                    where('code_consult', $cd)->
                get();
        }

        if($get->count()){
            $ceks = $get->first();

            if($ceks->is_paid == 'Y' and $ceks->is_taken == 'N'){
                $toPaid    = M_Consult_Medicine::where('code_consult', $cd)->where('state', 'Y')->first();

                $toPaid->update([
                    'updated_at'      => date('Y-m-d H:i:s'),
                    'updated_by'      => auth()->user()->code_user,
                    'is_taken'           => 'Y']);

                $data['total'] =  $ceks->count();        
                $data['rows'] = '';  
                $data['state'] = 'Berhasil';     
            }else{
                $data['total'] = 0;
                $data['rows'] = '';         
                $data['state'] = 'Obat Sudah diambil';         
            }
        }else{
            $data['total'] = 0;
            $data['rows'] = '';   
            $data['state'] = 'Hasil obat tidak ditemukan';  
        }

        return json_encode(array($data));


    }

    public function store_data()
    { 
        if (app('request')->exists('cd_afct_con')) {
            if (substr(Input::get('cd_afct_con'), 0, 3) == 'PAM' or substr(Input::get('cd_afct_con'), 0, 3) == 'new') {
                if (substr(Input::get('cd_afct_con'), 0, 3) == 'PAM'){

                    $get_stat = M_Consult_Medicine::where('state', 'Y')->where('code_afct_medicine', Input::get('cd_afct_con'))->first();

                }elseif(substr(Input::get('cd_afct_con'), 0, 3) == 'new'){

                    $get_stat = M_Exclude_Medicine::where('code_ex_ps_medicine', Input::get('cd_afct_con'))->where('state', 'Y');

                }else{
                    $data1 = 0;
                    $data2 = 'Error! Alur tidak mungkin masuk sini.'; 
                    return json_encode(array($data1, $data2));     
                }
            }else{
                $data1 = 0;
                $data2 = 'Error! Data tidak sesuai format.'; 
                return json_encode(array($data1, $data2));           
            }
        }else{
            $data1 = 0;
            $data2 = 'Error! Data tidak lengkap.'; 
            return json_encode(array($data1, $data2));           
        }
        
        if(app('request')->exists('bayar') or app('request')->exists('ambil')){
            if($get_stat->is_paid == 'N' or $get_stat->is_taken == 'N'){
                //APABILA PEMBELIAN OBAT MELALUI JALUR VISUS
                if(app('request')->exists('afct_med') OR (app('request')->exists('ex_med') AND app('request')->exists('cd_afct_con')) ){
                    $ex_med = Input::get('ex_med');
                    $afct_med = Input::get('afct_med');
                    if(Input::get('cd_afct_con') ){
                        //DELETE DATA FIRST
                        if(substr(Input::get('cd_afct_con'), 0, 3) == 'PAM'){
                            //Unactiving docter receipt medicine
                            $deletedRow = M_Income_Medicine::leftJoin('kmu_ps_afct_medicine_details as a', function($join)
                                {
                                    $join->on('kmu_ps_income_medicine.code_afct_medicine_details', '=', 'a.code_afct_medicine_details');
                                }
                            )->where('a.state', 'Y');

                            $deletedRow->where('a.code_afct_medicine', Input::get('cd_afct_con'))->
                                update([
                                    'kmu_ps_income_medicine.state' => 'N', 
                                    'kmu_ps_income_medicine.deleted_at' => date('Y-m-d H:i:s'), 
                                    'kmu_ps_income_medicine.deleted_by' => auth()->user()->code_user]
                                );
                            
                            //Unactiving patient(exclude) income medicine
                            //DELETE OBAT DILUAR RESEP YANG BELUM DI BAYAR
                            $delExMed = M_Income_Medicine_Exclude::
                                leftJoin('kmu_ex_ps_medicine_details as a', function($join)
                                    {
                                        $join->on('kmu_ex_ps_income_medicine.code_ex_ps_medicine_details', '=', 'a.code_ex_ps_medicine_details');
                                        $join->where('a.state', '=', 'Y');
                                    }
                                )->
                                leftJoin('kmu_ex_ps_medicine as b', function($join)
                                    {
                                        $join->on('a.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                        $join->where('a.state', '=', 'Y');
                                    }
                                )->
                                leftJoin('kmu_ps_afct_medicine as c', function($join)
                                    {
                                        $join->on('c.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                        $join->where('c.state', '=', 'Y');
                                    }
                                )->where('kmu_ex_ps_income_medicine.state', 'Y')
                                ->where('c.code_afct_medicine', Input::get('cd_afct_con'));

                            $delExMed->where('c.is_paid', 'N');
                                if($delExMed->count()){
                                    $delExMed->update([
                                        'kmu_ex_ps_income_medicine.state'       => 'N', 
                                        'kmu_ex_ps_income_medicine.deleted_at'  => date('Y-m-d H:i:s'), 
                                        'kmu_ex_ps_income_medicine.deleted_by'  => auth()->user()->code_user
                                    ]);
                                }

                            // $checkExMed = M_Income_Medicine_Exclude::
                            // leftJoin('kmu_ex_ps_medicine_details as a', function($join)
                            //     {
                            //         $join->on('kmu_ex_ps_income_medicine.code_ex_ps_medicine_details', '=', 'a.code_ex_ps_medicine_details');
                            //         $join->where('a.state', '=', 'Y');
                            //     }
                            // )->
                            // leftJoin('kmu_ex_ps_medicine as b', function($join)
                            //     {
                            //         $join->on('a.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                            //         $join->where('a.state', '=', 'Y');
                            //     }
                            // )->
                            // leftJoin('kmu_ps_afct_medicine as c', function($join)
                            //     {
                            //         $join->on('c.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                            //         $join->where('c.state', '=', 'Y');
                            //     }
                            // )->where('kmu_ex_ps_income_medicine.state', 'Y')
                            // ->where('c.code_afct_medicine', Input::get('cd_afct_con'));

                            
                            //Unactiving patient(exclude) details medicine
                            M_Exclude_Medicine_Details::leftJoin('kmu_ex_ps_medicine as z', 
                                'kmu_ex_ps_medicine_details.code_ex_ps_medicine', '=', 'z.code_ex_ps_medicine')
                            ->leftJoin('kmu_ps_afct_medicine as a', 
                                'z.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')
                            ->where('a.code_afct_medicine', Input::get('cd_afct_con'))
                            ->update([
                                'kmu_ex_ps_medicine_details.state' => 'N', 
                                'kmu_ex_ps_medicine_details.deleted_at' =>  date('Y-m-d H:i:s'), 
                                'kmu_ex_ps_medicine_details.deleted_by' => auth()->user()->code_user]
                            );
                            //APABILA TIDAK ADA MEDICINE YANG DI EXCLUDE PADA JALUR VISUS
                            if(!isset($ex_med)){
                               //Unactiving patient(exclude) medicine
                                //MENGHAPUS SEMUA MEDICINE YANG DIEXCLUDE PADA JALUR VISUS
                                M_Exclude_Medicine::leftJoin('kmu_ps_afct_medicine as a', 
                                    'kmu_ex_ps_medicine.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')
                                ->where('a.code_afct_medicine', Input::get('cd_afct_con'))
                                ->update([
                                    'kmu_ex_ps_medicine.state' => 'N', 
                                    'kmu_ex_ps_medicine.deleted_at' =>  date('Y-m-d H:i:s'), 
                                    'kmu_ex_ps_medicine.deleted_by' => auth()->user()->code_user]
                                );        
                                //delete patient(exclude) consult medicine
                                 //MENGHAPUS CODE MEDICINE YANG DIEXCLUDE PADA JALUR VISUS
                                M_Consult_Medicine::where('code_afct_medicine', Input::get('cd_afct_con'))
                                ->update(['code_ex_ps_medicine' => '', 'updated_at' =>  date('Y-m-d H:i:s'), 'updated_by' => auth()->user()->code_user]);
                            }else{
                                //APABILA ADA MEDICINE YANG DIEXCLUDE PADA JALUR VISUS
                                $get_ex_med = M_Exclude_Medicine::leftJoin('kmu_ps_afct_medicine as a', 'a.code_ex_ps_medicine', '=', 'kmu_ex_ps_medicine.code_ex_ps_medicine' )->where('kmu_ex_ps_medicine.state', 'Y')->where('a.code_afct_medicine', Input::get('cd_afct_con'))->select('kmu_ex_ps_medicine.code_ex_ps_medicine')->first();

                                //CEK APAKAH SEBELUMNYA ADA MEDICINE YANG DI EXCLUDE PDA JALUR VISUS
                                if ($get_ex_med) {
                                    //ADA MEDICINE YANG DI EXCLUDE PDA JALUR VISUS
                                    $cd_ex_med                               = $get_ex_med->code_ex_ps_medicine;
                                    M_Exclude_Medicine::where('code_ex_ps_medicine', $cd_ex_med)
                                    ->update(
                                        [
                                            'is_billed' => Input::get('tagihan') == '0'? 'N' : 'Y',
                                            'is_paid' => Input::get('bayar') == '0'? 'N' : 'Y',
                                            'is_taken' => Input::get('ambil') == '0'? 'N' : 'Y',
                                            'updated_at' =>  date('Y-m-d H:i:s'),
                                            'updated_by' => auth()->user()->code_user
                                        ]
                                    );
                                }else{//
                                    //TIDAK ADA MEDICINE YANG DI EXCLUDE PDA JALUR VISUS
                                    $cd_ex_med                               = get_prefix('ex_ps_medicine');
                                    $ex_med                                  = new M_Exclude_Medicine();
                                    $ex_med->code_ex_ps_medicine             = $cd_ex_med;
                                    $ex_med->is_billed                       = Input::get('tagihan') == '0'? 'N' : 'Y';
                                    $ex_med->is_paid                         = Input::get('bayar') == '0'? 'N' : 'Y';
                                    $ex_med->is_taken                        = Input::get('ambil') == '0'? 'N' : 'Y';
                                    $ex_med->created_by                      = auth()->user()->code_user;
                                    $ex_med->save();

                                    $get_ex_med = M_Consult_Medicine::where('state', 'Y')->where('code_afct_medicine', Input::get('cd_afct_con'));
                                    $get_ex_med->update(['code_ex_ps_medicine' => $cd_ex_med, 'updated_at' =>  date('Y-m-d H:i:s'), 'updated_by' => auth()->user()->code_user]);
                                }
                                foreach(Input::get('ex_med') as $data){
        
                                    $datas = DB::select( 
                                        DB::raw("
                                        SELECT 
                                            COALESCE(p.harga_jual, 0) AS harga_jual, code_detail_medicine
                                        FROM 
                                            kmu_ms_dt_medicine p
                                        WHERE 
                                            p.id = (SELECT 
                                                        MAX(g.id)
                                                    FROM 
                                                        kmu_ms_dt_medicine g
                                                    WHERE 
                                                        g.state = 'Y'
                                                    AND
                                                        g.code_medicine = '".str_replace('_', '-', $data['name'])."')
                                        
                                        ")
                                    );

                                    $code_ex_det                                 = get_prefix('ex_ps_medicine_details'); 
                                    $ex_med_det                                  = new M_Exclude_Medicine_Details();
                                    $ex_med_det->code_ex_ps_medicine_details     = $code_ex_det;
                                    $ex_med_det->code_ex_ps_medicine             = $cd_ex_med;
                                    $ex_med_det->code_medicine                   = $data['name'];
                                    $ex_med_det->code_detail_medicine            = $datas[0]->code_detail_medicine;
                                    $ex_med_det->jumlah                          = $data['value'];
                                    $ex_med_det->created_by                      = auth()->user()->code_user;
    
                                    if($ex_med_det->save()){   
                                        $ex_med_income                                  = new M_Income_Medicine_Exclude();
                                        $ex_med_income->code_ex_ps_income_medicine      = get_prefix('ex_ps_medicine_details'); 
                                        $ex_med_income->code_ex_ps_medicine_details     = $code_ex_det;
                                        $ex_med_income->total                           = $data['value'];
                                        $ex_med_income->price                           = $data['value'] * $datas[0]->harga_jual;
                                        $ex_med_income->created_by                    = auth()->user()->code_user;
    
                                        $ex_med_income->save();    
                                    }
                                } 
                            }

                            if (isset($afct_med)) {

                                foreach($afct_med as $data){
                                    
                                    $datas = DB::select( 
                                        DB::raw("
                                        SELECT 
                                            COALESCE(p.harga_jual, 0) AS harga_jual, code_detail_medicine
                                        FROM 
                                            kmu_ms_dt_medicine p
                                        WHERE 
                                            p.id = (SELECT 
                                                    MAX(g.id)
                                                FROM 
                                                    kmu_ms_dt_medicine g
                                                LEFT JOIN 
                                                    kmu_ps_afct_medicine_details h
                                                ON 
                                                    g.`code_detail_medicine` = h.`code_detail_medicine`
                                                WHERE 
                                                    g.state = 'Y'
                                                AND
                                                    h.code_afct_medicine_details  = '".str_replace('_', '-', $data['name'])."')
                                        
                                        ")
                                    );

                                    $med_income                                  = new M_Income_Medicine();
                                    $med_income->code_ps_income_medicine         = get_prefix('ps_income_medicine'); 
                                    $med_income->code_afct_medicine_details      = str_replace('_', '-', $data['name']);
                                    $med_income->total                           = $data['value'];
                                    $med_income->price                           = $data['value'] * $datas[0]->harga_jual;
                                    $med_income->created_by                      = auth()->user()->code_user;

                                    $med_income->save();    
                                    
                                }                            
                            }

                        }elseif(substr(Input::get('cd_afct_con'), 0, 3) == 'XPM'){
                            $delExMed = M_Income_Medicine_Exclude::
                                leftJoin('kmu_ex_ps_medicine_details as a', function($join)
                                    {
                                        $join->on('kmu_ex_ps_income_medicine.code_ex_ps_medicine_details', '=', 'a.code_ex_ps_medicine_details');
                                        $join->where('a.state', '=', 'Y');
                                    }
                                )->
                                leftJoin('kmu_ex_ps_medicine as b', function($join)
                                    {
                                        $join->on('a.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                        $join->where('a.state', '=', 'Y');
                                    }
                                )->where('kmu_ex_ps_income_medicine.state', 'Y')
                                ->where('b.code_ex_ps_medicine', Input::get('cd_afct_con'));
                                $delExMed->where('b.is_paid', 'N');
                                if($delExMed->count()){
                                    $delExMed->update(['kmu_ex_ps_income_medicine.state' => 'N', 'kmu_ex_ps_income_medicine.deleted_at' => date('Y-m-d H:i:s'), 'kmu_ex_ps_income_medicine.deleted_by' => auth()->user()->code_user]);
                                }

                                // $checkExMed = M_Income_Medicine_Exclude::
                                // leftJoin('kmu_ex_ps_medicine_details as a', function($join)
                                //     {
                                //         $join->on('kmu_ex_ps_income_medicine.code_ex_ps_medicine_details', '=', 'a.code_ex_ps_medicine_details');
                                //         $join->where('a.state', '=', 'Y');
                                //     }
                                // )->
                                // leftJoin('kmu_ex_ps_medicine as b', function($join)
                                //     {
                                //         $join->on('a.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                //         $join->where('a.state', '=', 'Y');
                                //     }
                                // )->where('kmu_ex_ps_income_medicine.state', 'Y')
                                // ->where('b.code_ex_ps_medicine', Input::get('cd_afct_con'));

                            
                            M_Exclude_Medicine_Details::leftJoin('kmu_ex_ps_medicine as z', 
                                'kmu_ex_ps_medicine_details.code_ex_ps_medicine', '=' ,'z.code_ex_ps_medicine')
                            ->where('z.code_ex_ps_medicine', Input::get('cd_afct_con'))
                            ->update([
                                'kmu_ex_ps_medicine_details.state' => 'N', 
                                'kmu_ex_ps_medicine_details.updated_at' =>  date('Y-m-d H:i:s'), 
                                'kmu_ex_ps_medicine_details.updated_by' => auth()->user()->code_user]
                            );

                            if(!isset($ex_med)){
                                //Unactiving patient(exclude) medicine
                                M_Exclude_Medicine::leftJoin('kmu_ps_afct_medicine as a', 
                                    'kmu_ex_ps_medicine.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')
                                ->where('a.code_afct_medicine', Input::get('cd_afct_con'))
                                ->update([
                                    'kmu_ex_ps_medicine.state' => 'N', 
                                    'kmu_ex_ps_medicine.deleted_at' =>  date('Y-m-d H:i:s'), 
                                    'kmu_ex_ps_medicine.deleted_by' => auth()->user()->code_user]
                                );        
                            }else{
                                M_Exclude_Medicine::where('state', 'Y')
                                ->where('code_ex_ps_medicine', Input::get('cd_afct_con'))
                                ->update([
                                    'customer_name' => Input::get('cust_name'), 
                                    'is_billed' => Input::get('tagihan') == '0'? 'N' : 'Y', 
                                    'is_paid' => Input::get('bayar') == '0'? 'N' : 'Y', 
                                    'is_taken' => Input::get('ambil') == '0'? 'N' : 'Y', 
                                    'updated_at' =>  date('Y-m-d H:i:s'), 
                                    'updated_by' => auth()->user()->code_user]
                                );

                                foreach(Input::get('ex_med') as $data){
        
                                    $datas = DB::select( 
                                        DB::raw("
                                        SELECT 
                                            COALESCE(p.harga_jual, 0) AS harga_jual, code_detail_medicine
                                        FROM 
                                            kmu_ms_dt_medicine p
                                        WHERE 
                                            p.id = (SELECT 
                                                        MAX(g.id)
                                                    FROM 
                                                        kmu_ms_dt_medicine g
                                                    WHERE 
                                                        g.state = 'Y'
                                                    AND
                                                        g.code_medicine = '".str_replace('_', '-', $data['name'])."')
                                        
                                        ")
                                    );
    
                                    $code_ex_det                                 = get_prefix('ex_ps_medicine_details'); 
                                    $ex_med_det                                  = new M_Exclude_Medicine_Details();
                                    $ex_med_det->code_ex_ps_medicine_details     = $code_ex_det;
                                    $ex_med_det->code_ex_ps_medicine             = Input::get('cd_afct_con');
                                    $ex_med_det->code_medicine                   = $data['name'];
                                    $ex_med_det->code_detail_medicine            = $datas[0]->code_detail_medicine;
                                    $ex_med_det->jumlah                          = $data['value'];
                                    $ex_med_det->created_by                      = auth()->user()->code_user;
    
                                    if($ex_med_det->save()){
                                        $ex_med_income                                  = new M_Income_Medicine_Exclude();
                                        $ex_med_income->code_ex_ps_income_medicine      = get_prefix('ex_ps_medicine_details'); 
                                        $ex_med_income->code_ex_ps_medicine_details     = $code_ex_det;
                                        $ex_med_income->total                           = $data['value'];
                                        $ex_med_income->price                           = $data['value'] * $datas[0]->harga_jual;
                                        $ex_med_income->created_by                    = auth()->user()->code_user;
    
                                        $ex_med_income->save();
                                    }
                                
                                }                                
                            }
                            
                        }

                       

                    }else{

                        // M_Exclude_Medicine::leftJoin('kmu_ps_afct_medicine as a', 'kmu_ex_ps_medicine.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')->where('a.code_afct_medicine', Input::get('cd_afct_con'))->update(['kmu_ex_ps_medicine.state' => 'N', 'kmu_ex_ps_medicine.updated_at' =>  date('Y-m-d H:i:s'), 'kmu_ex_ps_medicine.updated_by' => auth()->user()->code_user]);

                        // M_Exclude_Medicine_Details::leftJoin('kmu_ex_ps_medicine as z', 'kmu_ex_ps_medicine_details.code_ex_ps_medicine', '=' ,'z.code_ex_ps_medicine')->leftJoin('kmu_ps_afct_medicine as a', 'z.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')->where('a.code_afct_medicine', Input::get('cd_afct_con'))->update(['kmu_ex_ps_medicine_details.state' => 'N', 'kmu_ex_ps_medicine_details.updated_at' =>  date('Y-m-d H:i:s'), 'kmu_ex_ps_medicine_details.updated_by' => auth()->user()->code_user]);

                        // M_Consult_Medicine::where('code_afct_medicine', Input::get('cd_afct_con'))->update(['state' => 'N']);
                        
                    }
                    // if (substr(Input::get('cd_afct_con'), 0, 3) == 'PAM') {
                    //     $arraystate = array();
                    //     if(Input::get('ambil') == 'N'){
                    //         if (Input::get('bayar') == 'N') {
                    //             $arraystate['is_billed'] = Input::get('tagihan') == '0'? 'N' : 'Y';
                    //         }
                    //         $arraystate['is_paid'] = Input::get('bayar') == '0'? 'N' : 'Y';
                    //     }
                    //     $arraystate['is_taken'] = Input::get('ambil') == '0'? 'N' : 'Y';
                    //     $arraystate['updated_at'] = date('Y-m-d H:i:s');
                    //     $arraystate['updated_by'] = auth()->user()->code_user;

                    //     $changestate = M_Consult_Medicine::where('state', 'Y')->where('code_afct_medicine', Input::get('cd_afct_con'));

                    //     $changestate->update($arraystate);
                    // }




                        $data1 = 1;
                        $data2 = 'SUKSES! Data berhasil disimpan. Silahkan cek kembali data tersebut pada table.';

                        // if($Medicine->save()){

                    //     $data1 = 1;
                    //     $data2 = 'SUKSES! Data berhasil di'.$tipe.'. Silahkan cek kembali data tersebut pada table.';
                        
                    // }else{

                    //     $data1 = 0;
                    //     $data2 = 'GAGAL! Data gagal di'.$tipe.'. Silahkan periksa kembali inputan anda.';

                    // }

                } else {

                    if(!app('request')->exists('afct_med') AND app('request')->exists('ex_med') AND app('request')->exists('cd_afct_con') ){
                
                        if(Input::get('ex_med') AND Input::get('cd_afct_con') ){
                            //NEW DATA
            
                                // $delExMed = M_Income_Medicine_Exclude::
                                //     leftJoin('kmu_ex_ps_medicine_details as a', function($join)
                                //         {
                                //             $join->on('kmu_ex_ps_income_medicine.code_ex_ps_medicine_details', '=', 'a.code_ex_ps_medicine_details');
                                //             $join->where('a.state', '=', 'Y');
                                //         }
                                //     )->
                                //     leftJoin('kmu_ex_ps_medicine as b', function($join)
                                //         {
                                //             $join->on('a.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                //             $join->where('a.state', '=', 'Y');
                                //         }
                                //     )->
                                //     leftJoin('kmu_ps_afct_medicine as c', function($join)
                                //         {
                                //             $join->on('c.code_ex_ps_medicine', '=', 'b.code_ex_ps_medicine');
                                //             $join->where('c.state', '=', 'Y');
                                //         }
                                //     )->where('kmu_ex_ps_income_medicine.state', 'Y')
                                //     ->where('c.code_afct_medicine', Input::get('cd_afct_con'));
            
                                // $checkExMed = $delExMed;
            
                                // //DELETE OBAT DILUAR RESEP YANG BELUM DI BAYAR
                                // $delExMed->where('is_paid', 'N');
            
                                // if($delExMed->count()){
                                //     $delExMed->update(['kmu_ex_ps_income_medicine.state' => 'N', 'kmu_ex_ps_income_medicine.deleted_at' => date('Y-m-d H:i:s'), 'kmu_ex_ps_income_medicine.deleted_by' => auth()->user()->code_user]);
                                // }
                            
                                // M_Exclude_Medicine_Details::leftJoin('kmu_ex_ps_medicine as z', 
                                //     'kmu_ex_ps_medicine_details.code_ex_ps_medicine', '=' ,'z.code_ex_ps_medicine')
                                // ->leftJoin('kmu_ps_afct_medicine as a', 
                                //     'z.code_ex_ps_medicine', '=' ,'a.code_ex_ps_medicine')
                                // ->where('a.code_afct_medicine', Input::get('cd_afct_con'))
                                // ->update([
                                //     'kmu_ex_ps_medicine_details.state' => 'N', 
                                //     'kmu_ex_ps_medicine_details.updated_at' =>  date('Y-m-d H:i:s'), 
                                //     'kmu_ex_ps_medicine_details.updated_by' => auth()->user()->code_user]
                                // );
            
                            //PENGECEKAN OBAT DILUAR RESEP YANG SUDAH DI BAYAR
            
                            // $checkExMed->where('is_paid', 'Y')->get();
                            // $filterPaid = [];
                            // if($checkExMed->count()){
                            //     foreach($checkExMed as $data){
                            //         $filterPaid[] = $data->code_medicine;
                            //     }
                            // }
            
                            //MENDAPATKAN CODE UNTUK TBL OBAT EXCLUDE ATAU MEMBUAT BARU
            
                            // $get_ex_med = M_Exclude_Medicine::leftJoin('kmu_ps_afct_medicine as a', 'a.code_ex_ps_medicine', '=', 'kmu_ex_ps_medicine.code_ex_ps_medicine' )->where('kmu_ex_ps_medicine.state', 'Y')->where('a.code_afct_medicine', Input::get('cd_afct_con'))->select('kmu_ex_ps_medicine.code_ex_ps_medicine')->first();
            
                            // if($get_ex_med){
                            //     $cd_ex_med = $get_ex_med->code_ex_ps_medicine;
                            // }else{
            
                                $cd_ex_med                               = get_prefix('ex_ps_medicine'); 
                                $ex_med                                  = new M_Exclude_Medicine();
                                $ex_med->code_ex_ps_medicine             = $cd_ex_med;
                                $ex_med->created_by                      = auth()->user()->code_user;
                                $ex_med->save();
            
                                // $get_ex_med = M_Consult_Medicine::where('state', 'Y')->where('code_afct_medicine', Input::get('cd_afct_con'));
                                // $get_ex_med->update(['code_ex_ps_medicine' => $cd_ex_med, 'updated_at' =>  date('Y-m-d H:i:s'), 'updated_by' => auth()->user()->code_user]);
                            // }
            
                            //INPUT KE TABLE EXCLUDE MEDICINE DETAILS DILUAR YANG SUDAH BAYAR
                            foreach(Input::get('ex_med') as $data){
                                
                                if (!in_array(str_replace('_', '-', $data['name']), $filterPaid)){
            
                                    $datas = DB::select( 
                                        DB::raw("
                                        SELECT 
                                            COALESCE(p.harga_jual, 0) AS harga_jual, code_detail_medicine
                                        FROM 
                                            kmu_ms_dt_medicine p
                                        WHERE 
                                            p.id = (SELECT 
                                                        MAX(g.id)
                                                    FROM 
                                                        kmu_ms_dt_medicine g
                                                    WHERE 
                                                        g.state = 'Y'
                                                    AND
                                                        g.code_medicine = '".str_replace('_', '-', $data['name'])."')
                                        
                                        ")
                                    );
            
                                    $code_ex_det                                 = get_prefix('ex_ps_medicine_details'); 
                                    $ex_med_det                                  = new M_Exclude_Medicine_Details();
                                    $ex_med_det->code_ex_ps_medicine_details     = $code_ex_det;
                                    $ex_med_det->code_ex_ps_medicine             = $cd_ex_med;
                                    $ex_med_det->code_medicine                   = $data['name'];
                                    $ex_med_det->code_detail_medicine            = $datas[0]->code_detail_medicine;
                                    $ex_med_det->jumlah                          = $data['value'];
                                    $ex_med_det->created_by                      = auth()->user()->code_user;
            
                                    if($ex_med_det->save()){
                                        $ex_med_income                                  = new M_Income_Medicine_Exclude();
                                        $ex_med_income->code_ex_ps_income_medicine      = get_prefix('ex_ps_medicine_details'); 
                                        $ex_med_income->code_ex_ps_medicine_details     = $code_ex_det;
                                        $ex_med_income->total                           = $data['value'];
                                        $ex_med_income->price                           = $data['value'] * $datas[0]->harga_jual;
                                        $ex_med_income->created_by                    = auth()->user()->code_user;
            
                                        $ex_med_income->save();
                                    }
                                }
                            }
            
                        }
                    }else{
            
                        $data1 = 0;
                        $data2 = 'Gagal! Anda tidak mengisi data obat. Silahkan cek kembali inputan anda.';
        
                    }
                }
            }else{
                $data1 = 0;
                $data2 = 'Gagal! Obat sudah dibayar/ambil, data tidak dapat diubah.';
            }

            $arrayStateEx = 
            [
                'updated_at' =>  date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->code_user
            ];

            if($get_stat->is_paid == 'Y' or $get_stat->is_taken == 'Y'){
                if($get_stat->is_paid == 'Y'){
                    $arrayStateEx['is_taken'] = Input::get('ambil') == '0'? 'N' : 'Y';
                }elseif($get_stat->is_taken == 'Y'){
                    $data1 = 0;
                    $data2 = 'Gagal! obat sudah diambil.';
                }
            }else{ 
                $arrayStateEx['is_billed']  = Input::get('tagihan') == '0'? 'N' : 'Y';
                $arrayStateEx['is_paid']    = Input::get('bayar') == '0'? 'N' : 'Y';
                $arrayStateEx['is_taken']   = Input::get('ambil') == '0'? 'N' : 'Y';
            }


            M_Consult_Medicine::where('code_afct_medicine', Input::get('cd_afct_con'))->update($arrayStateEx);

        }else{
            $data1 = 0;
            $data2 = 'Gagal! data pembayaran tidak ditemukan.';
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



    public function modal_invoice(){


        if(app('request')->exists('cd')){
            
            $cd = Input::get('cd');
            
            $check_payment = $this->check_payment($cd);

            $get_ex_med = [];

            if(substr($cd, 0,3) == 'BOK'){

                $result_service = $this->income_service($cd);

                $check_medicine = $this->check_medicine($cd);

                if($check_medicine->count()){

                    $get_normal_med = $this->get_medicine($cd);
                    
                    if($check_medicine->first()->code_ex_ps_medicine){

                        $get_ex_med = $this->get_ex_medicine($check_medicine);
                        
                    }

                }

                $disabled   = "";//(isset($result->first()->is_paid))? ($result->first()->is_paid == 'Y')?  " disabled " : "" : "";
                $taken      = "";//(isset($result->first()->is_taken))? ($result->first()->is_taken == 'Y')?  " disabled " : "" : "";
                $data2      = 'Data Kasir & Apotek';
                $data3      = 'save-phar';

                $data = [
                    'result_service' => $result_service,
                    'get_normal_med' => $get_normal_med,
                    'get_ex_med' => $get_ex_med,
                    'cd_bkp' => $cd,
                    'disabled' => $disabled,
                    'taken' => $taken,
                    'disabled' => $check_payment? $check_payment->count()? ' disabled ' : ' ' : ' ',
                    'check_payment' => $check_payment? $check_payment : false ,
                ];

                $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.cashier.cashier_modal_invoice', $data) );

                return json_encode(array($data1, $data2, $data3));
                
                    
            }else{
                
            }
        }
    }
    
    
    public function print_invoice(){

        $result_service = [];
        $get_normal_med = [];
        $get_ex_med = [];

        if(app('request')->exists('cd')){
            
            $cd = Input::get('cd');
            
            if(substr($cd, 0,3) == 'BOK'){

                $result_service = $this->income_service($cd);

                $customer = M_Patient::leftJoin('kmu_ps_booking as a', 
                'kmu_us_patient.code_patient',       '=', 'a.code_patient')  

                ->leftJoin('kmu_ps_payment as b', 
                'a.code_booking',       '=', 'b.registered_code')  
                
                ->where("a.code_booking", $cd)
                ->where("b.state", "Y")
                ->select(
                    'id_rekam_medis',
                    'a.id',
                    'nama_pasien',
                    'b.payment_no',
                    'b.payment_timestamp',
                    'b.payment_method',
                    'b.payment_received',
                    'a.id')->first();

                $check_medicine = $this->check_medicine($cd);

                if($check_medicine->count()){

                    $get_normal_med = $this->get_medicine($cd);
                    
                    if($check_medicine->first()->code_ex_ps_medicine){

                        $get_ex_med = $this->get_ex_medicine($check_medicine);
                        
                    }

                }

            }else{
                
            }

            $payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $customer->payment_timestamp);

                $disabled   = "";//(isset($result->first()->is_paid))? ($result->first()->is_paid == 'Y')?  " disabled " : "" : "";
                $taken      = "";//(isset($result->first()->is_taken))? ($result->first()->is_taken == 'Y')?  " disabled " : "" : "";   
                $data2      = 'Data Kasir & Apotek';
                $data3      = 'save-phar';

                $data = [
                    'result_service' => $result_service,
                    'get_normal_med' => $get_normal_med,
                    'get_ex_med' => $get_ex_med,
                    'customer' => $customer,
                    'payment_date' => $payment_date,
                ];
            
                 
                $pdf =  PDF::loadView('pdf.invoice', $data);
                 
                // return view('pdf.invoice', $result_service);
                return $pdf->stream();
            
        }
    }

    public function store_pay_bill(){ 

        if( app('request')->exists('payment') AND app('request')->exists('cd') ){

            $check = M_Payment::where('registered_code', Input::post('cd'))->where('state', 'Y');

            if($check->count()){

                $data1 = 0;
                $data2 = 'GAGAL! Data gagal disimpan. Transaksi sudah dibayar.';

            }else{

                foreach(Input::get('payment') as $i => $dat){
                    eval('return $'. str_replace("]", "']", str_replace("[", "['", $dat['name'])) . ' = \''.$dat['value'].'\';');
                }

                $header_code                             = get_prefix('ps_payment');

                $header                                 = new M_Payment();
                $header->code_ps_payment                = $header_code;
                $header->payment_no                     = 'TRX-'.strtoupper(uniqid());
                $header->payment_method                 = $method;
                $header->payment_timestamp              = date('Y-m-d H:i:s');
                $header->registered_code                = Input::post('cd');
                $header->payment_received               = $total;
                $header->created_by                     = auth()->user()->code_user;

                if($header->save()){
                    
                    if(substr($cd, 0,3) == 'BOK'){

                        $result_service = $this->income_service($cd);
                        
                        foreach($result_service as $service){

                            $detail_code                            = get_prefix('ps_payment_details');

                            $detail                                 = new M_Payment_Details();
                            $detail->code_ps_payment_details        = $detail_code;
                            $detail->code_ps_payment                = $header_code;
                            $detail->code_ps_income                 = $service->code_ps_income_service;
                            $detail->payment_type                   = 'SERVICE';
                            $detail->created_by                     = auth()->user()->code_user; 

                            $detail->save();

                            $data1 = 1;
                            $data2 = 'SUKSES! Data berhasil disimpan. Silahkan cek kembali data tersebut pada table.';
                        }

                        $check_medicine = $this->check_medicine($cd);
        
                        if($check_medicine->count()){
        
                            $get_normal_med = $this->get_medicine($cd);
                        
                            foreach($get_normal_med as $med){

                                $detail_code                            = get_prefix('ps_payment_details');
    
                                $detail                                 = new M_Payment_Details();
                                $detail->code_ps_payment_details        = $detail_code;
                                $detail->code_ps_payment                = $header_code;
                                $detail->code_ps_income                 = $med->code_ps_income_medicine;
                                $detail->payment_type                   = 'MEDICINE';
                                $detail->created_by                     = auth()->user()->code_user;    
    
                                $detail->save();

                                $data1 = 1;
                                $data2 = 'SUKSES! Data berhasil disimpan. Silahkan cek kembali data tersebut pada table.';

                            }

                            if($check_medicine->first()->code_ex_ps_medicine){
        
                                $get_ex_med = $this->get_ex_medicine($check_medicine);
                                
                                foreach($get_ex_med as $ex_med){

                                    $detail_code                            = get_prefix('ps_payment_details');
        
                                    $detail                                 = new M_Payment_Details();
                                    $detail->code_ps_payment_details        = $detail_code;
                                    $detail->code_ps_payment                = $header_code;
                                    $detail->code_ps_income                 = $ex_med->code_ex_ps_income_medicine;
                                    $detail->payment_type                   = 'EX-MEDICINE';
                                    $detail->created_by                     = auth()->user()->code_user;    
        
                                    $detail->save();

                                    $data1 = 1;
                                    $data2 = 'SUKSES! Data berhasil disimpan. Silahkan cek kembali data tersebut pada table.';
                                    
                                }

                            }
        
                        }

                    }else{
        
                    }
                }
            }

        } else {

            $data1 = 0;
            $data2 = 'Gagal! Terdapat kesalahan pada inputan. Silahkan cek kembali inputan anda.';

        }

        return json_encode(array($data1, $data2));
    }



    public function check_payment($cd){

        return M_Payment::where('registered_code', $cd)
                ->where('state', 'Y')
                ->select('id', 'payment_received')->first(); 
         
     }


    public function check_medicine($cd){

        return M_Booking::leftJoin('kmu_ps_queue_visus_normal as b', function($join)
             {
                 $join->on('kmu_ps_booking.code_booking', '=', 'b.code_booking');
                 $join->where( 'b.state', 'Y');
             }
         )
 
         ->leftJoin('kmu_ps_visus as c', function($join)
             {
                 $join->on('b.code_queue_visus_normal', '=', 'c.code_queue_visus_normal');
                 $join->where( 'c.state', 'Y');
             }
         )
 
         ->leftJoin('kmu_ps_queue_docter as d', function($join)
             {
                 $join->on('c.code_visus', '=', 'd.code_visus');
                 $join->where( 'd.state', 'Y');
             }
         )
 
         ->leftJoin('kmu_ps_consult as e', function($join)
             {
                 $join->on('d.code_queue_docter', '=', 'e.code_queue_docter');
                 $join->where( 'e.state', 'Y');
             }
         )
 
         ->leftJoin('kmu_ps_afct_medicine as f', function($join)
             {
                 $join->on('f.code_consult', '=', 'e.code_consult');
                 $join->where( 'f.state', 'Y');
             }
         )
         ->where('kmu_ps_booking.code_booking', $cd)
         ->where('kmu_ps_booking.state', 'Y')
         ->select('f.code_ex_ps_medicine');    
         
     }


    public function get_medicine($cd){

        return M_Booking::leftJoin('kmu_ps_queue_visus_normal as b', function($join)
            {
                $join->on('kmu_ps_booking.code_booking', '=', 'b.code_booking');
                $join->where( 'b.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_visus as c', function($join)
            {
                $join->on('b.code_queue_visus_normal', '=', 'c.code_queue_visus_normal');
                $join->where( 'c.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_queue_docter as d', function($join)
            {
                $join->on('c.code_visus', '=', 'd.code_visus');
                $join->where( 'd.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_consult as e', function($join)
            {
                $join->on('d.code_queue_docter', '=', 'e.code_queue_docter');
                $join->where( 'e.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_afct_medicine as f', function($join)
            {
                $join->on('f.code_consult', '=', 'e.code_consult');
                $join->where( 'f.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_afct_medicine_details as g', function($join)
            {
                $join->on('f.code_afct_medicine', '=', 'g.code_afct_medicine');
                $join->where( 'g.state', 'Y');
            }
        )

        ->leftJoin('kmu_ps_income_medicine as h', function($join)
            {
                $join->on('h.code_afct_medicine_details', '=', 'g.code_afct_medicine_details');
                $join->where( 'h.state', 'Y');
            }
        )
        ->leftJoin('kmu_ms_medicine as l', 
            'g.code_medicine',       '=', 'l.code_medicine')
        ->leftJoin('kmu_ms_medicine_unit as unit', 'l.code_medicine_unit', '=', 'unit.code_medicine_unit')
        ->leftJoin('kmu_ms_dt_medicine as n', 
            'g.code_detail_medicine',       '=', 'n.code_detail_medicine')  
        ->where('kmu_ps_booking.code_booking', $cd)
        ->where('kmu_ps_booking.state', 'Y')
        ->select(   'h.id',
                    'h.code_ps_income_medicine',
                    'f.code_afct_medicine',
                    DB::raw('\'MEDICINE\' as service_category'),
                    DB::raw('\'MEDICINE-PATIENT\' as service_subcategory'),
                    'l.nama_obat',
                    'h.total',
                    'unit.satuan',
                    'n.harga_jual',
                    'h.price',
                    'f.is_done',
                    'f.is_billed'
                )->get(); 
    }

    // public function check_medicine($cd){

    //    return M_Booking::leftJoin('kmu_ps_queue_visus_normal as b', function($join)
    //         {
    //             $join->on('kmu_ps_booking.code_booking', '=', 'b.code_booking');
    //             $join->where( 'b.state', 'Y');
    //         }
    //     )

    //     ->leftJoin('kmu_ps_visus as c', function($join)
    //         {
    //             $join->on('b.code_queue_visus_normal', '=', 'c.code_queue_visus_normal');
    //             $join->where( 'c.state', 'Y');
    //         }
    //     )

    //     ->leftJoin('kmu_ps_queue_docter as d', function($join)
    //         {
    //             $join->on('c.code_visus', '=', 'd.code_visus');
    //             $join->where( 'd.state', 'Y');
    //         }
    //     )

    //     ->leftJoin('kmu_ps_consult as e', function($join)
    //         {
    //             $join->on('d.code_queue_docter', '=', 'e.code_queue_docter');
    //             $join->where( 'e.state', 'Y');
    //         }
    //     )

    //     ->leftJoin('kmu_ps_afct_medicine as f', function($join)
    //         {
    //             $join->on('f.code_consult', '=', 'e.code_consult');
    //             $join->where( 'f.state', 'Y');
    //         }
    //     )
    //     ->where('kmu_ps_booking.code_booking', $cd)
    //     ->where('kmu_ps_booking.state', 'Y')
    //     ->select('f.code_ex_ps_medicine');    

    // }

    public function income_service($cd){ 

        return M_Income_Service::leftJoin('kmu_ms_service as z', 
        'kmu_ps_income_service.code_service',       '=', 'z.code_service')  
        
        ->leftJoin('kmu_ps_booking as b', 
        'kmu_ps_income_service.code_booking',       '=', 'b.code_booking')  
        
        ->leftJoin('kmu_ps_visus as c', function($join)
            {
                $join->on('kmu_ps_income_service.code_action', '=', 'c.code_queue_visus_normal');
                $join->whereRaw( "substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVN'");
                $join->where('c.state', '=', 'Y');
                $join->where('c.is_done', '=', 'Y');
            }
        )
        
        ->leftJoin('kmu_ps_consult as d', function($join)
            {
                $join->on('kmu_ps_income_service.code_action', '=', 'd.code_queue_docter');
                $join->whereRaw( "substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QDR'");
                $join->where('d.state', '=', 'Y');
                $join->where('d.is_done', '=', 'Y');
            }
        )
        
        ->leftJoin('kmu_ps_afct_glasses as e', function($join)
            {
                $join->on('kmu_ps_income_service.code_action', '=', 'e.code_queue_visus_glasses');
                $join->whereRaw("substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVG'");
                $join->where('e.state', '=', 'Y');
                $join->where('e.is_done', '=', 'Y');
            }
        )
        
        ->leftJoin('kmu_ps_afct_reqlab as f', function($join)
            {
                $join->on('kmu_ps_income_service.code_action', '=', 'f.code_consult');
                $join->whereRaw( "substring( kmu_ps_income_service.code_action, 1, 3 ) = 'CON'");
                $join->where('f.state', '=', 'Y');
                $join->where('f.is_done', '=', 'Y');
            }
        )
        
        ->leftJoin('kmu_ps_afct_operation as g', function($join)
            {
                $join->on('kmu_ps_income_service.code_action', '=', 'g.code_operation_agreement');
                $join->whereRaw( "substring( kmu_ps_income_service.code_action, 1, 3 ) = 'OAG'");
                $join->where('g.state', '=', 'Y');
                $join->where('g.is_done', '=', 'Y');
            }
        )
        ->where("kmu_ps_income_service.state", "Y")
        ->where("kmu_ps_income_service.code_booking", $cd)
        ->orderBy('kmu_ps_income_service.id', 'asc')
        ->select(
            'kmu_ps_income_service.id',
            'kmu_ps_income_service.code_action',
            'kmu_ps_income_service.code_ps_income_service',
            'z.service_category',
            'z.service_subcategory',
            'z.service_name',
            'kmu_ps_income_service.quantity',
            'z.price',
            DB::raw(' CASE
                WHEN kmu_ps_income_service.quantity != 0 THEN
                    kmu_ps_income_service.quantity * z.price
                ELSE
                    1 * z.price
                END as total'),
            DB::raw("CASE
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVN' THEN (
                CASE
                    WHEN c.is_done = 'Y' THEN 'SELESAI'
                    else 'BELUM_SELESAI'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QDR' THEN (
                CASE
                    WHEN d.is_done = 'Y' THEN 'SELESAI'
                    else 'BELUM_SELESAI'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVG' THEN (
                CASE
                    WHEN e.is_done = 'Y' THEN 'SELESAI'
                    else 'BELUM_SELESAI'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'CON' THEN (
                CASE
                    WHEN f.is_done = 'Y' THEN 'SELESAI'
                    else 'BELUM_SELESAI'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'OAG' THEN (
                CASE
                    WHEN g.is_done = 'Y' THEN 'SELESAI'
                    else 'BELUM_SELESAI'
                end )
                ELSE 'KODE TIDAK DITEMUKAN'
            END AS status_selesai"),

            DB::raw("CASE
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVN' THEN (
                CASE
                    WHEN c.is_billed = 'Y' THEN 'DITAGIH'
                    else 'GRATIS'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QDR' THEN (
                CASE
                    WHEN d.is_billed = 'Y' THEN 'DITAGIH'
                    else 'GRATIS'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'QVG' THEN (
                CASE
                    WHEN e.is_billed = 'Y' THEN 'DITAGIH'
                    else 'GRATIS'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'CON' THEN (
                CASE
                    WHEN f.is_billed = 'Y' THEN 'DITAGIH'
                    else 'GRATIS'
                end )
                WHEN substring( kmu_ps_income_service.code_action, 1, 3 ) = 'OAG' THEN (
                CASE
                    WHEN g.is_billed = 'Y' THEN 'DITAGIH'
                    else 'GRATIS'
                end )
                ELSE 'KODE TIDAK DITEMUKAN'
            END AS pembayaran"
            
            ))->get();
    }


    
    public function get_ex_medicine($check_medicine){
        return M_Exclude_Medicine::leftJoin('kmu_ex_ps_medicine_details as b', 
                    'kmu_ex_ps_medicine.code_ex_ps_medicine',       '=', 'b.code_ex_ps_medicine')
                ->leftJoin('kmu_ex_ps_income_medicine as c',
                    'b.code_ex_ps_medicine_details', '=', 'c.code_ex_ps_medicine_details')
                ->leftJoin('kmu_ms_medicine as d',
                    DB::raw('replace(b.code_medicine, \'_\', \'-\')'), '=', 'd.code_medicine')
                ->leftJoin('kmu_ms_dt_medicine as e',
                    'b.code_detail_medicine', '=', 'e.code_detail_medicine')
                ->where('kmu_ex_ps_medicine.code_ex_ps_medicine', $check_medicine->first()->code_ex_ps_medicine)
                ->where("kmu_ex_ps_medicine.state", 'Y')
                ->where('b.state','Y')
                ->select(   'kmu_ex_ps_medicine.id',
                            'kmu_ex_ps_medicine.code_ex_ps_medicine',
                            'b.code_ex_ps_medicine_details',
                            DB::raw('\'MEDICINE\' as service_category'),
                            DB::raw('\'MEDICINE-PATIENT-EX\' as service_subcategory'),
                            'd.nama_obat',
                            'c.total',
                            'c.code_ex_ps_income_medicine',
                            'e.harga_jual',
                            'c.price',
                            'kmu_ex_ps_medicine.is_done',
                            'kmu_ex_ps_medicine.is_billed'
                        )->get(); 
    }
}
