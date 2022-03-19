<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Penjemput;


class AuthController extends BaseController
{
  public function login(Request $request)
  {
    $no_penjemput = $request->no_penjemput;
    $nik_siswa = $request->nik_siswa;

    $penjemput = Penjemput::where('no_penjemput', $no_penjemput)->where('nik_siswa', $nik_siswa)->first();

    if (!is_null($penjemput)) {
      $success['token'] =  $penjemput->createToken('mobileAuth')->plainTextToken;
      $success['id'] =  $penjemput->id;
      return $this->handleResponse($success, 'User logged-in!');
    }

    return $this->handleError('Unauthorized.', ['error' => 'Unauthorized']);
  }
}