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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('judul',255);
            $table->string('slug',255);
            $table->text('tag');
            $table->text('deskripsi');
            $table->text('gambar')->nullable();
            $table->enum('publik',['Ya','Tidak'])->default('Ya');

            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('stat_publikasi',['Ya','Tidak'])->default('Tidak');
            $table->dateTime('waktu_publikasi');
            $table->enum('stat_selesai',['Ya','Tidak'])->default('Tidak');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};