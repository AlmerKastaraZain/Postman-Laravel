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
        Schema::create('data_jabatan', function (Blueprint $table) {
            $table->id();

            $table->string('jabatan', 128)->unique();
            $table->float('gaji_pokok', 2);     
            $table->float('tunjangan', 2);     
            $table->float('total', 2);     

            // Foreign Id
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
        Schema::dropIfExists('data_jabatans');
    }
};
