<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Penjemputan;
use App\Models\Penjemput;
use App\Models\Siswa;
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
    $data = Penjemputan::with('penjemput')->whereDate('created_at', Carbon::today())->get();
    return response()->json($data);
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

    if (is_null($siswa) || $siswa->status == 'inactive') return $this->handleError('Failed.', 'No matching NIS', 404);

    $penjemputan = Penjemputan::where('nis', '=', $nis)
      ->whereDate('created_at', Carbon::today())
      ->whereNotIn('status_penjemputan', ['canceled'])
      ->get()
      ->first();

    if (!is_null($penjemputan)) return $this->handleError('Failed.', 'already FR', 400);

    $checkPenjemput = $siswa->penjemput->all();
    if (count($checkPenjemput) == 0) return $this->handleError('Failed.', 'Siswa has no registered driver!', 404);

    $penjemput = $siswa->penjemput->where('ready_status', '=', 'ready')->first();

    $newPenjemputan = new Penjemputan;

    if (empty($penjemput)) {
      $newPenjemputan->nis = $nis;
      $newPenjemputan->save();

      return $this->handleResponse($newPenjemputan, 'Penjemputan inserted. Status = waiting');
    }

    $newPenjemputan->nis = $nis;
    $newPenjemputan->status_penjemputan = 'driver-ready';
    $newPenjemputan->assigned_penjemput = $penjemput->id;
    $newPenjemputan->save();

    return $this->handleResponse($newPenjemputan, 'Penjemputan inserted. Status = driver-ready');
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

  /**
   * Advance Status
   * 
   * @param  \Illuminate\Http\Request  $request
   * @param  $qrCode
   * @return \Illuminate\Http\Response
   */
  public function advanceStatus(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'qr_code' => 'required',
      'type' => 'required',
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);
    $qrCode = $request->qr_code;
    $type = $request->type;

    $splitQr = explode('_', $qrCode);
    $createdAt = $splitQr[0];
    $nis = $splitQr[1];
    $assignedPenjemput = $splitQr[2];
    $idPenjemputan = $splitQr[3];

    $penjemputan = Penjemputan::where([
      ['nis', '=', $nis],
      ['assigned_penjemput', '=', $assignedPenjemput],
      ['id', '=', $idPenjemputan],
    ])->whereDate('created_at', Carbon::parse($createdAt))->get()->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'Wrong QR Code', 400);

    if ($type == 'in') {
      if ($penjemputan->status_penjemputan == 'in-process') {
        $penjemputan->status_penjemputan = 'driver-in';
      } else {
        return $this->handleError('Failed.', 'Status not allowed to advance', 400);
      }
    } else {
      if ($penjemputan->status_penjemputan == 'driver-in') {
        $penjemputan->status_penjemputan = 'finished';
        $penjemput = Penjemput::find($assignedPenjemput);
        $penjemput->ready_status = 'not_ready';
      } else {
        return $this->handleError('Failed.', 'Status not allowed to advance', 400);
      }
    }

    $penjemputan->save();

    return $this->handleResponse($penjemputan, 'Status has been updated!');
  }
}