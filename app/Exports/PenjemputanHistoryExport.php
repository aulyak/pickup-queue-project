<?php

namespace App\Exports;

use App\Models\PenjemputanHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenjemputanHistoryExport implements FromCollection, WithHeadings, WithMapping
{
  /**
   * @return \Illuminate\Support\Collection
   */

  protected $from_date;
  protected $to_date;

  function __construct($from_date, $to_date)
  {
    $this->from_date = $from_date;
    $this->to_date = $to_date;
  }

  public function collection()
  {
    if (!$this->from_date && !$this->to_date) return PenjemputanHistory::with('siswa')->get();

    return PenjemputanHistory::with('siswa')->whereDate('created_at', '>=', $this->from_date)->whereDate('created_at', '<=', $this->to_date)->get();
  }

  public function map($penjemputan_history): array
  {
    return [
      $penjemputan_history->id_penjemputan,
      $penjemputan_history->nis,
      $penjemputan_history->siswa->nama_siswa,
      $penjemputan_history->penjemput ? $penjemputan_history->penjemput->nama_penjemput : '-',
      $penjemputan_history->status_penjemputan,
      Carbon::parse($penjemputan_history->created_at)->toFormattedDateString(),
      Carbon::parse($penjemputan_history->updated_at)->toFormattedDateString(),
      $penjemputan_history->created_at,
      $penjemputan_history->updated_at,
    ];
  }

  public function headings(): array
  {
    return [
      "ID Penjemputan",
      "NIS",
      "Nama Siswa",
      "Assigned Penjemput",
      "Status Penjemputan",
      "Created At (String)",
      "Updated At (String)",
      "Created At",
      "Updated At",
    ];
  }
}