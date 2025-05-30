<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('lulusan_id');
            $table->string('key_value');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // foreign key constraint
            $table->foreign('alumni_id')->references('id')->on('alumni')->onDelete('cascade');
            $table->foreign('lulusan_id')->references('id')->on('lulusan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys');
    }
};
