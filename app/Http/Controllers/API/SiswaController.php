<?php

namespace App\Http\Controllers\API;

use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends BaseController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Siswa::with('penjemput')->where('status', 'active')->get();

    return $this->handleResponse($data, 'Siswa retrieved successfully.');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function show($idSiswa)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function edit($idSiswa)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $idSiswa)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function destroy(Siswa $siswa)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function updateEmbeddingByNis(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'nis' => 'required',
      'embedding' => 'required',
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);

    $siswa = Siswa::find($request->input('nis'));

    if (!$siswa || $siswa->status == 'inactive') return $this->handleError('Failed', 'No Siswa Found', 404);

    $siswa->embedding = $request->input('embedding');
    $siswa->save();

    return $this->handleResponse($siswa, 'Siswa\'s embedding has been successfully updated.');
  }

  public function registerSiswa(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nis' => 'required|unique:siswa,nis',
      'nama_siswa' => 'required',
      'embedding' => 'required',
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);

    $newSiswa = new Siswa;

    $newSiswa->nis = $request->input('nis');
    $newSiswa->nama_siswa = $request->input('nama_siswa');
    $newSiswa->embedding = $request->input('embedding');

    $newSiswa->save();

    return $this->handleResponse($newSiswa, 'Siswa has been registered successfully');
  }
}