<?php

/* AUTH */
Auth::routes();

/* PRA LOGIN */
Route::get('/oldbooking', 'Pra_login\BookingController@index');
Route::post('booking/store', 'Pra_login\BookingController@store_data');

Route::get('registrationold', 'Pra_login\RegistrationController@registration');
Route::post('registrationold', 'Pra_login\RegistrationController@store')->name('registration.store');



Route::get('/', 'Pra_login\BookingOfflineController@index');

Route::get('registration', 'Pra_login\BookingOfflineController@registration');
Route::post('registration', 'Pra_login\BookingOfflineController@store')->name('bookingoffline.store');

Route::get('booking/{type_identity}/{value}/{form}', 'Pra_login\BookingOfflineController@booking')->name('bookingoffline.booking');

/* POST LOGIN */
Route::get('session', 'Others\SessionController@index')->name('home');
Route::get('home', 'Post_login\HomeController@index')->name('home');

/*API*/
Route::get('route/api', 'Others\RouteApiController@index');
Route::post('route/api', 'Others\RouteApiController@index');
Route::get('api/apszivisus', 'Api\ApiVisusController@getQueaueVisus');

/* OTHERS */
Route::get('kabupaten/{id}', 'Others\AjaxController@kabupaten');
Route::get('kecamatan/{id}', 'Others\AjaxController@kecamatan');
Route::get('kelurahan/{id}', 'Others\AjaxController@kelurahan');
Route::get('getdokterajax/{id}', 'Others\AjaxController@getdokterbyid');
Route::get('getwaktuajax/{id}/{tgl}', 'Others\AjaxController@getwaktubyid');



//-----------------------CONTAINER HISTORY PASIEN------------------------//
Route::get('container/patient/getcontainerpasien/{cd_bkp}', 'Others\ContainerPatientController@container_pasien')->name('container_patient.container_pasien');

Route::get('container/patient/getcontainerpasienidentity/{cd_bkp}', 'Others\ContainerPatientController@container_pasien_identity')->name('container_patient.container_pasien_identity');

Route::get('container/patient/getcontainerpasienbooking/{cd_bok}', 'Others\ContainerPatientController@container_pasien_booking')->name('container_patient.container_pasien_booking');

Route::get('container/patient/getcontainerpasienvisus/{cd_bok}', 'Others\ContainerPatientController@container_pasien_visus')->name('container_patient.container_pasien_visus');
//
Route::get('container/patient/getcontainerpasienconsult/{cd_bok}', 'Others\ContainerPatientController@container_pasien_consult')->name('container_patient.container_pasien_consult');

Route::get('container/patient/getcontainerpasienglasses/{cd_bok}', 'Others\ContainerPatientController@container_pasien_glasses')->name('container_patient.container_pasien_glasses');

Route::get('container/patient/getcontainerpasienmedicine/{cd_bok}', 'Others\ContainerPatientController@container_pasien_medicine')->name('container_patient.container_pasien_medicine');

Route::get('container/patient/getcontainerpasienlab/{cd_bok}', 'Others\ContainerPatientController@container_pasien_lab')->name('container_patient.container_pasien_lab');

Route::get('container/patient/getcontainerpasienoperation/{cd_bok}', 'Others\ContainerPatientController@container_pasien_operation')->name('container_patient.container_pasien_operation');

Route::get('container/patient/getcontainerdetail/{cd_bok}', 'Others\ContainerPatientController@container_detail')->name('container_patient.container_detail');



//----------------------------- VISUS------------------------------------//
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });

});
    
Route::get('visus', ['middleware' => 'role:admin|root'], 'Post_login\VisusController@index')->name('visus');

Route::get('visus/getmodalentry/{cd_bkp}', 'Post_login\VisusController@modal_entry')->name('visus.modal_entry');

Route::post('visus/store', 'Post_login\VisusController@store_data')->name('visus.store_data');

Route::post('visus/store_kacamata', 'Post_login\VisusController@store_kacamata_data')->name('visus.store_kacamata_data');



//--------------------------- KONSULTASI ------------------------------//
Route::get('konsultasi', 'Post_login\ConsultController@index')->name('konsultasi');

Route::get('konsultasi/getmodalentry/{cd_bkp}', 'Post_login\ConsultController@modal_entry')->name('konsultasi.modal_entry');

Route::post('konsultasi/store', 'Post_login\ConsultController@store_data')->name('konsultasi.store_data');

Route::post('konsultasi/store_operasi', 'Post_login\ConsultController@store_operasi')->name('konsultasi.store_operasi');

Route::post('konsultasi/store_kacamata', 'Post_login\ConsultController@store_kacamata_data')->name('konsultasi.store_kacamata_data');

Route::get('konsultasi/medicine', 'Post_login\ConsultController@entry_medicine')->name('konsultasi.entry_medicine');

Route::get('konsultasi/operation', 'Post_login\ConsultController@entry_operation')->name('konsultasi.entry_operation');

Route::get('konsultasi/operation_step/{cd_bkp}', 'Post_login\ConsultController@operation_step')->name('konsultasi.operation_step');



//--------------------------- MASTER OBAT ------------------------------//
Route::get('master/obat', 'Post_login\MedicineController@index')->name('obat');

Route::get('master/obat/entry/{cd}/{type}', 'Post_login\MedicineController@modal_entry')->name('obat.entry');

Route::post('master/obat/store', 'Post_login\MedicineController@store_data')->name('obat.store_data');

Route::get('master/obat/stock/{cd}', 'Post_login\MedicineController@modal_stock')->name('obat.stock');

Route::get('master/obat/price/{cd}', 'Post_login\MedicineController@modal_price')->name('obat.price');

Route::post('master/price/store', 'Post_login\MedicineController@store_price')->name('obat.store_price');

Route::post('master/stock/store', 'Post_login\MedicineController@store_stock')->name('obat.store_stock');

//--------------------------- MASTER LABORATORIUM ------------------------------//
Route::get('master/lab', 'Post_login\LaboratoriumController@index')->name('lab');

Route::get('master/lab/entry/{cd}/{type}', 'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

Route::post('master/lab/store', 'Post_login\LaboratoriumController@store_data')->name('lab.store_data');

Route::get('master/lab/group', 'Post_login\LaboratoriumController@autocomplete');

//--------------------------- LABORATORIUM ------------------------------//
Route::get('req_lab', 'Post_login\ReqLaboratoriumController@index')->name('req_lab');

Route::get('req_lab/getmodalentry/{cd_bkp}', 'Post_login\ReqLaboratoriumController@modal_entry')->name('req_lab.modal_entry');

Route::post('req_lab/store', 'Post_login\ReqLaboratoriumController@store_data')->name('reqlab.store_data');

Route::get('master/lab/entry/{cd}/{type}', 'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

Route::post('master/lab/store', 'Post_login\LaboratoriumController@store_data')->name('lab.store_data');

//--------------------------- OPERASI ------------------------------//
Route::get('operasi', 'Post_login\OperationController@index')->name('operasi');

Route::get('operasi/getmodalentry/{cd_bkp}', 'Post_login\OperationController@modal_entry')->name('operasi.modal_entry');

Route::post('operasi/insert_operation', 'Post_login\OperationController@insert_operation')->name('operasi.insert_operation');

Route::post('operation/store', 'Post_login\OperationController@store_data')->name('operasi.store_data');

// Route::get('master/lab/entry/{cd}/{type}', 'Post_login\LaboratoriumController@modal_entry')->name('lab.entry');

// Route::post('master/lab/store', 'Post_login\LaboratoriumController@store_data')->name('lab.store_data');



//--------------------------- MASTER OBAT ------------------------------//
Route::get('apotek', 'Post_login\PharmacyController@index')->name('apotek');

Route::get('apotek/getmodalentry/{cd_bkp}', 'Post_login\PharmacyController@modal_entry')->name('apotek.modal_entry');

Route::get('apotek/getnewmed/{cd_bkp}', 'Post_login\PharmacyController@get_new_med')->name('apotek.get_new_med');

Route::get('apotek/paidCheck/{cd_bkp}', 'Post_login\PharmacyController@paid_check')->name('apotek.paid_check');

Route::post('apotek/gettablemedicine', 'Post_login\PharmacyController@get_table_medicine')->name('apotek.get_table_medicine');

Route::post('apotek/store', 'Post_login\PharmacyController@store_data')->name('apotek.store_data');

Route::get('apotek/cek_nilai/{cd_det}/{val}', 'Post_login\PharmacyController@checkedval')->name('apotek.checkedval');

Route::post('master/obat/store', 'Post_login\MedicineController@store_data')->name('obat.store_data');

Route::get('master/obat/stock/{cd}', 'Post_login\MedicineController@modal_stock')->name('obat.stock');

Route::get('master/obat/price/{cd}', 'Post_login\MedicineController@modal_price')->name('obat.price');

Route::post('master/price/store', 'Post_login\MedicineController@store_price')->name('obat.store_price');

Route::post('master/stock/store', 'Post_login\MedicineController@store_stock')->name('obat.store_stock');

/* I DONT EVEN KNOW */
Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user', function () {
        return view('user.index');
    });
});


//--------------------------- MASTER OBAT ------------------------------//
Route::get('user_management', 'Post_login\UserManagementController@index')->name('user_management');

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});