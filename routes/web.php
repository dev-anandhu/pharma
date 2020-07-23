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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth', 'admin')->group(function () {
    
    Route::prefix('department')->namespace('Department')->group(function () {
        Route::get('/', 'DepartmentController@index')->name('department');
        Route::get('get', 'DepartmentController@index')->name('department.list');
        Route::get('heads', 'DepartmentController@heads')->name('department.heads');
        Route::get('head-list', 'DepartmentController@heads')->name('department.head-list');
        Route::get('delete/{id}', 'DepartmentController@delete')->name('department.delete');
        Route::post('add', 'DepartmentController@add')->name('department.add');
    });

    Route::prefix('employee')->namespace('Employee')->group(function () {
        Route::get('/', 'EmployeeController@index')->name('employees');
        Route::get('get', 'EmployeeController@index')->name('employee.list');
        Route::get('delete/{id}', 'EmployeeController@delete')->name('employee.delete');
        Route::get('status/{id}', 'EmployeeController@status')->name('employee.status');
        Route::get('add/{id?}', 'EmployeeController@add')->name('employee.add');
    });



});

Route::middleware('auth', 'user')->group(function () {

    Route::prefix('report')->namespace('Report')->group(function () {
        Route::get('/', 'ReportController@index')->name('report');
        Route::post('add', 'ReportController@add')->name('report.add');
        Route::get('list', 'ReportController@list')->name('report.list');
    });

});

Route::middleware('auth', 'department')->group(function () {

    Route::prefix('department')->namespace('Department')->group(function () {
        Route::get('reports', 'DepartmentAdminController@employeeReports')->name('department.reports');
        Route::get('report/user/{id}', 'DepartmentAdminController@userReportList')->name('department.user-reports');
        Route::get('user/report/{id}', 'DepartmentAdminController@userReportVerification')->name('department.user-report-verify');
        Route::get('report/verify/{id}', 'DepartmentAdminController@verify')->name('department.verify');
        
    });

});

Route::prefix('employee')->namespace('Employee')->group(function () {
    Route::post('request', 'EmployeeController@request')->name('employee.request');
});