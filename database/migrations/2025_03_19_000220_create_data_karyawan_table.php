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
        Schema::create('data_karyawan', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 128);
            $table->char('jenis_kelamin');
            $table->date('tanggal_masuk');
            $table->string('status', 32);

            // Foreign Id
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->on('admins')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('id_data_jabatan');
            $table->foreign('id_data_jabatan')->on('data_jabatan')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_karyawans');
    }
};
