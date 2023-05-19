<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePterpansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pterpans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('no_induk')->unique();
            $table->string('nama',100);
            $table->enum('status', ['Mahasiswa', 'Dosen', 'Admin']);
            $table->char('tahun_ajaran', 5);
            $table->char('pengambilan', 3);
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
        Schema::dropIfExists('pterpans');
    }
}
