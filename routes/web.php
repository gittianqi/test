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

Route::get('/',function(){
    return redirect('index');
});

Route::get('/imgsys/{one?}/{two?}/{three?}/{four?}/{five?}/{six?}/{seven?}/{eight?}/{nine?}',function(){
    \App\Http\Controllers\Platform\ImageRoute::imageStorageRoute();
});

/* ========================== Admin start ========================== */
Route::group(['namespace' => 'Admin','middleware'=>['web','user']], function() {
        Route::get('index','AdminController@index');

});
/* ========================== Admin end ========================== */


/* ========================== Common start ========================== */
Route::group(['namespace' => 'Common'], function() {
    Route::match(['post','get'],'login','PublicController@login')->name('login');
    Route::get('outLogin', 'PublicController@outLogin');
});
/* ========================== Common end ========================== */


/* ========================== Member start ========================== */
Route::group(['namespace' => 'Member','middleware'=>['web','user']], function() {
    Route::match(['post','get'],'member','MemberController@index');
    Route::match(['post','get'],'memberEdit','MemberController@edit');
});
/* ========================== Member end ========================== */


/* ========================== Platform start ========================== */
Route::group(['namespace' => 'Platform','middleware'=>['web','user']], function() {
    Route::get('platform','PlatformController@index');
    Route::match(['post','get'],'platformEdit','PlatformController@edit');
    Route::match(['post','get'],'platformAdd','PlatformController@add');
    Route::match(['post','get'],'platformDel','PlatformController@del');
    Route::post('uploadlogo','PlatformController@uploadLogo');

});
/* ========================== Platform end ========================== */


/* ========================== withdraw start ========================== */
Route::group(['namespace' => 'Withdraw','middleware'=>['web','user']], function() {
    Route::get('withdrawindex/{status}','WithdrawController@index');
    Route::post('agreewithdraw','WithdrawController@agreeWithdraw');
    Route::post('refusewithdraw','WithdrawController@refuseWithdraw');
});
/* ========================== withdraw end ========================== */
