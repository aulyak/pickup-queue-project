<?php

namespace App\Http\Controllers;

use App\Exports\PenjemputanHistoryExport;
use App\Models\PenjemputanHistory;
use App\Http\Requests\StorePenjemputanHistoryRequest;
use App\Http\Requests\UpdatePenjemputanHistoryRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PenjemputanHistoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // dump($request);

    // $request->validate([
    //   'startDate' => 'required|date',
    //   'endDate' => 'required|date|before_or_equal:start_date',
    // ]);

    // $data = PenjemputanHistory::with('siswa')->with('penjemput')->get();

    // return view('penjemputan_history.index', compact('data'));
  }

  public function indexFilter(Request $request)
  {
    $data = PenjemputanHistory::with('siswa')->with('penjemput')->get();
    $filter = false;

    $startDatePicked = $request->startDate;
    $endDatePicked = $request->endDate;

    if ($startDatePicked && $endDatePicked) {
      $startDate = Carbon::createFromFormat('Y-m-d', $startDatePicked);
      $endDate = Carbon::createFromFormat('Y-m-d', $endDatePicked);

      if ($startDate > $endDate) {
        $startDatePicked = null;
        $endDatePicked = null;
        $filter = false;
        return view('penjemputan_history.index', compact('data', 'filter', 'startDatePicked', 'endDatePicked'));
      }

      $filter = true;
      $data = PenjemputanHistory::with('penjemput')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->get();
    }

    return view('penjemputan_history.index', compact('data', 'filter', 'startDatePicked', 'endDatePicked'));
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

  public function exportExcel(Request $request)
  {
    $name = 'Penjemputan History - ' . $request->startDate . '-' . $request->endDate . '.xlsx';
    if (!$request->startDate && !$request->endDate) $name = 'Penjemputan History - all.xlsx';
    return Excel::download(new PenjemputanHistoryExport($request->startDate, $request->endDate), $name);
  }
}