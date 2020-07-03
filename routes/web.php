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
Route::get('/Dregister/404', 'coroxController@registerError404' );
Route::get('/', 'coroxController@index');
Route::get('/Dregister/','coroxController@index')->name('login')->middleware('ARL');
Route::group(['middleware'=>['login']], function(){
Route::get(  '/Dregister/news', 'coroxController@news' );
Route::get(  '/Dregister/show/{id}', 'coroxController@show' );
Route::get('/Dregister/dashboard', 'coroxController@registerDashboard')->name('dashboard');
Route::get('/Dregister/profile', 'coroxController@registerProfile')->middleware('protectRegister');
Route::get(  '/Dregister/info-settings', 'coroxController@registerInfoSettings')->middleware('protectRegister');
Route::post(  '/Dregister/add-info-settings', 'coroxController@registerInfoSettingsAdd' )->middleware('protectRegister');
Route::put(  '/Dregister/update-info-settings', 'coroxController@registerInfoSettingsUpdate');
Route::get('/Dregister/add-staff', 'coroxController@registerStaff')->middleware('protectRegister');
Route::post('/Dregister/add-staff', 'coroxController@registerAddStaff')->middleware('protectRegister');
Route::get('/Dregister/edit-staff/{id}', 'coroxController@registerEditStaff')->middleware('protectRegister');
Route::delete('/Dregister/delete-staff/{id}', 'coroxController@registerDeleteStaff')->middleware('protectRegister');
Route::put('/Dregister/update-staff', 'coroxController@registerUpdateStaff')->middleware('protectRegister');
Route::get('/Dregister/view-staff-table', 'coroxController@registerViewStaffTable')->middleware('protectRegister');
Route::get('/Dregister/staff-register', 'coroxController@registerStaffRegister')->middleware('protectRegister');
Route::post('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister')->middleware('protectRegister');
Route::get(  '/Dregister/view-staffs', 'coroxController@registerViewStaffs' )->middleware('protectRegister');
Route::get(  '/Dregister/priv-settings', 'coroxController@registerPrivilegeSettings' )->middleware('protectRegister');
Route::post('/Dregister/privilege', 'coroxController@registerPrivilege')->middleware('protectRegister');
Route::post('/Dregister/Enable/settings-information', 'coroxController@registerPrivilegeEnableSettings')->middleware('protectRegister');
Route::get('/Dregister/general-settings', 'coroxController@registerGeneralSettings')->middleware('protectRegister');
Route::post('/Dregister/add-subject', 'coroxController@registerAddSubject')->middleware('protectRegister');
Route::post('/Dregister/add-class', 'coroxController@registerAddClass')->middleware('protectRegister');
Route::post('/Dregister/add-period', 'coroxController@registerAddPeriod')->middleware('protectRegister');
Route::get('/Dregister/assign-subject', 'coroxController@registerAssignSubject')->middleware('protectRegister');
Route::get('/Dregister/teacher', 'coroxController@registerTeacher')->middleware('protectRegister');
Route::post('/Dregister/add-teacher', 'coroxController@registerAddTeacher')->middleware('protectRegister');
Route::delete('/Dregister/delete-teacher/{id}', 'coroxController@registerDeleteTeacher')->middleware('protectRegister');
Route::post('/Dregister/update-teacher', 'coroxController@registerUpdateTeacher')->middleware('protectRegister');
Route::get('/Dregister/add-student', 'coroxController@registerStudent')->middleware('protectRegister');
Route::post('/Dregister/add-student', 'coroxController@registerAddStudent')->middleware('protectRegister');
Route::get('/Dregister/edit-student/{id}', 'coroxController@registerEditStudent')->middleware('protectRegister');
Route::put('/Dregister/update-student', 'coroxController@registerUpdateStudent')->middleware('protectRegister');
Route::get(  '/Dregister/view-students', 'coroxController@registerViewStudents' )->middleware('protectRegister');
Route::delete('/Dregister/delete-student/{id}', 'coroxController@registerDeleteStudent')->middleware('protectRegister');
Route::get('/Dregister/students-registers', 'coroxController@registerStudentRegister');
Route::post('/Dregister/students-registers', 'coroxController@registerStudentRegisterTable')->middleware('protectRegister');
Route::get('/Dregister/add-parent', 'coroxController@registerParent')->middleware('protectRegister');
Route::post('/Dregister/add-parent', 'coroxController@registerAddParent')->middleware('protectRegister');
Route::get('/Dregister/edit-parent/{id}', 'coroxController@registerEditParent')->middleware('protectRegister');
Route::delete('/Dregister/delete-parent/{id}', 'coroxController@registerDeleteParent')->middleware('protectRegister');
Route::get(  '/Dregister/view-parents', 'coroxController@registerViewParents' )->middleware('protectRegister');
Route::put('/Dregister/update-parent', 'coroxController@registerUpdateParent')->middleware('protectRegister');
//Route::get('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister');
Route::get('/Dregister/mail/{id}', 'coroxController@mailOut');
});
