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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_studi_id')->nullable();
            $table->string('nama', 100);
            $table->string('nim', 20);
            $table->date('tanggal_lulus');
            $table->timestamps();

            $table->foreign('program_studi_id')
                  ->references('id')->on('program_studi')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
