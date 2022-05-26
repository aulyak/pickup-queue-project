<?php

namespace App\Exports;

use App\Models\PenjemputanHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjemputanHistoryExport implements FromCollection
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
    if (!$this->from_date && !$this->to_date) return PenjemputanHistory::all();

    return PenjemputanHistory::whereDate('created_at', '>=', $this->from_date)->whereDate('created_at', '<=', $this->to_date)->get();
  }
}