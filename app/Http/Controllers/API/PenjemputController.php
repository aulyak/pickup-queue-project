<?php

namespace App\Http\Controllers\API;

use App\Models\Penjemput;
use App\Models\Penjemputan;
use App\Models\Siswa;
use App\Http\Resources\Penjemput as PenjemputResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseControoller;
use Carbon\Carbon;

class PenjemputController extends BaseControoller
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
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Penjemput  $penjemput
   * @return \Illuminate\Http\Response
   */
  public function show(Penjemput $penjemput)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Penjemput  $penjemput
   * @return \Illuminate\Http\Response
   */
  public function edit(Penjemput $penjemput)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Penjemput  $penjemput
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Penjemput $penjemput)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Penjemput  $penjemput
   * @return \Illuminate\Http\Response
   */
  public function destroy(Penjemput $penjemput)
  {
  }

  /**
   * Confirm Driver Arrival on Location
   * 
   * @return \Illuminate\Http\Response
   */
  public function confirmAtLocation()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);
    $penjemput->ready_status = 'ready';

    $penjemput->save();

    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->where('status_penjemputan', 'waiting')
      ->whereDate('created_at', Carbon::today())->first();

    if ($penjemputan) {
      $penjemputan->status_penjemputan = 'driver-ready';
      $penjemputan->assigned_penjemput = $penjemput->id;
      $penjemputan->save();

      return $this->handleResponse($penjemputan, 'Status has been updated and driver\'s assigned to penjemputan.');
    }

    return $this->handleResponse($penjemput, 'Status has been updated.');
  }

  /**
   * Confirm Driver Initiating Pickup
   * 
   * @return \Illuminate\Http\Response
   */
  public function confirmPickup()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);

    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->where('status_penjemputan', '=', 'driver-ready')
      ->whereDate('created_at', Carbon::today())->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'Nothing to confirm', 404);

    $penjemputan->status_penjemputan = 'in-process';
    $penjemputan->save();

    return $this->handleResponse($penjemputan, 'Penjemputan status has been updated');
  }

  /**
   * Get penjemputan in process corresponding to current Penjemput
   * 
   * @return \Illuminate\Http\Response
   */
  public function getPenjemputanInProcess()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);

    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->where('status_penjemputan', '=', 'in-process')
      ->whereDate('created_at', Carbon::today())->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'No penjemputan in process', 404);

    return $this->handleResponse($penjemputan, 'Penjemputan retrieved');
  }

  /**
   * Get QR Code
   * 
   * @return \Illuminate\Http\Response
   */
  public function getQRCode()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);

    if ($penjemput->ready_status != 'ready') return $this->handleError('Finished.', 'No penjemputan in process', 404);

    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->whereIn('status_penjemputan', ['in-process', 'driver-in'])
      ->whereDate('created_at', Carbon::today())->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'No penjemputan in process', 404);

    $createdTime = $penjemputan->created_at;
    $nis = $penjemputan->nis;
    $assignedPenjemput = $penjemputan->assigned_penjemput;
    $idPenjemputan = $penjemputan->id;

    $qrCode = "" . $createdTime . "_" . $nis . "_" . $assignedPenjemput . "_" . $idPenjemputan;

    return $this->handleResponse($qrCode, 'QR Code retrieved');
  }

  /**
   * Set Penjemput firebase token
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function setFirebaseToken(Request $request)
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);

    $validator = Validator::make($request->all(), [
      'firebase_token' => 'required',
    ]);

    if ($validator->fails()) return $this->handleError('Failed.', ['error' => $validator->getMessageBag()->toArray()], 400);

    $penjemput->firebase_token = $request->firebase_token;

    $penjemput->save();

    return $this->handleResponse($penjemput, 'Firebase token has been updated.');
  }

  /**
   * Get Penjemput firebase token
   * 
   * @return \Illuminate\Http\Response
   */
  public function getFirebaseToken()
  {
    $correspondingPenjemputId = auth()->user()->id;
    $penjemput = Penjemput::find($correspondingPenjemputId);

    $firebaseToken = $penjemput->firebase_token;

    if (!$firebaseToken) return $this->handleError('Failed.', 'No token found', 404);

    return $this->handleResponse($firebaseToken, 'Token retrieved');
  }
}