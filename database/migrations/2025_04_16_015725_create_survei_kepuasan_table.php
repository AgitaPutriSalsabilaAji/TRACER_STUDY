<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survei_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumni_id');
            $table->string('nama_surveyor', 100);
            $table->string('instansi', 255);
            $table->string('jabatan', 100);
            $table->string('email', 100);
            $table->integer('ketjasama_tim');
            $table->integer('keahlian_u');
            $table->integer('kemampuan_bahasa_asing');
            $table->integer('kemampuan_komunikasi');
            $table->integer('pengembangan_diri');
            $table->integer('kepemimpinan');
            $table->integer('etos_kerja');
            $table->text('kompetensi_belum_terpenuhi');
            $table->text('saran_kurikulum');
            $table->timestamps();


            $table->foreign('alumni_id')
                  ->references('id')->on('alumni')
                  ->onDelete('cascade');
                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasan');
    }
};
