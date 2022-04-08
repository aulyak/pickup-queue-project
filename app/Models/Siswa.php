<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  use HasFactory;

  protected $table = "siswa";
  protected $primaryKey = 'nis';
  public $incrementing = false;

  protected $fillable = [
    'nama_siswa', 'nis'
  ];

  public function penjemput()
  {
    return $this->hasMany(Penjemput::class, 'nis', 'nis');
  }
}
