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
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function confirmAtLocation(Penjemput $penjemput)
  {
    $penjemput->ready_status = 'ready';

    $penjemput->save();

    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->whereDate('created_at', Carbon::today())->first();

    if ($penjemputan) {
      $penjemputan->status_penjemputan = 'driver-ready';
      $penjemputan->assigned_penjemput = $penjemput->id;
      $penjemputan->save();

      return $this->handleResponse($penjemputan, 'Your status has been updated and you\'re assigned to penjemputan.');
    }

    return $this->handleResponse($penjemput, 'Your status has been updated.');
  }

  /**
   * Confirm Driver Arrival on Location
   * 
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function confirmPickup(Penjemput $penjemput)
  {
    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->where('status_penjemputan', '=', 'driver-ready')
      ->whereDate('created_at', Carbon::today())->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'Nothing to confirm', 500);

    $penjemputan->status_penjemputan = 'in-process';
    $penjemputan->save();

    return $this->handleResponse($penjemputan, 'Penjemputan status has been updated');
  }

  /**
   * Confirm Driver Arrival on Location
   * 
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function getPenjemputanInProcess(Penjemput $penjemput)
  {
    $penjemputan = Penjemputan::where('nis', $penjemput->siswa->nis)
      ->where('status_penjemputan', '=', 'driver-ready')
      ->whereDate('created_at', Carbon::today())->first();

    if (!$penjemputan) return $this->handleError('Failed.', 'No penjemputan in process', 500);

    return $this->handleResponse($penjemputan, 'Penjemputan retrieved');
  }
}