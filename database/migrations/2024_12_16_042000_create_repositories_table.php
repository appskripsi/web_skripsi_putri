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
        Schema::create('tbl_repository', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('student_id');
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('academic_id');
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')
                ->on('tbl_mahasiswa')
                ->onDelete('cascade');

            $table->foreign('academic_id')
                ->references('id')
                ->on('tbl_program_studi')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('tbl_tipe_repositori')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_repository');
    }
};
