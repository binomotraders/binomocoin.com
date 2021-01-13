<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::post('verifysignupotp', 'Auth\RegisterController@verifySignupOtp')->name('verifysignupotp');
Route::post('usersignup', 'Auth\RegisterController@userSignup')->name('usersignup');

Route::match(['get','post'],'/admin/login','Auth\LoginController@adminLogin')->name('admin/login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    //Dashboard
    Route::get('/home', 'HomeController@index')->name('home');
    
    //Change Password
    Route::get('/change-password','HomeController@showChangePasswordForm')->name('change-password');
    Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

    Route::group(['middleware' => ['auth', 'customerauth']], function() {
        //Dashboard
        Route::get('/getbncvalue/{id}', 'HomeController@getBncValuePreview')->name('getbncvalue');
        Route::post('/update/payment/status', 'HomeController@paymentStatus')->name('/update/payment/status');

        //Transaction History
        Route::get('/purchase/history', 'TransactionController@purchaseHistory')->name('purchase/history');
        Route::get('/transfer/history', 'TransactionController@transferHistory')->name('transfer/history');

        //Transfer
        Route::get('/transfer', 'TransferController@viewTransferHome')->name('transfer');
        Route::post('/transfer-bnc', 'TransferController@transferBnc')->name('transfer-bnc');
        Route::get('/transfer/getbncvalue/{id}', 'TransferController@getBncValue')->name('/transfer/getbncvalue/');

        // Withdraw
        Route::get('/withdraw', 'HomeController@viewWithdrawHome')->name('withdraw');

        //Profile
        Route::get('/profile','HomeController@viewProfile')->name('profile');
    }); 
    
    // Route::group(['middleware' => ['auth', 'adminauth']], function() {});
});

