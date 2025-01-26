<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Routing\Route;

class RouteApiController extends Controller
{
    public function index(){

        $param['order']                 = Input::get('order');
        $param['start']                 = Input::get('start');
        $param['length']                = Input::get('length');
        $param['search']                = Input::get('search');
        $param['additional_filter']     = Input::get('additional_filter');
            
        if(Input::post('source') == 'queue-visus'){

            $rows = app('App\Http\Controllers\Api\ApiVisusController')->getQueueVisus($param);

        }elseif(Input::post('source') == 'queue-kacamata'){

            $rows = app('App\Http\Controllers\Api\ApiVisusController')->getQueueKacamata($param);

        }elseif(Input::post('source') == 'queue-visus-all'){

            $rows = app('App\Http\Controllers\Api\ApiVisusController')->getQueueVisusAll($param);

        }elseif(Input::post('source') == 'queue-dokter'){

            $rows = app('App\Http\Controllers\Api\ApiConsultController')->getQueueConsult($param);

        }elseif(Input::post('source') == 'medicine'){

            $rows = app('App\Http\Controllers\Api\ApiMasterController')->getMedicine($param);

        }elseif(Input::post('source') == 'medicine-stock'){

            $rows = app('App\Http\Controllers\Api\ApiMasterController')->getMedicineStock($param);

        }elseif(Input::post('source') == 'medicine-price'){

            $rows = app('App\Http\Controllers\Api\ApiMasterController')->getMedicinePrice($param);
            
        }elseif(Input::post('source') == 'laboratorium'){

            $rows = app('App\Http\Controllers\Api\ApiMasterController')->getLaboratorium($param);
            
        }elseif(Input::post('source') == 'queue-lab'){

            $rows = app('App\Http\Controllers\Api\ApiLaboratoriumController')->getQueueLab($param);
            
        }elseif(Input::post('source') == 'queue-operation'){

            $rows = app('App\Http\Controllers\Api\ApiOperationController')->getQueueOp($param);
            
        }elseif(Input::post('source') == 'queue-pharmacy'){

            $rows = app('App\Http\Controllers\Api\ApiPharmacyController')->getQueuePharmacy($param);
            
        }elseif(Input::post('source') == 'pharmacy'){

            $rows = app('App\Http\Controllers\Api\ApiPharmacyController')->getPharmacy($param);
            
        }elseif(Input::post('source') == 'cashier-trx'){

            $rows = app('App\Http\Controllers\Api\ApiCashierController')->getCashierTrx($param);
            
        }elseif(Input::post('source') == 'users'){

            $rows = app('App\Http\Controllers\Api\ApiUserController')->getUsers($param);
            
        }elseif(Input::post('source') == 'medical-reports'){

            $rows = app('App\Http\Controllers\Api\ApiMedicalReportsController')->getMedicalReports($param);
            
        }elseif(Input::post('source') == 'price'){

            $rows = app('App\Http\Controllers\Api\ApiServicePriceController')->getAllPrice($param);
            
        }

        $release_ajax = json_encode($rows);
        print_r($release_ajax);
    }
}
