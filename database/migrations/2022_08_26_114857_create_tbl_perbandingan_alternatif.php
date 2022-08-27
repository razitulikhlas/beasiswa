<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPerbandinganAlternatif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_perbandingan_alternatif', function (Blueprint $table) {
            $table->id();
            $table->integer('alternatif1');
            $table->integer('alternatif2');
            $table->integer('pembanding');
            $table->float('nilai',8,6);
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
        Schema::dropIfExists('tbl_perbandingan_alternatif');
    }
}
