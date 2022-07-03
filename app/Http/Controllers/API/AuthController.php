<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjemput;

class AuthController extends BaseController
{
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'no_penjemput' => 'required',
      'nis' => 'required',
      'device_name' => 'required'
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);

    $no_penjemput = $request->no_penjemput;
    $nis = $request->nis;
    $device_name = $request->device_name;
    $penjemput = Penjemput::where('no_penjemput', $no_penjemput)->where('nis', $nis)->where('status', 'active')->first();

    if (!is_null($penjemput)) {
      $penjemputHasToken = $penjemput->tokens;

      if (count($penjemputHasToken) > 0) {
        $penjemput->tokens()->delete();
      }

      $success['token'] =  $penjemput->createToken($device_name)->plainTextToken;
      $success['id'] =  $penjemput->id;

      return $this->handleResponse($success, 'User logged-in!');
    }

    return $this->handleError('Unauthorized.', ['error' => 'Unauthorized']);
  }

  public function logout()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);
    $penjemput->tokens()->delete();

    return $this->handleResponse($penjemput, 'Logout Successful!');
  }
}