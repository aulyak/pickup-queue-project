<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Siswa;


class TesController extends BaseController
{
  public function tes()
  {
    $siswa = Siswa::all();

    return $this->handleResponse($siswa, 'yo');
  }
}