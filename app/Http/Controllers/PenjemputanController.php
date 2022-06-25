<?php

namespace App\Http\Controllers;

use App\Models\Penjemputan;
use App\Models\Penjemput;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class PenjemputanController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Penjemputan::with('penjemput')->whereDate('created_at', Carbon::today())->whereNotIn('status_penjemputan', ['canceled', 'finished'])->get();

    return view('penjemputan.index', compact('data'));
  }

  /**
   * Display a listing of the resource with ajax.
   *
   * @return JSON
   */
  public function ajax()
  {
    $data_penjemputan = Penjemputan::with('siswa')->whereDate('created_at', Carbon::today())->whereNotIn('status_penjemputan', ['canceled', 'finished'])->orderBy('updated_at', 'DESC')->orderBy('created_at', 'ASC')->get();

    return datatables()->of($data_penjemputan)
      ->editColumn('nama_siswa', function ($penjemputan) {
        return $penjemputan->siswa->nama_siswa;
      })
      ->editColumn('assigned_penjemput', function ($penjemputan) {
        return $penjemputan->penjemput ? $penjemputan->penjemput->nama_penjemput : '-';
      })
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $data = Siswa::with('penjemput')->get();

    return view('penjemputan.manual_request', compact('data'));
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

  /**
   * Cancel ongoing penjemputan.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function cancel(Penjemputan $penjemputan)
  {
    $penjemputan->status_penjemputan = 'canceled';
    $penjemputan->save();

    if ($penjemputan->assigned_penjemput) {
      $penjemput = Penjemput::find($penjemputan->assigned_penjemput);
      $penjemput->ready_status = 'not_ready';
      $penjemput->save();
    }

    return redirect()->route('penjemputan.index')
      ->with('success_message', 'Penjemput deleted successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function finish(Penjemputan $penjemputan)
  {
    $penjemputan->status_penjemputan = 'finished';
    $penjemputan->save();

    if ($penjemputan->assigned_penjemput) {
      $penjemput = Penjemput::find($penjemputan->assigned_penjemput);
      $penjemput->ready_status = 'not_ready';
      $penjemput->save();
    }

    return redirect()->route('penjemputan.index')
      ->with('success_message', 'Penjemput finished manually');
  }

  /**
   * Display a listing of the monitoring.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return \Illuminate\Http\Response
   */
  public function monitoring(Penjemputan $penjemputan)
  {
    $data = Penjemputan::with('penjemput')->whereNotIn('status_penjemputan', [''])->whereDate('created_at', Carbon::today())->get();

    return view('penjemputan.monitoring', compact('data'));
  }
}