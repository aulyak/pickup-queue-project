<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjemput extends Model
{
    use HasFactory;

    protected $table = "penjemput";
    protected $primaryKey = "id";

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nik_siswa');
    }
}