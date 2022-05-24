<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_siswa', function (Blueprint $table) {
         $table->id();
            $table->string('nama');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('tahun_masuk');
            $table->string('phone')->nullable(true);
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->bigInteger('id_jurusan');
            $table->string('nim')->unique();
            $table->string('alamat_asal')->nullable(true);
            $table->string('alamat_sekarang')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('status_tmpt_tinggal');
            $table->string('sumber_biaya_sekolah')->nullable(true);
            $table->string('nomor_kk')->nullable(true);
            $table->string('image')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_siswa');
    }
}
