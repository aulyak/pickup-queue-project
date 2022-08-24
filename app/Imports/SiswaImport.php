<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function collection(Collection $rows)
  {
    Validator::make($rows->toArray(), [
      '*.nis' => 'required|unique:siswa',
      '*.nama_siswa' => 'required',
    ])->validate();

    foreach ($rows as $row) {
      Siswa::create([
        'nis' => $row['nis'],
        'nama_siswa' => $row['nama_siswa'],
      ]);
    }
  }
}