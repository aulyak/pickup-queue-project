<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
  use HasFactory;

  protected $table = "penjemputan";

  public function siswa()
  {
    return $this->belongsTo(Siswa::class, 'nis');
  }

  public function penjemput()
  {
    return $this->belongsTo(Penjemput::class, 'assigned_penjemput');
  }
}