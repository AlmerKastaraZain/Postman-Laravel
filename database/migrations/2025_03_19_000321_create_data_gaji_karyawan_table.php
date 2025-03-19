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
        Schema::create('data_gaji_karyawan', function (Blueprint $table) {
            $table->id();

            $table->float('total_gaji', 2);

            // Foreign Ids
            $table->unsignedBigInteger('id_data_karyawan');
            $table->foreign('id_data_karyawan')->on('data_karyawan')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('id_pot_gaji');
            $table->foreign('id_pot_gaji')->on('set_potongan_gaji')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->on('admins')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_gaji_karyawans');
    }
};
