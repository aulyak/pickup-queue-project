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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

  Route::get('/dashboard', function () {
    return redirect()->route('siswa.index');
  })->name('dashboard');

  Route::get('/', function () {
    return redirect()->route('siswa.index');
  });

  // Route::get('/register', function () {
  //   return redirect()->route('siswa.index');
  // });

  Route::get('/home', function () {
    return redirect()->route('siswa.index');
  });

  Route::post('/siswa/import_excel', 'SiswaController@import_excel');

  Route::resource('/siswa', 'SiswaController');
  Route::resource('/penjemput', 'PenjemputController');
  Route::resource('/penjemputan', 'PenjemputanController');
  Route::put('/siswa/set_inactive/{siswa}', 'SiswaController@setInactive')->name('siswa.setInactive');
  Route::get('/penjemputan/monitoring/view', 'PenjemputanController@monitoring');
  Route::get('/penjemputan_ajax', 'PenjemputanController@ajax')->name('penjemputan.ajax');
  Route::get('/penjemputan/manual/request', 'PenjemputanController@create');

  Route::get('/penjemputan_history/export_excel', 'PenjemputanHistoryController@exportExcel')->name('exportPenjemputanHistory');
  Route::get('/penjemputan_history/coba', 'PenjemputanHistoryController@exportExcel');
  Route::get('/penjemputan_history', 'PenjemputanHistoryController@indexFilter')->name('indexFilter');
  // Route::delete('penjemput/{penjemput}/redirect/{siswa}', 'PenjemputController@destroyRedirect')->name('penjemput.destroy.redirect');
  Route::put('/penjemput/byid/{id}', 'PenjemputController@updateById')->name('penjemput.update.byId');
  Route::put('/penjemputan/cancel/{penjemputan}', 'PenjemputanController@cancel')->name('penjemputan.cancel');
  Route::put('/penjemput/set_inactive/{penjemput}/{siswa}', 'PenjemputController@setInactive')->name('penjemput.setInactive');
});