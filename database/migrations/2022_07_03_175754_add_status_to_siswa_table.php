<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSiswaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('siswa', function (Blueprint $table) {
      $table->enum('status', ['active', 'inactive'])->nullable(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('siswa', function (Blueprint $table) {
      $table->dropColumn('status');
    });
  }
}