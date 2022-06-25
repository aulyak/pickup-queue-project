<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('penjemputan', 'PenjemputanController', ['as' => 'api']);
Route::post('/penjemputan/advance-status', 'PenjemputanController@advanceStatus');

Route::resource('siswa', 'SiswaController');
Route::post('siswa/register', 'SiswaController@registerSiswa');
Route::post('/siswa/updateEmbeddingByNis', 'SiswaController@updateEmbeddingByNis');

Route::post('/login', 'AuthController@login');
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', 'AuthController@logout');
  Route::post('/confirm-at-location/{penjemput}', 'PenjemputController@confirmAtLocation');
  Route::post('/confirm-pickup/{penjemput}', 'PenjemputController@confirmPickup');
  Route::post('/get-penjemputan-in-process/{penjemput}', 'PenjemputController@getPenjemputanInProcess');
  Route::post('/set-firebase-token/{penjemput}', 'PenjemputController@setFirebaseToken');
  Route::post('/get-firebase-token/{penjemput}', 'PenjemputController@getFirebaseToken');
  Route::post('/get-qr-code/{penjemput}', 'PenjemputController@getQRCode');
});