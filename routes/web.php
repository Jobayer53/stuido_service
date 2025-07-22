<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ServerCopyController;

Auth::routes();
Route::get('/', function () {return redirect()->route('user_home');});
Route::get('/home', function () {return redirect()->route('user_home');})->name('home');


//users
Route::post('/userRegister',[RegisterController::class, 'user_register'])->name('user_register');
Route::post('/userLogin',[LoginController::class, 'user_login'])->name('user_login');
Route::get('/order/download/{order}', [ServiceOrderController::class, 'download'])->name('order_download');



Route::middleware(['auth'])->group(function () {
    Route::get('/user-home', [FrontendController::class, 'index'])->name('user_home');
    Route::get('/user-setting', [FrontendController::class, 'user_setting'])->name('user_setting');
    Route::post('/user-update', [FrontendController::class, 'user_update'])->name('user_update');
    // server copy
    Route::get('/server-copy',[ServiceController::class, 'serverCopyIndex'])->name('server_copy_index');
    Route::post('/order-server-copy',[ServiceOrderController::class, 'serverCopyOrder'])->name('order_server_copy');
    // sign copy
    Route::get('/sign-copy',[ServiceController::class, 'signCopyIndex'])->name('sign_copy_index');
    Route::post('/order-sign-copy',[ServiceOrderController::class, 'signCopyOrder'])->name('order_sign_copy');
    // nid pdf
    Route::get('/nid-pdf',[ServiceController::class, 'nidPdfIndex'])->name('nid_pdf_index');
    Route::post('/order-nid-pdf',[ServiceOrderController::class, 'nidPdfOrder'])->name('order_nid_pdf');
    // nid user pass
    Route::get('/nid-user-pass',[ServiceController::class, 'nidUserPassIndex'])->name('nid_userPass_index');
    Route::post('/order-nid-pass',[ServiceOrderController::class, 'nidPassOrder'])->name('order_nid_pass');
    // biometric
    Route::get('/biometric',[ServiceController::class, 'biometricIndex'])->name('biometric_index');
    Route::post('/order-biometric',[ServiceOrderController::class, 'biometricOrder'])->name('order_biometric');
    // lost nid
    Route::get('/lost-nid',[ServiceController::class, 'lostNidIndex'])->name('lostNid_index');
    Route::post('/order-lost_nid',[ServiceOrderController::class, 'lostNidOrder'])->name('order_lost_nid');
    // passport
    Route::get('/passport',[ServiceController::class, 'passportIndex'])->name('passport_index');
    Route::post('/order-passport',[ServiceOrderController::class, 'passportOrder'])->name('order_passport');
    // location
    Route::get('/location',[ServiceController::class, 'locationIndex'])->name('location_index');
    Route::post('/order-location',[ServiceOrderController::class, 'locationOrder'])->name('order_location');
    // call sms list
    Route::get('/call-sms',[ServiceController::class, 'smsIndex'])->name('sms_index');
    Route::post('/order-call-sms',[ServiceOrderController::class, 'smsOrder'])->name('order_sms');
    // imei
    Route::get('/imei',[ServiceController::class, 'imeiIndex'])->name('imei_index');
    Route::post('/order-imei',[ServiceOrderController::class, 'imeiOrder'])->name('order_imei');
    // nagad
    Route::get('/nogod-bikash-info',[ServiceController::class, 'nagadIndex'])->name('nagad_index');
    Route::post('/order-nagad-bikash',[ServiceOrderController::class, 'nagadOrder'])->name('order_nagad');
    // tin
    Route::get('/tin-service',[ServiceController::class, 'tinIndex'])->name('tin_index');
    Route::post('/order-tin',[ServiceOrderController::class, 'tinOrder'])->name('order_tin');
    // land - bhumi
    Route::get('/land-service',[ServiceController::class, 'landIndex'])->name('land_index');
    Route::post('/order-land',[ServiceOrderController::class, 'landOrder'])->name('order_land');
    // register - nibondhon
    Route::get('/land-register',[ServiceController::class, 'registerIndex'])->name('register_index');
    Route::post('/order-register',[ServiceOrderController::class, 'registerOrder'])->name('order_register');
    // number statement
    Route::get('/land-statement',[ServiceController::class, 'statementIndex'])->name('statement_index');
    Route::post('/order-statement',[ServiceOrderController::class, 'statementOrder'])->name('order_statement');
    // vaccine
    Route::get('/land-vaccine',[ServiceController::class, 'vaccineIndex'])->name('vaccine_index');
    Route::post('/order-vaccine',[ServiceOrderController::class, 'vaccineOrder'])->name('order_vaccine');
    // birth certificate number change
    Route::get('/land-bc_change',[ServiceController::class, 'bc_changeIndex'])->name('bc_change_index');
    Route::post('/order-bc_change',[ServiceOrderController::class, 'bc_changeOrder'])->name('order_bc_change');
    //bmet
    Route::get('/land-bmet',[ServiceController::class, 'bmetIndex'])->name('bmet_index');
    Route::post('/order-bmet',[ServiceOrderController::class, 'bmetOrder'])->name('order_bmet');





    // Route::get('/order-cancel/{id}',[ServiceOrderController::class, 'orderCancel'])->name('order_cancel');
});


//admin
Route::get('/admin-login', [AdminController::class, 'admin_login'])->name('admin_login');
Route::get('/admin-register', [AdminController::class, 'admin_register'])->name('admin_register');
Route::post('/adminRegister',[AdminController::class, 'admin_register_store'])->name('admin_register_store');
Route::post('/adminLogin',[AdminController::class, 'admin_login_check'])->name('admin_login_check');

Route::post('/adminLogout', [AdminController::class, 'admin_logout'])->name('admin_logout');
Route::middleware(['admin'])->group(function(){
    //routes for admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');
    Route::get('/admin-profile', [AdminController::class, 'admin_profile'])->name('admin_profile');
    Route::post('/admin-profile-update', [AdminController::class, 'admin_profile_update'])->name('admin_update');
    Route::get('/admin-services',[ServiceController::class, 'admin_service_index'])->name('admin_service_index');
    Route::post('/services/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    Route::post('/admin-service-update',[ServiceController::class, 'admin_service_update'])->name('admin_service_update');
    Route::get('/admin-orders',[OrderController::class, 'index'])->name('admin_order');
    Route::get('/admin-order-details/{id}',[OrderController::class, 'show'])->name('admin_order_details');
    // single page
    Route::get('/admin_biometric_orderd_etails',[OrderController::class, 'biometric_show'])->name('biometric_order_details');
    Route::get('/admin-passport-order-details',[OrderController::class, 'passport_show'])->name('passport_order_details');
    Route::get('/admin-sms-order-details',[OrderController::class, 'sms_show'])->name('sms_order_details');
    Route::get('/admin-imei-order-details',[OrderController::class, 'imei_show'])->name('imei_order_details');
    Route::get('/admin-nagadBikash-order-details',[OrderController::class, 'nagad_show'])->name('nagad_order_details');
    Route::get('/admin-register-order-details',[OrderController::class, 'register_show'])->name('register_order_details');
    Route::get('/admin-statement-order-details',[OrderController::class, 'statement_show'])->name('statement_order_details');
    //
    Route::post('/admin-status-update',[OrderController::class, 'admin_status_update'])->name('admin_status_update');
    Route::post('/admin-file-upload',[OrderController::class, 'admin_file'])->name('admin_file');

    //search by slug
    Route::post('/seach-by-slug', [OrderController::class, 'showOrderBySlug'])->name('order.slug');
});
