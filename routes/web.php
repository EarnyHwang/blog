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

Auth::routes();

// 所有Auth提供的routes
Auth::routes();

// 發表評論
Route::post('/postComment', 'BlogController@postComment')->name('postComment');
// PO文頁面
Route::get('/postPage', function () {
    return view('postPage');
})->name('postPage');
// 自己的首頁
Route::get('/home', 'HomeController@index')->name('home');
// PO文後跳轉到檢視頁
Route::post('/viewPage', 'BlogController@postArticle')->name('postArticle');
// 檢視貼文
Route::get('/viewPage/{authorAddress}/{id}','BlogController@viewPage');
// 刪文後跳轉到檢視頁
Route::get('/home/x','BlogController@deleteArticle')->name('deleteArticle');
// 修文頁面
Route::get('/postPage_m','BlogController@modifyArticle')->name('modifyArticle');
// 修文後跳轉到檢視頁
Route::post('/viewPage_m', 'BlogController@sentmodifyArticle')->name('sentmodifyArticle');
// 刪除評論
Route::get('viewPage_d', 'BlogController@deleteComment')->name('deleteComment');
// PO文頁面
Route::get('/', 'HomeController@index');
// 別人的首頁
Route::get('/{authorAddress}', 'HomeController@browser');
