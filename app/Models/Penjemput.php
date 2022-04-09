<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penjemput extends Authenticatable
{
  use HasFactory;
  use HasApiTokens;

  protected $table = "penjemput";
  protected $primaryKey = "id";

  public function siswa()
  {
    return $this->belongsTo(Siswa::class, 'nis');
  }

  public function penjemputan()
  {
    return $this->hasMany(Penjemputan::class, 'assigned_penjemput', 'id');
  }
}