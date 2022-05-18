<?php

namespace App\Http\Controllers;

use App\Models\PenjemputanHistory;
use App\Http\Requests\StorePenjemputanHistoryRequest;
use App\Http\Requests\UpdatePenjemputanHistoryRequest;

class PenjemputanHistoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = PenjemputanHistory::with('penjemput')->get();

    return view('penjemputan_history.index', compact('data'));
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
   * @param  \App\Http\Requests\StorePenjemputanHistoryRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePenjemputanHistoryRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\PenjemputanHistory  $penjemputanHistory
   * @return \Illuminate\Http\Response
   */
  public function show(PenjemputanHistory $penjemputanHistory)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\PenjemputanHistory  $penjemputanHistory
   * @return \Illuminate\Http\Response
   */
  public function edit(PenjemputanHistory $penjemputanHistory)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdatePenjemputanHistoryRequest  $request
   * @param  \App\Models\PenjemputanHistory  $penjemputanHistory
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePenjemputanHistoryRequest $request, PenjemputanHistory $penjemputanHistory)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\PenjemputanHistory  $penjemputanHistory
   * @return \Illuminate\Http\Response
   */
  public function destroy(PenjemputanHistory $penjemputanHistory)
  {
    //
  }
}