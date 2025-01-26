<?php

//*  
//* THIS IS RBAC BASED ON MIDDLEWARE 
//* USED ROLE IS ADMIN 
//* THIS SHIT WAS MAKING ME FUCKIN CRAZY 
//*  

use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
Route::get('cobaprint', function() {
    $connector = new FilePrintConnector("/dev/usb/lp0");
    $printer = new Printer($connector);
    $printer->initialize();
    
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("KLINIK MATA UTAMA TANGSEL\n");
    $printer->feed(2);
    $printer->text("20\n");
    $printer->feed(2);
    $printer->text("SIMPAN NOMOR ANTRIAN ANDA\n");
    $printer->cut();
    $printer->close(); 
}); 

//* CREDENTIALS ROUTE 
Auth::routes();
Route::get('session', 'Others\SessionController@index')->name('home');
Route::get('home', 'Post_login\HomeController@index')->name('home');
Route::get('route/api', 'Others\RouteApiController@index');
Route::post('route/api', 'Others\RouteApiController@index');


//*********************************** PRA LOGIN ******************************************//

//* REGISTRATION & BOOKING OFFLINE
Route::get('/', 
    'Pra_login\BookingOfflineController@index');
Route::get('registration', 
    'Pra_login\BookingOfflineController@registration');
Route::post('registration', 
    'Pra_login\BookingOfflineController@store')->name('bookingoffline.store');
Route::get('booking/{type_identity}/{value}/{form}', 
    'Pra_login\BookingOfflineController@booking')->name('bookingoffline.booking');
Route::post('booking/store', 
    'Pra_login\BookingController@store_data');    

//* OTHERS
Route::get('kabupaten/{id}', 
    'Others\AjaxController@kabupaten');
Route::get('kecamatan/{id}', 
    'Others\AjaxController@kecamatan');
Route::get('kelurahan/{id}', 
    'Others\AjaxController@kelurahan');
Route::get('getdokterajax/{id}', 
    'Others\AjaxController@getdokterbyid');
Route::get('getwaktuajax/{id}/{tgl}', 
    'Others\AjaxController@getwaktubyid');

//____________________________________ PRA LOGIN ________________________________________//



//*********************************** POST LOGIN ******************************************//

//* 
//* ADMIN RBAC MIDDLEWARE
//* 

Route::group(['middleware' => ['auth', 'role:pemeriksa']], function () {

});


Route::group(['middleware' => ['auth', 'role:admin']], function () {

//* QUEUE
    Route::put('queue/patient/called', 'Api\ApiQueueController@called');

//* CONTAINER HISTORY PASIEN

    Route::get('container/patient/getcontainerpasien/{cd_bkp}', 
        'Others\ContainerPatientController@container_pasien')->name('container_patient.container_pasien');

    Route::get('container/patient/getcontainerpasienidentity/{cd_bkp}', 
        'Others\ContainerPatientController@container_pasien_identity')->name('container_patient.container_pasien_identity');

    Route::get('container/patient/getcontainerpasienbooking/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_booking')->name('container_patient.container_pasien_booking');

    Route::get('container/patient/getcontainerpasienvisus/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_visus')->name('container_patient.container_pasien_visus');

    Route::get('container/patient/getcontainerpasienconsult/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_consult')->name('container_patient.container_pasien_consult');

    Route::get('container/patient/getcontainerpasienglasses/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_glasses')->name('container_patient.container_pasien_glasses');

    Route::get('container/patient/getcontainerpasienmedicine/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_medicine')->name('container_patient.container_pasien_medicine');

    Route::get('container/patient/getcontainerpasienlab/{cd_bok}', 
        'Others\ContainerPatientController@container_pasien_lab')->name('container_patient.container_pasien_lab');

    Route::get('container/patient/getcontainerpasienoperation/{cd_bok}',    
        'Others\ContainerPatientController@container_pasien_operation')->name('container_patient.container_pasien_operation');

    Route::get('container/patient/getcontainerdetail/{cd_bok}', 
        'Others\ContainerPatientController@container_detail')->name('container_patient.container_detail');

//* VISUS / PEMERIKSAAN

    Route::get('visus/{realtime?}', 
        'Post_login\VisusController@index')->name('visus');

    Route::get('visus/getmodalentry/{cd_bkp}/{bypass?}', 
        'Post_login\VisusController@modal_entry')->name('visus.modal_entry');

    Route::post('visus/store', 
        'Post_login\VisusController@store_data')->name('visus.store_data');

    Route::post('visus/store_kacamata', 
        'Post_login\VisusController@store_kacamata_data')->name('visus.store_kacamata_data');

//* CONSULTATION

    Route::get('konsultasi', 
        'Post_login\ConsultController@index')->name('konsultasi');

    Route::get('konsultasi/getmodalentry/{cd_bkp}', 
        'Post_login\ConsultController@modal_entry')->name('konsultasi.modal_entry');

    Route::post('konsultasi/store', 
        'Post_login\ConsultController@store_data')->name('konsultasi.store_data');

    Route::post('konsultasi/store_operasi', 
        'Post_login\ConsultController@store_operasi')->name('konsultasi.store_operasi');

    Route::post('konsultasi/store_kacamata', 
        'Post_login\ConsultController@store_kacamata_data')->name('konsultasi.store_kacamata_data');

    Route::get('konsultasi/medicine', 
        'Post_login\ConsultController@entry_medicine')->name('konsultasi.entry_medicine');

    Route::get('konsultasi/operation', 
        'Post_login\ConsultController@entry_operation')->name('konsultasi.entry_operation');

    Route::get('konsultasi/operation_step/{cd_bkp}', 
        'Post_login\ConsultController@operation_step')->name('konsultasi.operation_step');

//* MASTER LABORATORIUM

    Route::get('master/lab', 
        'Post_login\LaboratoriumController@index')->name('lab');

    Route::get('master/lab/entry/{cd}/{type}', 
        'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

    Route::post('master/lab/store', 
        'Post_login\LaboratoriumController@store_data')->name('lab.store_data');

    Route::get('master/lab/group', 
        'Post_login\LaboratoriumController@autocomplete');

//* CONSULTATION LABORATORIUM

    Route::get('req_lab', 
        'Post_login\ReqLaboratoriumController@index')->name('req_lab');

    Route::get('req_lab/getmodalentry/{cd_bkp}', 
        'Post_login\ReqLaboratoriumController@modal_entry')->name('req_lab.modal_entry');

    Route::post('req_lab/store', 
        'Post_login\ReqLaboratoriumController@store_data')->name('reqlab.store_data');

    Route::get('master/lab/entry/{cd}/{type}', 
        'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

    Route::post('master/lab/store', 
        'Post_login\LaboratoriumController@store_data')->name('lab.store_data');

//* CONSULTATION OPERATION

    Route::get('operasi', 
        'Post_login\OperationController@index')->name('operasi');

    Route::get('operasi/getmodalentry/{cd_bkp}', 
        'Post_login\OperationController@modal_entry')->name('operasi.modal_entry');

    Route::post('operasi/insert_operation', 
        'Post_login\OperationController@insert_operation')->name('operasi.insert_operation');

    Route::post('operation/store', 
        'Post_login\OperationController@store_data')->name('operasi.store_data');

//* CONSULTATION MEDICINE

    Route::get('kasir', 
        'Post_login\CashierController@index')->name('kasir');

    Route::get('kasir/getmodalentry/{cd_bkp}', 
        'Post_login\CashierController@modal_entry')->name('kasir.modal_entry');

    Route::post('kasir/getmodalinvoice', 
        'Post_login\CashierController@modal_invoice')->name('kasir.modal_invoice');

    Route::post('kasir/invoice', 
        'Post_login\CashierController@print_invoice')->name('kasir.print_invoice');

    Route::get('kasir/invoice', 
        'Post_login\CashierController@index2')->name('kasir');

    Route::get('kasir/getnewmed/{cd_bkp}', 
        'Post_login\CashierController@get_new_med')->name('kasir.get_new_med');

    Route::get('kasir/paidCheck/{cd_bkp}', 
        'Post_login\CashierController@paid_check')->name('kasir.paid_check');

    Route::post('kasir/gettablemedicine', 
        'Post_login\CashierController@get_table_medicine')->name('kasir.get_table_medicine');

    Route::post('kasir/store', 
        'Post_login\CashierController@store_data')->name('kasir.store_data');

    Route::get('kasir/cek_nilai/{cd_det}/{val}', 
        'Post_login\CashierController@checkedval')->name('kasir.checkedval');

    Route::post('kasir/store_pay_now', 
        'Post_login\CashierController@store_pay_bill')->name('kasir.store_pay_now');

    //* MASTER MEDICINE    

    Route::get('report/rekam_medis', 
        'Post_login\ReportsController@medical_reports')->name('reports.medical_records');

//* MASTER MEDICINE    

    Route::get('master/obat', 
        'Post_login\MedicineController@index')->name('obat');

    Route::get('master/obat/entry/{cd}/{type}', 
        'Post_login\MedicineController@modal_entry')->name('obat.entry');

    Route::post('master/obat/store', 
        'Post_login\MedicineController@store_data')->name('obat.store_data');

    Route::get('master/obat/stock/{cd}', 
        'Post_login\MedicineController@modal_stock')->name('obat.stock');

    Route::get('master/obat/price/{cd}', 
        'Post_login\MedicineController@modal_price')->name('obat.price');

    Route::post('master/price/store', 
        'Post_login\MedicineController@store_price')->name('obat.store_price');

    Route::post('master/stock/store', 
        'Post_login\MedicineController@store_stock')->name('obat.store_stock');

    Route::post('master/obat/store', 
        'Post_login\MedicineController@store_data')->name('obat.store_data');

    Route::get('master/obat/stock/{cd}', 
        'Post_login\MedicineController@modal_stock')->name('obat.stock');

    Route::get('master/obat/price/{cd}', 
        'Post_login\MedicineController@modal_price')->name('obat.price');

    Route::post('master/price/store', 
        'Post_login\MedicineController@store_price')->name('obat.store_price');

    Route::post('master/stock/store', 
        'Post_login\MedicineController@store_stock')->name('obat.store_stock');

    Route::get('/admin', function () {
        return view('admin.index');
    });

//* USERS MANAGEMENT

    Route::get('users', 
        'Post_login\User_Management\UserController@index')->name('users');   

    Route::get('users/create/{cd}/{type}', 
        'Post_login\User_Management\UserController@modal_entry')->name('users/create');   

    Route::post('users/save', 
        'Post_login\User_Management\UserController@store')->name('users.store');

    Route::get('roles', 
        'Post_login\User_Management\RoleController@index')->name('roles');  

//* SERVICE PRICE

    Route::get('master/price', 
        'Post_login\ServicePriceController@index')->name('price');

    Route::get('getListPrice/{module}/{cd}/{disabled?}', 
        'Others\AjaxController@servicePrice');

    Route::post('save/service', 
        'Others\AjaxController@store_service_price')->name('service.store_service_price');

    Route::post('delete/service', 
        'Others\AjaxController@delete_service_price')->name('service.delete_service_price');

    Route::get('master/price/entry/{cd}/{type}', 
        'Post_login\ServicePriceController@modal_entry')->name('service.modal_entry');

    Route::post('service/price/store', 
        'Post_login\ServicePriceController@store_data')->name('service.store_data');

// Route::get('master/lab/entry/{cd}/{type}', 
// 'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

// Route::post('master/lab/store', 
// 'Post_login\LaboratoriumController@store_data')->name('lab.store_data');

// Route::get('master/lab/group', 
// 'Post_login\LaboratoriumController@autocomplete');

// Route::get('getListPrice/{module}/{cd}', 
//     'Others\AjaxController@servicePrice');

});




















//***************************************************************************************************/

/* I DONT EVEN KNOW */
Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user', function () {
        return view('user.index');
    });
});