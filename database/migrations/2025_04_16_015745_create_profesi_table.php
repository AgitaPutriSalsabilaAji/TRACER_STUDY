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
        // Tabel kategori_profesi
        Schema::create('kategori_profesi', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_profesi', 50);
            $table->timestamps();
        });

        // Tabel profesi
        Schema::create('profesi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_profesi_id'); // foreign key
            $table->string('nama_profesi', 100);
            $table->timestamps();

            // Tambahkan foreign key constraint
            $table->foreign('kategori_profesi_id')
                  ->references('id')->on('kategori_profesi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesi');
        Schema::dropIfExists('kategori_profesi');
    }
};
