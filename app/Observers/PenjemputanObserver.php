<?php

namespace App\Observers;

use App\Models\Penjemputan;
use App\Models\Penjemput;
use App\Models\PenjemputanHistory;
use App\Services\PushNotification;
use Carbon\Carbon;


class PenjemputanObserver
{
  private $queueLimit = 3;

  /**
   * Handle the Penjemputan "created" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function created(Penjemputan $penjemputan)
  {
    $retrieved = Penjemputan::find($penjemputan->id);
    $penjemputanHistory = new PenjemputanHistory;
    $penjemputanHistory->id_penjemputan = $retrieved->id;
    $penjemputanHistory->nis = $retrieved->nis;
    $penjemputanHistory->assigned_penjemput = $retrieved->assigned_penjemput;
    $penjemputanHistory->status_penjemputan = $retrieved->status_penjemputan;

    $penjemputanHistory->save();

    if ($retrieved->status_penjemputan == 'driver-ready') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();

      if ($numberOfQueues < $this->queueLimit) {
        $penjemputan->status_penjemputan = 'in-process';
        $penjemputan->save();
      }
    }

    $penjemput = Penjemput::where('nis', $retrieved->nis)->whereNotNull('firebase_token')->get()->toArray();
    PushNotification::sendNotification($penjemput, "Murid Siap Dijemput", "Murid telah siap untuk dijemput.");
  }

  /**
   * Handle the Penjemputan "updated" event.
   *
   * @param  \App\Models\Penjemputan  $penjemputan
   * @return void
   */
  public function updated(Penjemputan $penjemputan)
  {
    $penjemputanHistory = new PenjemputanHistory;
    $penjemputanHistory->id_penjemputan = $penjemputan->id;
    $penjemputanHistory->nis = $penjemputan->nis;
    $penjemputanHistory->assigned_penjemput = $penjemputan->assigned_penjemput;
    $penjemputanHistory->status_penjemputan = $penjemputan->status_penjemputan;

    $penjemputanHistory->save();

    if ($penjemputan->status_penjemputan == 'driver-ready') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();
      $penjemput = Penjemput::find($penjemputan->assigned_penjemput);
      if ($penjemput) {
        PushNotification::sendNotification($penjemput->firebase_token, "Murid Siap Dijemput", "Murid telah siap untuk dijemput.");
      }

      if ($numberOfQueues < $this->queueLimit) {
        $penjemputan->status_penjemputan = 'in-process';
        $penjemputan->save();
      }
    }

    if ($penjemputan->status_penjemputan == 'in-process') {
      $penjemput = Penjemput::find($penjemputan->assigned_penjemput);
      PushNotification::sendNotification($penjemput->firebase_token, "Murid Siap Dijemput", "Silahkan masuk dengan melakukan scan QR Code ini");
    }

    if ($penjemputan->status_penjemputan == 'finished') {
      $dataPenjemputan = Penjemputan::whereDate('created_at', Carbon::today())->whereIn('status_penjemputan', ['in-process', 'driver-in'])->get();
      $numberOfQueues = $dataPenjemputan->count();

      if ($numberOfQueues < $this->queueLimit) {
        $firstQueue = Penjemputan::whereDate('created_at', Carbon::today())
          ->whereIn('status_penjemputan', ['in-process', 'driver-in'])
          ->whereIn('status_penjemputan', ['driver-ready'])
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