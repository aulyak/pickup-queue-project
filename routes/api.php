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

Route::resource('penjemputan', 'PenjemputanController');

Route::post('/login', 'AuthController@login');

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', 'AuthController@logout');
  Route::post('/confirm-at-location/{penjemput}', 'PenjemputController@confirmAtLocation');
});