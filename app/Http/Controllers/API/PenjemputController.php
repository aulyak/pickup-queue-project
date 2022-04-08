<?php

namespace App\Http\Controllers\API;

use App\Models\Penjemput;
use App\Models\Siswa;
use App\Http\Resources\Penjemput as PenjemputResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseControoller;

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

    return $this->handleResponse($penjemput, 'Your status has been updated.');
  }
}