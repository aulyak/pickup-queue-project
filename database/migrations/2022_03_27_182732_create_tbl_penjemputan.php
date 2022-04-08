<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPenjemputan extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('penjemputan', function (Blueprint $table) {
      $table->id();
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
    Schema::dropIfExists('penjemputan');
  }
}