<?php

namespace App\Observers;

use App\Models\Penjemputan;
use App\Models\Penjemput;
use App\Models\PenjemputanHistory;
use App\Services\PushNotification;
use Carbon\Carbon;

class PenjemputanObserver
{
  /**
   * Handle the Penjemputan "created" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function created(Penjemputan $penjemputan)
  {
    //
    $retrieved = Penjemputan::find($penjemputan->id);
    $penjemputanHistory = new PenjemputanHistory;
    $penjemputanHistory->id_penjemputan = $retrieved->id;
    $penjemputanHistory->nis = $retrieved->nis;
    $penjemputanHistory->assigned_penjemput = $retrieved->assigned_penjemput;
    $penjemputanHistory->status_penjemputan = $retrieved->status_penjemputan;

    $penjemputanHistory->save();

    //
    if ($retrieved->status_penjemputan == 'driver-ready') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();

      if ($numberOfQueues < 10) {
        $penjemputan->status_penjemputan = 'in-process';
        $penjemputan->save();
      }
    }
  }

  /**
   * Handle the Penjemputan "updated" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function updated(Penjemputan $penjemputan)
  {
    //

    $penjemputanHistory = new PenjemputanHistory;
    $penjemputanHistory->id_penjemputan = $penjemputan->id;
    $penjemputanHistory->nis = $penjemputan->nis;
    $penjemputanHistory->assigned_penjemput = $penjemputan->assigned_penjemput;
    $penjemputanHistory->status_penjemputan = $penjemputan->status_penjemputan;

    $penjemputanHistory->save();

    if ($penjemputan->status_penjemputan == 'driver-ready') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();

      if ($numberOfQueues < 10) {
        $penjemputan->status_penjemputan = 'in-process';
        $penjemputan->save();
      }
    }

    // 
    if ($penjemputan->status_penjemputan == 'in-process') {
      // hit firebase
      dump('here');
      $penjemput = Penjemput::find($penjemputan->assigned_penjemput);
      PushNotification::sendNotification($penjemput->firebase_token);
    }

    if ($penjemputan->status_penjemputan == 'finished') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();

      if ($numberOfQueues < 10) {
        $firstQueue = Penjemputan::whereDate('created_at', Carbon::today())
          ->whereIn('status_penjemputan', ['in-process', 'driver-in'])
          ->orderBy('created_at', 'ASC')
          ->first();

        if ($firstQueue) {
          $firstQueue->status_penjemputan = 'in-process';
          $firstQueue->save();
        }
      }
    }
  }

  /**
   * Handle the Penjemputan "deleted" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function deleted(Penjemputan $penjemputan)
  {
    //
  }

  /**
   * Handle the Penjemputan "restored" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function restored(Penjemputan $penjemputan)
  {
    //
  }

  /**
   * Handle the Penjemputan "force deleted" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function forceDeleted(Penjemputan $penjemputan)
  {
    //
  }
}