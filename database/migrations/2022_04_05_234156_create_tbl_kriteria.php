<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblKriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_kriteria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_beasiswa');
            $table->string("nama_kriteria");
            $table->string("type");
            $table->integer("bobot");
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
        Schema::dropIfExists('tbl_kriteria');
    }
}
