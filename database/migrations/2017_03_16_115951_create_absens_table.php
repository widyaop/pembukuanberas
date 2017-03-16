<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('pegawai_id')->unsigned();
            $table->date('tanggal_absen');
            $table->boolean('absen')->default(0);
            $table->integer('waktu_absen');
            $table->enum('tipe_absen',['masuk','keluar']);
            $table->timestamps();
        });
        Schema::table('absens', function(Blueprint $table){
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
          $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absens');
    }
}
