<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Penjemputan;
use App\Models\Siswa;
use App\Models\Penjemput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class PenjemputanController extends BaseController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nis' => 'required',
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);

    $nis = $request->input('nis');
    $siswa = Siswa::find($nis);

    if (is_null($siswa)) return $this->handleError('Failed.', 'No matching NIS', 500);

    $penjemputan = Penjemputan::where('nis', '=', $nis)->whereDate('created_at', Carbon::today())->get()->first();

    if (!is_null($penjemputan)) return $this->handleError('Failed.', 'already FR', 500);

    $penjemput = $siswa->penjemput->where('ready_status', '=', 'ready')->first();

    $new_penjemputan = new Penjemputan;

    if (empty($penjemput)) {
      $new_penjemputan->nis = $nis;
      $new_penjemputan->save();

      return $this->handleResponse($new_penjemputan, 'Penjemputan inserted. Status = waiting');
    }

    $new_penjemputan->nis = $nis;
    $new_penjemputan->status_penjemputan = 'driver-ready';
    $new_penjemputan->assigned_penjemput = $penjemput->id;
    $new_penjemputan->save();

    return $this->handleResponse($new_penjemputan, 'Penjemputan inserted. Status = driver-ready');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function show(Penjemputan $penjemputan)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function edit(Penjemputan $penjemputan)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Penjemputan $penjemputan)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function destroy(Penjemputan $penjemputan)
  {
    //
  }
}