<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Penjemput;

class SiswaPenjemputSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Siswa::create([
      'nis' => '324678',
      'nama_siswa' => 'Aulya Khatulistivani'
    ]);

    Penjemput::create([
      'nis' => '324678',
      'nama_penjemput' => 'Rahmat Rafulo',
      'no_penjemput' => '081222232322',
    ]);
  }
}