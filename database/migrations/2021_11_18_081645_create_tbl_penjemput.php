<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPenjemput extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('penjemput', function (Blueprint $table) {
      $table->increments('id');
      $table->text('nis');
      $table->text('nama_penjemput');
      $table->text('no_penjemput');
      $table->dateTime('created_at');
      $table->dateTime('updated_at');
      $table->text('firebase_token')->nullable(true);
      $table->enum('ready_status', ['not_ready', 'ready'])->nullable(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('penjemput');
  }
}