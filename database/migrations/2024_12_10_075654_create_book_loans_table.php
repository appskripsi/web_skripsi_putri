<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_peminjaman_buku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('student_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('return_date')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('book_id')
                ->references('id')
                ->on('tbl_buku')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('tbl_mahasiswa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_peminjaman_buku');
    }
};
