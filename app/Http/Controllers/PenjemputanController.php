<?php

namespace App\Http\Controllers;

use App\Models\Penjemputan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenjemputanController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Penjemputan::with('penjemput')->whereDate('created_at', Carbon::today())->get();

    return view('penjemputan.index', compact('data'));
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