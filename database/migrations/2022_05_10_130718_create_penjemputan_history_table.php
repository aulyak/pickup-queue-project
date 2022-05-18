<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjemputanHistoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('penjemputan_history', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('id_penjemputan')->nullable(true);
      $table->timestamps();
      $table->string('nis', 30);
      $table->unsignedInteger('assigned_penjemput')->nullable(true);
      $table->enum('status_penjemputan', ['waiting', 'driver-ready', 'in-process', 'driver-in', 'finished', 'canceled'])->nullable(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('penjemputan_history');
  }
}