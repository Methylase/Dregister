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

Route::get('/Dregister/signup','coroxController@registerShowSignUp')->name('register');
Route::post('/Dregister/signup', 'coroxController@registerSignUp' );
Route::post('/Dregister/', 'coroxController@registerLogin' );
Route::post('/Dregister/logout', 'coroxController@logout' );
Route::post('/Dregister/404', 'coroxController@registerError404' );
Route::get('/', 'coroxController@index');
Route::get('/Dregister/','coroxController@index')->name('login');
Route::group(['middleware'=>['login']], function(){
Route::get(  '/Dregister/news', 'coroxController@news' );
Route::get(  '/Dregister/show/{id}', 'coroxController@show' );
Route::get('/Dregister/dashboard', 'coroxController@registerDashboard')->name('dashboard');
Route::get('/Dregister/profile', 'coroxController@registerProfile')->middleware('protectRegister');
Route::get(  '/Dregister/info-settings', 'coroxController@registerInfoSettings')->middleware('protectRegister');
Route::post(  '/Dregister/add-info-settings', 'coroxController@registerInfoSettingsAdd' )->middleware('protectRegister');
Route::put(  '/Dregister/update-info-settings', 'coroxController@registerInfoSettingsUpdate');
Route::get('/Dregister/add-staff', 'coroxController@registerStaff')->middleware('protectRegister');
Route::post('/Dregister/add-staff', 'coroxController@registerAddStaff');
Route::get('/Dregister/edit-staff/{id}', 'coroxController@registerEditStaff');
Route::delete('/Dregister/delete-staff/{id}', 'coroxController@registerDeleteStaff');
Route::put('/Dregister/update-staff', 'coroxController@registerUpdateStaff');
Route::get('/Dregister/view-staff-table', 'coroxController@registerViewStaffTable');
Route::get('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister');
Route::get(  '/Dregister/priv-settings', 'coroxController@registerPrivilegeSettings' )->middleware('protectRegister');
Route::get(  '/Dregister/view-staffs', 'coroxController@registerViewStaffs' )->middleware('protectRegister');
Route::post('/Dregister/privilege', 'coroxController@registerPrivilege');
Route::get('/Dregister/general-settings', 'coroxController@registerGeneralSettings');
Route::post('/Dregister/add-subject', 'coroxController@registerAddSubject');
Route::post('/Dregister/add-class', 'coroxController@registerAddClass');
Route::post('/Dregister/add-period', 'coroxController@registerAddPeriod');
Route::get('/Dregister/assign-subject', 'coroxController@registerAssignSubject');
Route::get('/Dregister/teacher', 'coroxController@registerTeacher');
Route::post('/Dregister/add-teacher', 'coroxController@registerAddTeacher');
Route::post('/Dregister/add-teacher', 'coroxController@registerAddTeacher');
Route::delete('/Dregister/delete-teacher/{id}', 'coroxController@registerDeleteTeacher');
Route::post('/Dregister/update-teacher', 'coroxController@registerUpdateTeacher');
//Route::get('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister');
Route::get('/Dregister/mail/{id}', 'coroxController@mailOut');
});
