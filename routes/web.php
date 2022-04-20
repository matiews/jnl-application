<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin/login', ['uses'=>'LoginController@getLogin', 'as'=>'login.show']);
Route::post('/admin/post-login', ['uses'=>'LoginController@postLogin', 'as'=>'login.post']);
Route::get('/admin/logout', ['uses'=>'LoginController@getLogout', 'as'=>'logout']);

Route::get('/noPermission', function(){

	return view('errors.no_permission');
});

Route::group(['middleware'=>['authen', 'roles']], function(){

Route::get('/admin/dashboard', ['uses'=>'DashboardController@getDashboard', 'as'=>'dashboard.show']);

Route::get('/admin/user/profile', ['uses'=>'ProfileController@showProfile', 'as'=>'profile.show']);

Route::post('/admin/user/create', ['uses'=>'RegistrationController@createUser', 'as'=>'user.create']);

Route::post('/admin/user/{id}/update', ['uses'=>'ProfileController@updateUser', 'as'=>'user.update']);

});


Route::group(['middleware'=>['authen', 'roles'], 'roles'=>['principal']], function(){

Route::get('/admin/user/', ['uses'=>'RegistrationController@showUser', 'as'=>'user.show']);



});

