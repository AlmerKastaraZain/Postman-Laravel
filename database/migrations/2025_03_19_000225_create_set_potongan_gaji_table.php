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
        Schema::create('set_potongan_gaji', function (Blueprint $table) {
            $table->id();

            $table->string('status_kehadiran', 32);
            $table->float('jumlah_potongan', 2);

            // Foreign Ids
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
        Schema::dropIfExists('set_potongan_gajis');
    }
};
