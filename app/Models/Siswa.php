<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = "siswa";
    protected $primaryKey = 'nik';
    public $incrementing = false;

    protected $fillable = [
        'nama_siswa', 'nik'
    ];

    public function penjemput()
    {
        return $this->hasMany(Penjemput::class, 'nik_siswa', 'nik');
    }
}