<?php

namespace App\Http\Controllers\API;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends BaseController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Siswa::with('penjemput')->get();

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
  public function show(Siswa $siswa)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function edit(Siswa $siswa)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Siswa  $siswa
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Siswa $siswa)
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
}