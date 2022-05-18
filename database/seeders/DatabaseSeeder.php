<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Penjemput;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();
    User::create([
      'name' => 'Admin',
      'email' => 'admin@abckids.com',
      'password' => bcrypt('@dm1nAbcKids.c0m'),
    ]);
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