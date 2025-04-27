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
        Schema::create('lulusan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('profesi_id')->nullable(); // nullable
            $table->unsignedBigInteger('jenis_instansi_id')->nullable(); // nullable

            $table->year('tahun_lulus');
            $table->string('no_hp', 20);
            $table->string('email', 100);

            $table->date('tgl_pertama_kerja');
            $table->date('tgl_mulai_kerja_instansi');
            $table->string('nama_instansi', 255);
            $table->string('skala', 100);
            $table->string('lokasi_instansi', 255);
        
            $table->string('nama_atasan_langsung', 100);
            $table->string('jabatan_atasan_langsung', 100);
            $table->string('no_hp_atasan_langsung', 20);
            $table->string('email_atasan_langsung', 100);

            $table->timestamps();

            // Foreign keys
            $table->foreign('alumni_id')
                  ->references('id')->on('alumni')
                  ->onDelete('cascade');

            $table->foreign('profesi_id')
                  ->references('id')->on('profesi')
                  ->nullOnDelete();

            $table->foreign('jenis_instansi_id')
                  ->references('id')->on('jenis_instansi')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lulusan');
    }
};
