<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 50);
            $table->text('deskripsi');
            $table->date('mulai');
            $table->date('jatuh_tempo');
            $table->bigInteger('dosen');
            $table->bigInteger('mahasiswa1');
            $table->bigInteger('mahasiswa2');
            $table->bigInteger('mahasiswa3');
            $table->char('tahun_ajaran', 5);
            $table->enum('status', ['0', '1', '2']);
            $table->char('nilai', 50);
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
        Schema::dropIfExists('projects');
    }
}
