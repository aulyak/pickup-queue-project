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

Route::post('/siswa/register', 'SiswaController@registerSiswa');
Route::post('/siswa/updateEmbeddingByNis', 'SiswaController@updateEmbeddingByNis');
Route::get('/siswa', 'SiswaController@index');
Route::get('/siswa/{nis}', 'SiswaController@show');

Route::post('/login', 'AuthController@login');
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', 'AuthController@logout');
  Route::post('/confirm-at-location', 'PenjemputController@confirmAtLocation');
  Route::post('/confirm-pickup', 'PenjemputController@confirmPickup');
  Route::post('/get-penjemputan-in-process', 'PenjemputController@getPenjemputanInProcess');
  Route::post('/set-firebase-token', 'PenjemputController@setFirebaseToken');
  Route::post('/get-firebase-token', 'PenjemputController@getFirebaseToken');
  Route::post('/get-qr-code', 'PenjemputController@getQRCode');
});