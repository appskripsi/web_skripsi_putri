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
        Schema::create('tbl_buku', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('author', 255);
            $table->string('location');
            $table->string('description');
            $table->string('image');
            $table->integer('stock');
            $table->integer('borrowed')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('academic_id');
            $table->integer('level');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('tbl_kategori')
                ->onDelete('cascade');

            $table->foreign('academic_id')
                ->references('id')
                ->on('tbl_program_studi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_buku');
    }
};
